<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}