<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    
    public function create()
{
    if (
        ! Auth::check() ||                // no ha iniciado sesión
        ! Auth::user()->is_admin ||       // no es admin
        ! Auth::user()->usuarios            // admin pero sin permiso de "inicio"
    ) {
        abort(403, 'Acceso no autorizado.');
    }

    $usuarios = User::all(); // 👈 agregamos esto
    return view('admin.createuser', compact('usuarios'));
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
         'email'             => 'nullable|email|unique:users', // ✅ Cambiado aquí
        'password'          => 'required|min:6|confirmed',
        'dni' => 'required|string|max:20|unique:users',
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

//cambiar contraseña de usuario
    // Mostrar tabla de usuarios
public function index()
{
    $usuarios = User::all();
    return view('admin.usuarios', compact('usuarios'));
}

// Mostrar formulario para cambiar contraseña
public function editPassword($id)
{
    $usuario = User::findOrFail($id);
    return view('admin.cambiar-password', compact('usuario'));
}

// Guardar nueva contraseña
public function updatePassword(Request $request, $id)
{
    $request->validate([
        'password' => 'required|min:6|confirmed',
    ]);

    $usuario = User::findOrFail($id);
    $usuario->password = Hash::make($request->password);
    $usuario->save();

   return redirect()->route('admin.createuser')->with('success_password', 'Contraseña actualizada correctamente.');


}

public function updateUser(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'apellido_paterno' => 'required|string|max:255',
        'apellido_materno' => 'nullable|string|max:255',
        'email' => 'nullable|email',
        'dni' => 'nullable|string|max:20',
        'telefono' => 'nullable|string|max:20',
        'sexo' => 'nullable|string|max:20',
        'estado_civil' => 'nullable|string|max:50',
        'fecha_nacimiento' => 'nullable|date',
        'nacionalidad' => 'nullable|string|max:50',
        'direccion' => 'nullable|string|max:255',
        'tipo_origen' => 'nullable|string|max:50',
         'is_admin' => 'required|in:0,1',
         'inicio'        => 'required|in:0,1',
        'usuarios'      => 'required|in:0,1',
        'des_contrato'  => 'required|in:0,1',
        'configuracion' => 'required|in:0,1',
        'ge_prestamo'   => 'required|in:0,1',
        'ge_reportes'   => 'required|in:0,1',
        'grafica'       => 'required|in:0,1',
        'aporte'  => 'required|in:0,1',  
    ]);

    $usuario = User::findOrFail($request->id);
    $usuario->update([
        'name' => $request->name,
        'apellido_paterno' => $request->apellido_paterno,
        'apellido_materno' => $request->apellido_materno,
        'email' => $request->email,
        'dni' => $request->dni,
        'telefono' => $request->telefono,
        'sexo' => $request->sexo,
        'estado_civil' => $request->estado_civil,
        'fecha_nacimiento' => $request->fecha_nacimiento,
        'nacionalidad' => $request->nacionalidad,
        'direccion' => $request->direccion,
        'tipo_origen' => $request->tipo_origen,
          'is_admin' => $request->is_admin,
          'inicio'        => $request->boolean('inicio'),
        'usuarios'      => $request->boolean('usuarios'),
        'des_contrato'  => $request->boolean('des_contrato'),
        'configuracion' => $request->boolean('configuracion'),
        'ge_prestamo'   => $request->boolean('ge_prestamo'),
        'ge_reportes'   => $request->boolean('ge_reportes'),
        'grafica'       => $request->boolean('grafica'),
        'aporte'  => $request->boolean('aporte'),
        
    ]);

    return redirect()->back()->with('success_password', 'Datos del usuario actualizados correctamente.');
}

}
