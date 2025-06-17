<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function create()
    {
        return view('admin.createuser');
    }

    public function store(Request $request)
    {
        $request->validate([
        'name'              => 'required|string|max:255',
        'apellido_paterno'  => 'required|string|max:255',
        'apellido_materno'  => 'required|string|max:255',
        'nacionalidad'      => 'required|string|max:255',
        'sexo'              => 'required|string|max:255',
        'estado_civil'      => 'required|string|max:255',
        'fecha_nacimiento'  => 'nullable|date',
        'telefono'          => 'nullable|string|max:20',
        'celular'           => 'nullable|string|max:20',
        'direccion'         => 'nullable|string|max:255',
        'tipo_origen'       => 'nullable|string|max:255',
        'email'             => 'required|email|unique:users',
        'password'          => 'required|min:6|confirmed',
        'dni' => 'nullable|string|max:20',
    ]);

        User::create([
        'name'              => $request->name,
        'apellido_paterno'  => $request->apellido_paterno,
        'apellido_materno'  => $request->apellido_materno,
        'nacionalidad'      => $request->nacionalidad,
        'sexo'              => $request->sexo,
        'estado_civil'      => $request->estado_civil,
        'fecha_nacimiento'  => $request->fecha_nacimiento,
        'telefono'          => $request->telefono,
        'celular'           => $request->celular,
        'direccion'         => $request->direccion,
        'tipo_origen'       => $request->tipo_origen,
        'email'             => $request->email,
        'password'          => Hash::make($request->password),
        'is_admin'          => $request->boolean('is_admin'),
          'dni'               => $request->dni,
    ]);

        return redirect()->route('admin.createuser')->with('success', 'Usuario creado exitosamente.');
    }
}
