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
            !Auth::check() ||
            !Auth::user()->is_admin ||
            !Auth::user()->des_contrato
        ) {
            abort(403, 'Acceso no autorizado.');
        }

        $prestamos = Prestamo::with('user')
            ->whereNotIn('estado', ['rechazado', 'pendiente']) // excluir rechazado y pendiente
            ->iniciales()                                      // filtro personalizado item_prestamo = 1
            ->orderBy('fecha_inicio', 'desc')                    // ordenar por fecha de creación (últimos primeros)
            ->get();

        return view('admin.prestamos_pendientes', compact('prestamos'));
    }
}