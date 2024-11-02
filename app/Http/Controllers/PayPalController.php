<?php

namespace App\Http\Controllers;

use App\Mail\InscriptionSuccess;
use App\Models\Event;
use App\Models\Email;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHTTP\RequestOptions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PayPalController extends Controller
{
    private $client;
    private $clientId;
    private $secret;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('PAYPAL_URI')
        ]);

        $this->clientId = env('PAYPAL_ID');
        $this->secret = env('PAYPAL_SECRET');
    }

    private function generateToken()
    {
        try {
            $response = $this->client->request('POST', '/v1/oauth2/token', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Conten-Type' => 'application/x-www-form-urlencoded'
                ],
                'body' => 'grant_type=client_credentials',
                'auth' => [
                    $this->clientId,
                    $this->secret,
                    'basic'
                ]
            ]);
            $data = json_decode($response->getBody(), true);
            $access_token = $data['access_token'];
            return $access_token;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error($e->getResponse()->getBody()->getContents());
            return null;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . " - " . $e->getTraceAsString());
            return null;
        }
    }
    private function createOrder(float $price, string $price_code, string $description)
    {
        try {
            $token = $this->generateToken();
        } catch (\Exception $e) {
            throw $e;
        }
        if (empty($token)) {
            Log::error("No se puede generar el token, regresa vacío");
            return null;
        }
        try {
            $payload = [
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "description" => $description,
                        "amount" => [
                            "currency_code" => $price_code,
                            "value" => $price
                        ]
                    ]
                ],
                "payment_source" => [
                    "paypal" => [
                        "experience_context" => [
                            "shipping_preference" => "NO_SHIPPING"
                        ],
                        "address" => [
                            "country_code" => "MX"
                        ]
                    ]
                ]
            ];
            $response = $this->client->request('POST', '/v2/checkout/orders', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Conten-Type' => 'application/json'
                ],
                RequestOptions::JSON => $payload,
                'auth' => [
                    $this->clientId,
                    $this->secret,
                    'basic'
                ]
            ]);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error($e->getResponse()->getBody()->getContents());
            return null;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . " - " . $e->getTraceAsString());
            return null;
        }
    }
    protected function captureOrder(string $orderId)
    {
        try {
            $token = $this->generateToken();
        } catch (\Exception $e) {
            throw $e;
        }
        if (empty($token)) {
            Log::error("No se puede generar el token, regresa vacío");
            return null;
        }
        try {

            /**
             * Por algúna razón si hago la peticion con el cliente de la misma manera que los otros metodos,
             * no funciona. 
             * En la peticion de captureOrder, se manda un json con datos, si en esta funcion intento
             * hacerlo parecido pero sin agregar el json (ya que no lleva datos según la documentacion)
             * marca error de que no acepta el tipo de dato, entonces trato de envíarlo vacío y marca un error
             * de json malformado.
             * Entonces es un problema en como se forma la peticion.
             * La genere aqui de esta manera, sin indicar json y la diferencia es que no mando opciones en la 
             * funcion request, y parece funcionar con eso.
             */
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ];
            $client = new Client(['headers' => $headers]);
            $uri = env('PAYPAL_URI') . '/v2/checkout/orders/' . $orderId . '/capture';
            $response = $client->request('POST', $uri);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error($e->getResponse()->getBody()->getContents());
        } catch (\Exception $e) {
            Log::error($e->getMessage() . " - " . $e->getTraceAsString());
            return null;
        }
    }

    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'eventId' => 'required|integer|numeric',
            'name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'phone' => 'required|max:255',
        ], [
            'eventId.required' => 'Se tiene que seleccinar un taller',
            'eventId.integer' => 'Taller id no es entero',
            'eventId.numeric' => 'Taller id no es numerico',
            'name.required' => 'Nombre requerido',
            'name.max' => 'Nombre no puede tener mas de :max caracteres',
            'email.required' => 'Fecha requerida',
            'email.max' => 'Correo no puede tener mas de :max caracteres',
            'email.email' => 'Correo no tiene formato valido',
            'phone.required' => 'Teléfono requerido',
            'phone.max' => 'El teléfono no puede tener mas de :max caracteres',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Se debe seleccionar un taller <br> 
                Se requiere el nombre, correo, teléfono <br>
                y el correo que sea valido',
                'messages' => $validator->errors()
            ], 400);
        }

        $eventId = $request->get("eventId");
        $name = $request->get('name');
        $currMail = $request->get('email');
        $phone = $request->get('phone');
        $ignoreCap = $request->get('ignoreCap');

        $event = Event::find($eventId);
        if ($event == null) {
            return response()->json([
                'message' => 'Disculpe las molestias, pero parece que tenemos un problema encontrando el Taller. <br>
                Tal ves ya esta lleno o esta pausado, puede tratar nuevamente en unos minutos'
            ], 400);
        }

        if ((isset($ignoreCap) && $ignoreCap == false) || $event->orders()->where('status', '=', 'COMPLETED')->count() >= $event->cap) {
            return response()->json([
                'message' => 'Disculpe las molestias, pero el Taller ya esta lleno<br>'
            ], 400);
        }

        $email = Email::where('email', '=', $currMail)->first();
        if ($email == null) {
            $email = new Email;
            $email->email = $currMail;
            $email->name = $name;
        }
        $email->phone = $phone;
        try {
            $email->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage() . " - " . $e->getTraceAsString());
            return response()->json([
                'message' => 'Disculpe las molestias, pero parece que tenemos un problema registrando su correo. <br>
                Puede tratar nuevamente en unos minutos'
            ], 500);
        }

        $description = "Inscripción al taller de " . $name . " " . $event->name;

        if (strlen($description) > 127) {
            $description = substr($description, 0, 124) . "...";
        }

        try {
            $order = $this->createOrder($event->price, "MXN", $description);
            if (isset($order['id'])) {
                $newOrder = new Order;
                $newOrder->order_key = $order['id'];
                $newOrder->status = $order['status'];
                $newOrder->type = 'PAYPAL';
                $newOrder->response = $order;
                $newOrder->event_id = (int) $eventId;
                $newOrder->email_id = (int) $email->id;
                $newOrder->name = $name;
                $newOrder->phone = $phone;
                $newOrder->save();
            }
        } catch (\Exception $e) {
            Log::error("Se inicio la orden " . $order['id'] . " para " . $name . ", pero no se pudo guardar completa.");
            Log::error($e->getMessage() . " - " . $e->getTraceAsString());
            Log::error($order);
            return response()->json([
                'message' => 'Disculpe las molestias, no pudimos procesar el pago, puede tratar 
                nuevamente en unos minutos'
            ], 500);
        }
        Log::info($order);
        if (empty($order)) {
            Log::error("La orden regreso vacía en la peticion. Taller: " . $event . ". Correo" . $currMail);
            return response()->json([
                'message' => 'Disculpe las molestias, no pudimos procesar el pago, puede tratar 
                nuevamente en unos minutos'
            ], 500);
        }
        return response()->json($order);
    }

    public function capture(Request $request, $orderId)
    {
        try {
            $order = $this->captureOrder($orderId);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Disculpe las molestias, no pudimos procesar el pago, puede tratar 
                nuevamente en unos minutos'
            ], 500);
        }
        Log::info($order);
        if (empty($order)) {
            Log::error("La captura de la orden " . $orderId . " regreso vacía en la peticion");
            return response()->json([
                'message' => 'Disculpe las molestias, no pudimos procesar el pago, puede tratar 
                nuevamente en unos minutos'
            ], 500);
        }

        if (isset($order['details']) || !isset($order['purchase_units'])) {
            Log::error("La captura de la orden " . $orderId . " regreso un error.");
            Log::error($order);
            return response()->json($order);
        }

        try {
            $currOrder = Order::where('order_key', '=', $orderId)->first();
            if ($currOrder == null) {
                throw new \Exception("No se encontro la orden con el id " . $orderId);
            }
            $currOrder->status = $order['status'];
            $currOrder->response = $order;
            $currOrder->save();
        } catch (\Exception $e) {
            Log::error("La captura de la orden " . $orderId . " se completo, pero ocurrio un problema
            al guardar la orden.");
            Log::error($e->getMessage() . " - " . $e->getTraceAsString());
            Log::error($order);
            return response()->json($order);
        }

        // Envíar correo
        try {
            Mail::to($currOrder->email->email)->send(new InscriptionSuccess($currOrder));
        } catch (\Exception $e) {
            Log::error("La captura de la orden " . $orderId . " se completo, pero ocurrio un problema
            al enviar el correo.");
            Log::error($e->getMessage() . " - " . $e->getTraceAsString());
        }

        return response()->json($order);
    }
}
