<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Email;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    public function home(): View
    {
        $todayutc = Carbon::createFromTimestampUTC(time());
        $events = Event::where('hide', '=', 0)
            ->where('date', '>=', $todayutc)
            ->orderBy('date', 'asc')
            ->limit(8)
            ->get();

        return view('home', [
            'events' => $events
        ]);
    }
    public function register(): View
    {
        $todayutc = Carbon::createFromTimestampUTC(time());
        $events = Event::where('hide', '=', 0)
            ->where('date', '>=', $todayutc)
            ->orderBy('date', 'asc')
            ->limit(8)
            ->get();

        return view('register', [
            'events' => $events
        ]);
    }

    public function registerComplete(Request $request)
    {
        return view('register-success');
    }

    public function registerCreation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'eventId' => 'required|integer|numeric',
            'name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'phone' => 'max:255',
        ], [
            'eventId.required' => 'Se tiene que seleccinar un taller',
            'eventId.integer' => 'Taller id no es entero',
            'eventId.numeric' => 'Taller id no es numerico',
            'name.required' => 'Necesitamos un nombre para identificarte',
            'name.max' => 'Nombre no puede tener mas de :max caracteres',
            'email.required' => 'Necesitamos un correo',
            'email.max' => 'Correo no puede tener mas de :max caracteres',
            'email.email' => 'Correo no tiene formato valido',
            'phone.max' => 'El teléfono no puede tener mas de :max caracteres',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
            ;
        }

        $eventId = $request->get("eventId");
        $name = $request->get('name');
        $currMail = $request->get('email');
        $phone = $request->get('phone');
        $ignoreCap = $request->get('ignoreCap');

        $event = Event::find($eventId);
        if ($event == null) {
            return back()
                ->with([
                    'notification-warning' => 'Disculpe las molestias, pero parece que tenemos un problema encontrando 
                    el taller. <br> Tal ves ya esta lleno o esta pausado, puede tratar nuevamente en unos minutos'
                ])
                ->withInput();
        }

        if (
            (isset($ignoreCap) && $ignoreCap == false)
            || $event->orders()->where('status', '=', 'COMPLETED')->count() >= $event->cap
        ) {
            return back()
                ->with([
                    'notification-warning' => 'Disculpe las molestias, pero el taller ya esta lleno'
                ])
                ->withInput();
            ;
        }

        if ($event->price > 0) {
            return back()
                ->with([
                    'notification-warning' => 'Este taller tiene un costo, no se puede inscribir por este medio'
                ])
                ->withInput();
            ;
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

        $newOrder = Order::where('email_id', '=', $email->id)
            ->where('event_id', '=', $event->id)
            ->first();

        if ($newOrder) {
            return back()
                ->with([
                    'notification-warning' => 'Tenemos buenas noticias, parece que el correo ya esta registrado
                    en este taller.'
                ])
                ->withInput();
            ;
        }

        try {
            $randomizer = new \Random\Randomizer();

            $newOrder = new Order;
            $newOrder->order_key = 'SYS-' . $randomizer->getBytesFromString('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 13);
            $newOrder->status = 'COMPLETED';
            $newOrder->type = 'SYSTEM';
            $newOrder->response = NULL;
            $newOrder->event_id = (int) $event->id;
            $newOrder->email_id = (int) $email->id;
            $newOrder->phone = $phone;
            $newOrder->name = $name;
            $newOrder->save();
        } catch (\Exception $e) {
            Log::error("Se inicio la orden " . $newOrder->order_key . " para " . $name .
                ", pero no se pudo guardar completa.");
            Log::error($e->getMessage() . " - " . $e->getTraceAsString());
            Log::error($newOrder);
            return back()
                ->with([
                    'notification-warning' => 'Disculpe las molestias, no pudimos procesar el pago, puede tratar
                    nuevamente en unos minutos'
                ])
                ->withInput();
            ;
        }

        return to_route('register-complete');
    }
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|email',
        ], [
            'email.required' => 'Necesitamos un correo',
            'email.max' => 'Correo no puede tener mas de :max caracteres',
            'email.email' => 'Correo no tiene formato valido',
        ]);

        if ($validator->fails()) {
            return back()
                ->with([
                    'notification-warning' => 'Por favor escriba un correo donde enviaremos las notificaciones'
                ])
                ->withInput();
            ;
        }
        $currMail = $request->get('email');
        $phone = $request->get('phone');
        $email = Email::where('email', '=', $currMail)->first();
        try {
            if ($email == null) {
                $email = new Email;
                $email->email = $currMail;
                $email->name = '';
                $email->phone = $phone;
            }
            $email->newsletter = true;
            $email->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage() . " - " . $e->getTraceAsString());
            return back()
                ->with([
                    'notification-warning' => 'Disculpe las molestias, pero parece que tenemos un problema
                        registrando su correo. <br> Puede tratar nuevamente en unos minutos'
                ])
                ->withInput();
            ;
        }
        return to_route('subscribe-complete');
    }

    public function subscribeComplete(Request $request)
    {
        return view('subscribe-success');
    }
}
