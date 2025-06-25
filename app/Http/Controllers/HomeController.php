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
   public function index()
{
    $user = Auth::user();

   /* === 1. Préstamos del más nuevo al más viejo ============== */
        $prestamos = Prestamo::where('user_id', $user->id)
            ->orderBy('fecha_inicio', 'desc')      // 1️⃣ orden principal
            ->get()
            ->groupBy('numero_prestamo')
            ->map(function ($grupo) {              // 2️⃣ para cada número
                // Toma el último registro del grupo (el más reciente)
                return $grupo->sortByDesc('fecha_inicio')->first();
            })
            ->sortByDesc('fecha_inicio');          // 3️⃣ vuelve a ordenar la colección

        /* === 2. ¿Es su cumpleaños hoy? ============================ */
        $cumpleaniosHoy = false;
        if ($user->fecha_nacimiento) {
            $cumpleaniosHoy = Carbon::parse($user->fecha_nacimiento)
                                    ->isSameDay(Carbon::today());
        }

        /* === 3. Préstamos que vencen en <=10 días ================= */
        $proximosVencer = Prestamo::where('user_id', $user->id)
            ->whereBetween('fecha_fin', [Carbon::today(), Carbon::today()->addDays(10)])
            ->orderBy('fecha_fin', 'asc')
            ->get();

        return view('home', compact(
            'user', 'prestamos', 'cumpleaniosHoy', 'proximosVencer'
        ));
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
