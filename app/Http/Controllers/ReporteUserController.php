<?php

namespace App\Http\Controllers;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporteUserController extends Controller
{
    public function mostrarReporte()
    {
        $userId = Auth::id();

        $prestamos = Prestamo::with('penalidades')
                      ->where('user_id', $userId)
                      ->orderBy('created_at', 'desc') // Ordenamos por fecha de creación
                      ->get();

        // Agrupamos por numero_prestamo
       
        $prestamos_grouped = $prestamos->sortByDesc('numero_prestamo')->groupBy('numero_prestamo');

        return view('reporteuser', compact('prestamos_grouped'));
    }
}