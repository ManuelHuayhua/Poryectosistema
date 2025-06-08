<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestamoDetalle extends Model
{
    protected $fillable = [
        'prestamo_id',
        'mes',
        'interes',
        'penalidad',
        'total_mes',
        'pagado',
        'fecha_registro',
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }
}