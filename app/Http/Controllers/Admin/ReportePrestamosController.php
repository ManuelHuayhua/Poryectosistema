<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;
class ReportePrestamosController extends Controller
{
   public function index(Request $request)
    {
         if (
        ! Auth::check() ||                // no ha iniciado sesión
        ! Auth::user()->is_admin ||       // no es admin
        ! Auth::user()->ge_reportes           
    ) {
        abort(403, 'Acceso no autorizado.');
    }


        /* ---------- A. Filtros por usuario ---------- */
        $usuarioFiltro = function ($q) use ($request) {
            if ($request->filled('dni')) {
                $dni = trim($request->dni);
                $q->where('dni', 'like', "%{$dni}%");
            }

            if ($request->filled('nombre')) {
                $txt = trim($request->nombre);
                $q->where(function ($s) use ($txt) {
                    $s->where('name', 'like', "%{$txt}%")
                      ->orWhere('apellido_paterno', 'like', "%{$txt}%");
                });
            }
        };

        /* ---------- B. Parámetros ---------- */
        $desde  = $request->desde;
        $hasta  = $request->hasta;
        $estado = $request->filled('estado') ? Str::lower($request->estado) : null; // pagado, aprobado, etc.

        /* ---------- C. Paso 1: números de préstamo por fecha ---------- */
        $prestamosIdQuery = Prestamo::select('numero_prestamo')
            ->whereHas('user', $usuarioFiltro)
            ->when($estado, fn ($q) => $q->where('estado', $estado));

        if ($desde || $hasta) {
            $prestamosIdQuery->where(function ($q) use ($desde, $hasta) {
                if ($desde && $hasta) {
                    $q->whereBetween('fecha_inicio', [$desde, $hasta])
                      ->orWhereBetween('fecha_fin',   [$desde, $hasta]);
                } elseif ($desde) {
                    $q->where('fecha_fin', '>=', $desde);
                } else { // solo $hasta
                    $q->where('fecha_inicio', '<=', $hasta);
                }
            });
        }

        $numerosMatch = $prestamosIdQuery->pluck('numero_prestamo')->unique();

        /* ---------- D. Paso 2: traer los ítems definitivos ---------- */
        $query = Prestamo::with('user')
            ->whereHas('user', $usuarioFiltro)
            ->when($estado, fn ($q) => $q->where('estado', $estado));   // <- AQUÍ SÍ se aplica el estado

        if ($desde || $hasta) {
            $query->whereIn('numero_prestamo', $numerosMatch);
        }

        $prestamosAgrupados = $query->orderBy('numero_prestamo')
            ->orderBy('item_prestamo')
            ->get()
            ->groupBy('user_id')
            ->map(fn ($c) => $c->groupBy('numero_prestamo'));

        /* ---------- E. Vista ---------- */
        return view('admin.reporte_prestamos', [
            'prestamosAgrupados' => $prestamosAgrupados,
            'dni'     => $request->dni,
            'nombre'  => $request->nombre,
            'desde'   => $desde,
            'hasta'   => $hasta,
            'estado'  => $estado,   // para mantener seleccionado el <option>
        ]);
    }
}
