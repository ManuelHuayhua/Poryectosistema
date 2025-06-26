<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;

class PrestamoPendienteController extends Controller
{
      public function index()
    {
         if (
        ! Auth::check() ||                // no ha iniciado sesión
        ! Auth::user()->is_admin ||       // no es admin
        ! Auth::user()->des_contrato            // admin pero sin permiso de "inicio"
    ) {
        abort(403, 'Acceso no autorizado.');
    }

        $prestamos = Prestamo::with('user')
            ->where('estado', 'pendiente')
            ->get();

        return view('admin.prestamos_pendientes', compact('prestamos'));
    }
}
