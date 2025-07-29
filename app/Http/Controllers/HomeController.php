<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestamo;
use Carbon\Carbon;   
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

    //se realizo modificacion para ver detalle de prestamo y en el blade tabien home.blade

public function index()
{
    $user = Auth::user();

    $todosPrestamos = Prestamo::where('user_id', $user->id)
        ->orderBy('fecha_inicio', 'desc')
        ->get();

    // Últimos préstamos por numero_prestamo
    $ultimosPrestamos = $todosPrestamos
        ->groupBy('numero_prestamo')
        ->map(fn($grupo) => $grupo->sortByDesc('item_prestamo')->first()) // 👈 ordena por ítem
        ->sortByDesc('numero_prestamo')
        ->values();

    // Agrupa historial por numero_prestamo
   $historialPorNumero = $todosPrestamos
    ->groupBy('numero_prestamo')
    ->map(function ($grupo) {
        return $grupo
            ->filter(function ($prestamo) {
                return !in_array(strtolower($prestamo->descripcion), ['cancelado', 'diferencia', 'renovar']);
            })
            ->sortByDesc('item_prestamo');
    });

    // Cumpleaños
    $cumpleaniosHoy = $user->fecha_nacimiento
        ? Carbon::parse($user->fecha_nacimiento)->isSameDay(Carbon::today())
        : false;

    // Préstamos por vencer
    $proximosVencer = $todosPrestamos->filter(function ($p) {
        return $p->fecha_fin && Carbon::parse($p->fecha_fin)
            ->between(Carbon::today(), Carbon::today()->addDays(10));
    });

    return view('home', [
        'user' => $user,
        'prestamos' => $ultimosPrestamos,
        'prestamosTodos' => $todosPrestamos,
        'historialPorNumero' => $historialPorNumero, // 👈 importante
        'cumpleaniosHoy' => $cumpleaniosHoy,
        'proximosVencer' => $proximosVencer,
    ]);
}

 //se realizo modificacion para ver detalle de prestamo arriba y el blade se modifco home.blade



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
