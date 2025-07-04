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
use Illuminate\Validation\ValidationException;
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
        'monto'   => 'required|numeric|min:0.01',   // ↓ quítala si cada pago ya trae su propio monto
        'pagos'   => 'required|array',
        'pagos.*' => 'exists:pago_reportes,id',
    ]);

    $filasActualizadas = 0;

    DB::transaction(function () use ($request, &$filasActualizadas) {

        /* 1) Traer sólo los pagos aún pendientes, bloqueándolos
              para evitar dobles cobros en concurrencia */
        $pagosPendientes = PagoReporte::whereIn('id', $request->pagos)
            ->where('estado', '!=', 'PAGADO')
            ->lockForUpdate()
            ->get();

        if ($pagosPendientes->isEmpty()) {
            throw ValidationException::withMessages([
                'pagos' => 'Los pagos seleccionados ya estaban en estado PAGADO.',
            ]);
        }

        foreach ($pagosPendientes as $pago) {

            // 2) Actualizar el pago individual
            $pago->update([
                // si cada pago ya tiene monto propio, omite la siguiente línea
                'monto'      => $request->monto,
                'estado'     => 'PAGADO',
                'updated_at' => now(),
            ]);

            // 3) Incrementar el saldo del periodo
            $periodo = $pago->cajaPeriodo;          // relación belongsTo
            $periodo->increment('saldo_actual', $pago->monto);

            // 4) Registrar movimiento
            CajaMovimiento::create([
                'caja_periodo_id'  => $periodo->id,
                'monto'            => $pago->monto,
                'descripcion'      => 'aporteingresado', // pon la que gustes
                'saldo_resultante' => $periodo->saldo_actual, // ya trae el nuevo saldo
            ]);

            ++$filasActualizadas;
        }
    });

    return back()->with(
        'success',
        "Se pagaron {$filasActualizadas} registro(s) correctamente."
    );
}


 
}