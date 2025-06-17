<?php

namespace App\Http\Controllers;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TablaUsuario;
class ReporteUserController extends Controller
{
 public function index()
{
    $prestamos = TablaUsuario::with('prestamo', 'user')
        ->orderBy('fecha_prestamos', 'desc')
        ->get()
        ->groupBy('numero_prestamo');

    return view('reporteuser', compact('prestamos'));
}
}