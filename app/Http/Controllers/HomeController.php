<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestamo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   public function index()
{
    $user = Auth::user();

    // Agrupar por numero_prestamo y seleccionar el último por fecha_inicio
    $prestamos = Prestamo::where('user_id', $user->id)
        ->orderByDesc('fecha_inicio') // o fecha_fin si prefieres
        ->get()
        ->groupBy('numero_prestamo')
        ->map(function ($grupo) {
            return $grupo->first(); // solo el último de cada grupo
        });

    return view('home', [
        'user' => $user,
        'prestamos' => $prestamos
    ]);
}
}
