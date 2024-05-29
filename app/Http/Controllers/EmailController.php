<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmailController extends Controller
{
    private $messages = [
        'name.required' => 'Nombre requerido',
        'name.max' => 'Nombre no puede tener mas de :max caracteres',
        'email.required' => 'Correo requerido',
        'email.max' => 'Correo no puede tener mas de :max caracteres',
        'email.email' => 'Correo invalido',
        'email.unique' => 'Ya esta registrado este correo',
        'phone.max' => 'El teléfono no puede tener mas de :max caracteres',
    ];

    private $rules = [
        'name' => 'required|max:255',
        'email' => 'required|max:255|email|unique:emails,email',
        'phone' => 'max:255',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session(['email:index' => url()->full()]);
        $emails = Email::orderBy('name', 'asc')
            ->paginate(20);

        return view('admin.emails.list', [
            'emails' => $emails
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.emails.form');
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

        $email = new Email;
        $email->name = $request->input('name');
        $email->email = $request->input('email');
        $email->phone = $request->input('phone');
        if ($request->has('newsletter'))
            $email->newsletter = 1;
        else
            $email->newsletter = 0;
        $email->save();

        return to_route('correos.index')
            ->with('notification-success', 'Añadimos el correo ' . $email->name);
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
        $email = Email::where('id', '=', $id)->first();
        return view('admin.emails.form', ['email' => $email]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $auxRules = $this->rules;
        $auxRules['email'] = [
            'required',
            Rule::unique('emails')->ignore($id),
            'max:255',
            'email'
        ];
        $validator = Validator::make($request->all(), $auxRules, $this->messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $email = Email::where('id', '=', $id)->first();

        if ($email == null) {
            return back()
                ->withErrors(['invalid' => 'No se encontro el correo para actualizar'])
                ->withInput();
        }

        $email->name = $request->input('name');
        $email->email = $request->input('email');
        $email->phone = $request->input('phone');
        if ($request->has('newsletter'))
            $email->newsletter = 1;
        else
            $email->newsletter = 0;
        $email->save();

        return to_route('correos.index')
            ->with('notification-success', 'Se actualizo el correo ' . $email->name);
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
        $emails = Email::where('email', 'like', $word)
            ->orderBy('email', 'asc')
            ->limit(50)
            ->get();
        return response()->json(['correos' => $emails]);
    }
}
