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
        // 1. Usuario autenticado
        $user = Auth::user();          // o bien Auth::id() si solo necesitas el ID

        // 2. Préstamos de ese usuario
        $prestamos = Prestamo::where('user_id', $user->id)   // <-- filtro por el usuario
            ->orderByDesc('numero_prestamo')                // orden descendente
            ->get()
            ->groupBy('numero_prestamo');       

        // 3. Renderiza la vista
        return view('reporteuser', compact('prestamos'));
    }
}