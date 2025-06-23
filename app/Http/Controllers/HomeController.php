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
        ->orderBy('fecha_inicio', 'asc') // o fecha_fin si prefieres
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

public function notificarPago($id)
{
    $prestamo = Prestamo::findOrFail($id);

    // Verificamos que el préstamo sea del usuario autenticado
    if ($prestamo->user_id !== auth()->id()) {
        abort(403, 'No autorizado');
    }

    $prestamo->notificacion_pago = 1;
    $prestamo->save();

    return redirect()->back()->with('success', 'Notificación de pago registrada.');
}

public function marcarLeido($id)
{
    $prestamo = Prestamo::findOrFail($id);

    if ($prestamo->notificacion_pago == 1) {
        $prestamo->notificacion_pago = 2;
        $prestamo->save();
    }

    return redirect()->back()->with('success', 'Marcado como leído correctamente.');
}

}
