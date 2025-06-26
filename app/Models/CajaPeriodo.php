<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CajaPeriodo extends Model
{
    protected $table = 'caja_periodo';

  

    protected $fillable = [
        'monto_inicial',
        'saldo_actual',
        'periodo_inicio',
        'periodo_fin',
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


}