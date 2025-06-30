<?php

namespace App\Http\Controllers\Admin;
use App\Models\Aporte;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CajaPeriodo;
use App\Models\CajaMovimiento;
use App\Models\PagoReporte;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
class PagoReporteController extends Controller
{

    public function create()
    {
        $aportes  = Aporte::all();
        $periodos = CajaPeriodo::vigente()->get();   // solo vigente
        return view('admin.pago_reportes_create', compact('aportes','periodos'));
    }

    public function generarPorPeriodo(Request $request)
    {
        $request->validate([
            'caja_periodo_id' => 'required|exists:caja_periodo,id',
        ]);

        $periodo = CajaPeriodo::findOrFail($request->caja_periodo_id);

        // ⛔ Si ya hay pagos para este período, no continuar
     $yaExistenPagos = PagoReporte::where('caja_periodo_id', $periodo->id)->exists();
    if ($yaExistenPagos) {
        return back()->withErrors('Ya existen pagos generados para este período.')->withInput();
    }

        if ($periodo->periodo_fin->lt(now()->startOfDay())) {
            return back()
              ->withErrors('El período seleccionado ya está cerrado.')
              ->withInput();
        }

        // 1️⃣ Obtiene todos los clientes
        $aportes = Aporte::all(['id']);

        // 2️⃣ Calcula los domingos dentro del rango
        $domingos = collect(
            CarbonPeriod::create(
                $periodo->periodo_inicio->startOfWeek(Carbon::SUNDAY),
                '1 week',
                $periodo->periodo_fin->endOfWeek(Carbon::SUNDAY)
            )->filter(function (Carbon $date) use ($periodo) {
                return $date->between($periodo->periodo_inicio, $periodo->periodo_fin)
                       && $date->isSunday();
            })
        );

        // 3️⃣ Inserta en lote
        $rows = [];
        foreach ($aportes as $ap) {
            foreach ($domingos as $fecha) {
                $rows[] = [
                    'aporte_id'       => $ap->id,
                    'caja_periodo_id' => $periodo->id,
                      'monto'           => 0.00,           // Vacío
                    'fecha_pago'      => $fecha->toDateString(),
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            }
        }

        DB::table('pago_reportes')->insert($rows);

        return back()->with('success',
            'Se generaron '.count($rows).' pagos vacíos: '
            .$aportes->count().' clientes × '.$domingos->count().' domingos.'
        );
    }

public function pagar(Request $request)
{
    $request->validate([
        'monto'  => 'required|numeric|min:0.01',
        'pagos'  => 'required|array',
        'pagos.*'=> 'exists:pago_reportes,id',
    ]);

    $filasActualizadas = 0;

    DB::transaction(function () use ($request, &$filasActualizadas) {

        /* 1) Cambiar estado a PAGADO */
        $filasActualizadas = PagoReporte::whereIn('id', $request->pagos)
            ->where('estado', '!=', 'PAGADO')
            ->update([
                // ⚠️ Si cada pago tiene su propio monto,
                // quita la línea de abajo y no sobrescribas.
                'monto'      => $request->monto,
                'estado'     => 'PAGADO',
                'updated_at' => now(),
            ]);

        if ($filasActualizadas === 0) {
            // dentro de la transacción lanza excepción
            throw \Illuminate\Validation\ValidationException::withMessages([
                'pagos' => 'Los pagos seleccionados ya estaban en estado PAGADO.',
            ]);
        }

        /* 2) Agrupar los IDs recién actualizados
              por periodo y fecha_pago */
        $grupos = PagoReporte::whereIn('id', $request->pagos)
            ->select('caja_periodo_id', 'fecha_pago')
            ->get()
            ->groupBy(fn ($p) => $p->caja_periodo_id . '|' . $p->fecha_pago);

        foreach ($grupos as $clave => $coleccion) {
            [$periodoId, $fecha] = explode('|', $clave);

            // 3) ¿Queda algo de esa fecha sin pagar?
            $pendiente = PagoReporte::where('caja_periodo_id', $periodoId)
                ->whereDate('fecha_pago', $fecha)
                ->where('estado', '!=', 'PAGADO')
                ->exists();

            if ($pendiente) {
                continue; // aún no se completa la semana; no sumes nada
            }

            // 4) Todo pagado ➜ suma e incrementa saldo_actual
            $totalDia = PagoReporte::where('caja_periodo_id', $periodoId)
                ->whereDate('fecha_pago', $fecha)
                ->sum('monto');

            CajaPeriodo::where('id', $periodoId)
                ->increment('saldo_actual', $totalDia);

            /* (Opcional) registra el movimiento solo una vez */
            CajaMovimiento::create([
                'caja_periodo_id'  => $periodoId,
                'monto'            => $totalDia,
                'concepto'         => "Ingresos del $fecha",
                // saldo_resultante después del incremento
                'saldo_resultante' => CajaPeriodo::find($periodoId)->saldo_actual,
            ]);
        }
    });

    return back()->with(
        'success',
        "Se pagaron {$filasActualizadas} registro(s) correctamente."
    );
}


 
}