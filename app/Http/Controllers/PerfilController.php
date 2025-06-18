<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class PerfilController extends Controller
{
     public function show()
    {
        $usuario = Auth::user(); // Obtener usuario autenticado
        return view('perfil', compact('usuario'));
    }


    public function cambiarPassword(Request $request)
{
    $request->validate([
        'password' => 'required|min:6|confirmed',
    ]);

    $usuario = auth()->user();
    $usuario->password = Hash::make($request->password);
    $usuario->save();

    return redirect()->route('perfil')->with('success_password', 'Contraseña actualizada correctamente.');
}
}
