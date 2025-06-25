<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;
class ReportePrestamosController extends Controller
{
  public function index(Request $request)
    {
        /* =========================================================
         *  A.  Filtros por usuario (DNI / nombre-apellido)
         * =========================================================*/
        $usuarioFiltro = function ($q) use ($request) {
            if ($request->filled('dni')) {
                $dni = trim($request->dni);
                $q->where('dni', 'like', "%{$dni}%");
            }
            if ($request->filled('nombre')) {
                $txt = trim($request->nombre);
                $q->where(function ($s) use ($txt) {
                    $s->where('name',             'like', "%{$txt}%")
                      ->orWhere('apellido_paterno','like', "%{$txt}%");
                });
            }
        };

        /* =========================================================
         *  B.  1er paso → obtener números de préstamo que encajan
         *       con el rango de fechas (si lo hay)
         * =========================================================*/
        $desde = $request->desde;
        $hasta = $request->hasta;

        $prestamosIdQuery = Prestamo::query()->select('numero_prestamo');

        // unimos con users para que usuarioFiltro funcione
        $prestamosIdQuery->whereHas('user', $usuarioFiltro);

        // solo añadimos filtro de fechas si el usuario lo pidió
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

        // obtenemos la lista (array) de números de préstamo
        $numerosMatch = $prestamosIdQuery->pluck('numero_prestamo')->unique();

        /* =========================================================
         *  C.  2º paso → traer TODOS los ítems de esos préstamos
         * =========================================================*/
        $query = Prestamo::with('user')
            ->whereHas('user', $usuarioFiltro);

        // si el usuario puso rango, filtramos por la lista recabada
        if ($desde || $hasta) {
            $query->whereIn('numero_prestamo', $numerosMatch);
        }

        /* Orden & agrupación */
        $prestamosAgrupados = $query->orderBy('numero_prestamo')
            ->orderBy('item_prestamo')
            ->get()
            ->groupBy('user_id')
            ->map(fn ($c) => $c->groupBy('numero_prestamo'));

        /* Vista */
        return view('admin.reporte_prestamos', [
            'prestamosAgrupados' => $prestamosAgrupados,
            'dni'    => $request->dni,
            'nombre' => $request->nombre,
            'desde'  => $desde,
            'hasta'  => $hasta,
        ]);
    }
}
