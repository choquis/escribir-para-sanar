<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class EventController extends Controller
{
    private $messages = [
        'name.required' => 'Nombre requerido',
        'name.max' => 'Nombre no puede tener mas de :max caracteres',
        'date.required' => 'Fecha requerida',
        'date.date' => 'Debe ser una fecha',
        'date.date_format' => 'Fecha debe tener formato d/m/y',
        'time.required' => 'Tiempo requerido',
        'time.date_format' => 'Tiempo debe tener formato h:m',
        'cap.required' => 'Capacidad requerida',
        'cap.numeric' => 'Capacidad tiene que ser numerico',
        'cap.integer' => 'Capacidad no debe tener decimales',
        'cap.gt' => 'Capacidad acepta minimo 1',
        'cap.lte' => 'Capacidad acepta maximo 100',
        'price.required' => 'Precio requerido',
        'price.gt' => 'Precio minimo de 0'
    ];

    private $rules = [
        'name' => 'required|max:255',
        'date' => 'required|date|date_format:Y-m-d',
        'time' => 'required|date_format:H:i',
        'cap' => 'required|numeric|integer|gt:0|lte:100',
        'price' => 'required|gt:-1'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session(['event:index' => url()->full()]);
        $events = Event::withCount([
            'orders' => function (Builder $query) {
                $query->where('status', '=', 'COMPLETED');
            }
        ])
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('admin.events.list', [
            'events' => $events
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.form');
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

        $event = new Event;
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->subdescription = $request->input('subdescription');
        $date = new Carbon($request->input('date') . ' ' . $request->input('time') . ':00', 'America/Monterrey');
        $date->setTimezone('UTC');
        $event->date = $date;
        $event->cap = $request->input('cap');
        $event->price = $request->input('price');
        $event->mailContent = $request->input('mailContent');
        $event->hide = false;
        $event->save();

        return to_route('eventos.index')
            ->with('notification-success', 'Añadimos el taller ' . $event->name);
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
        $event = Event::where('id', '=', $id)->first();
        return view('admin.events.form', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $event = Event::where('id', '=', $id)->first();

        if ($event == null) {
            return back()
                ->withErrors(['invalid' => 'No se encontro el taller para actualizar'])
                ->withInput();
        }

        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->subdescription = $request->input('subdescription');
        $date = new Carbon($request->input('date') . ' ' . $request->input('time') . ':00', 'America/Monterrey');
        $date->setTimezone('UTC');
        $event->date = $date;
        $event->cap = $request->input('cap');
        $event->price = $request->input('price');
        $event->mailContent = $request->input('mailContent');
        if ($request->has('hide'))
            $event->hide = 1;
        else
            $event->hide = 0;
        $event->save();

        return to_route('eventos.index')
            ->with('notification-success', 'Se actualizo el taller ' . $event->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function search(Request $request)
    {
        $word = '%' . $request->input("word") . '%';
        $events = Event::where('name', 'like', $word)
            ->orWhere('date', 'like', $word)
            ->orderBy('name', 'asc')
            ->orderBy('date', 'desc')
            ->limit(50)
            ->get();
        return response()->json(['eventos' => $events]);
    }
}
