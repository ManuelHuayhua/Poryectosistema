<?php

namespace App\Models;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
class CajaPeriodo extends Model
{
    protected $table = 'caja_periodo';
    
     protected $fillable = [
        'monto_inicial',
        'saldo_actual',
        'periodo_inicio',
        'periodo_fin',
    ];

    protected $dates = [
        'periodo_inicio',
        'periodo_fin',
        'created_at',
        'updated_at',
    ];

    // Relación con préstamos (si Prestamo tiene un campo caja_periodo_id)
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    public function movimientos()
    {
        return $this->hasMany(CajaMovimiento::class);
    }

    public function registrarMovimiento(float $monto, string $tipo = 'ingreso', ?string $descripcion = null)
    {
        return DB::transaction(function () use ($monto, $tipo, $descripcion) {
            // Si es egreso, podrías pasar el monto negativo O restar manualmente.
            $this->increment('saldo_actual', $monto);

            return $this->movimientos()->create([
                'monto'            => $monto,
                'saldo_resultante' => $this->saldo_actual,   // ya contiene el nuevo saldo
                'tipo'             => $tipo,
                'descripcion'      => $descripcion,
            ]);
        });
    }


     public function pagos()
    {
        return $this->hasMany(PagoReporte::class);
    }




    public function scopeVigente($query)
    {
        $hoy = Carbon::today();
        return $query
            ->whereDate('periodo_inicio', '<=', $hoy)
            ->whereDate('periodo_fin',    '>=', $hoy);
    }


public static function reporteGeneral(Carbon $inicio, Carbon $fin): Collection
    {
        // Aseguramos tiempos inclusivos
        $inicio = $inicio->copy()->startOfDay();
        $fin    = $fin->copy()->endOfDay();

        // Primer domingo a partir de la fecha de inicio
        $currentStart = $inicio->copy()->startOfWeek(Carbon::SUNDAY);

        $semanas = collect();
        $n = 1;

        while ($currentStart->lte($fin)) {
            $currentEnd = $currentStart->copy()->addDays(6)->endOfDay();   // sábado
            if ($currentEnd->gt($fin)) {
                $currentEnd = $fin;
            }

            $prestamos = Prestamo::with('user')
                ->whereBetween('fecha_inicio', [$currentStart, $currentEnd])
                ->get();

            $semanas->push([
                'semana'    => $n++,
                'desde'     => $currentStart->toDateString(),
                'hasta'     => $currentEnd->toDateString(),
                'prestamos' => $prestamos,
            ]);

            // Siguiente domingo
            $currentStart->addWeek();
        }

        return $semanas;
    }

}