<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Email;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    private $messages = [
        //'order_key.required' => 'Id de orden requerido',
        //'order_key.max' => 'Id de orden no puede tener mas de :max caracteres',
        //'order_key.unique' => 'Id de orden ya esta registrado',
        'status.required' => 'Estado requerido',
        'status.max' => 'Estado no puede tener mas de :max caracteres',
        'name.required' => 'Nombre requerido',
        'name.max' => 'Nombre no puede tener mas de :max caracteres',
        'email_id.required' => 'Se tiene que seleccionar un correo',
        'event_id.required' => 'Se tiene que seleccionar un taller',
    ];

    private $rules = [
        //'order_key' => 'required|max:255|unique:orders,order_key',
        'status' => 'required|max:255',
        'name' => 'required|max:255',
        'email_id' => 'required',
        'event_id' => 'required'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session(['order:index' => url()->full()]);
        $orders = Order::orderBy('created_at', 'desc')
            ->paginate(3);

        return view('admin.orders.list', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.orders.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $email_id = $request->input('email_id');
        $email = Email::where('id', '=', $email_id)->first();
        if ($email == null) {
            return back()
                ->withErrors(['invalid' => 'No se encontro el correo seleccionado'])
                ->withInput();
        }

        $event_id = $request->input('event_id');
        $event = Event::where('id', '=', $event_id)->first();
        if ($event == null) {
            return back()
                ->withErrors(['invalid' => 'No se encontro el taller seleccionado'])
                ->withInput();
        }

        $randomizer = new \Random\Randomizer();
        $order = new Order;
        $order->order_key = 'SYS-' . $randomizer->getBytesFromString('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 13);
        $order->status = $request->input('status');
        $order->type = 'SYSTEM';
        $order->response = null;
        $order->email_id = $email_id;
        $order->event_id = $event_id;
        $order->name = $request->input('name');
        $order->save();

        return to_route('ordenes.index')
            ->with('notification-success', 'Añadimos la orden ' . $order->order_key);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::where('id', '=', $id)->first();
        return view('admin.orders.form', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $auxRules = $this->rules;
        $auxRules['order_key'] = [
            Rule::unique('orders')->ignore($id),
            'max:255'
        ];
        $validator = Validator::make($request->all(), $auxRules, $this->messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $order = Order::where('id', '=', $id)->first();
        if ($order == null) {
            return back()
                ->withErrors(['invalid' => 'No se encontro la orden para actualizar'])
                ->withInput();
        }

        $email_id = $request->input('email_id');
        $email = Email::where('id', '=', $email_id)->first();
        if ($email == null) {
            return back()
                ->withErrors(['invalid' => 'No se encontro el correo seleccionado'])
                ->withInput();
        }

        $event_id = $request->input('event_id');
        $event = Event::where('id', '=', $event_id)->first();
        if ($event == null) {
            return back()
                ->withErrors(['invalid' => 'No se encontro el taller seleccionado'])
                ->withInput();
        }

        $order->status = $request->input('status');
        $order->email_id = $email->id;
        $order->event_id = $event->id;
        $order->name = $request->input('name');
        $order->save();

        return to_route('ordenes.index')
            ->with('notification-success', 'Se actualizo la orden ' . $order->order_key);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
