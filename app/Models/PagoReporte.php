<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoReporte extends Model
{
    use HasFactory;
    protected $fillable = [
        'aporte_id',
        'caja_periodo_id',
        'monto',
        'fecha_pago',
        'estado', 
    ];

    public function aporte()
    {
        return $this->belongsTo(Aporte::class);
    }

    public function cajaPeriodo()
    {
        return $this->belongsTo(CajaPeriodo::class, 'caja_periodo_id');
    }
}
