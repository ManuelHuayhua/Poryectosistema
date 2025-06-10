<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePrestamo extends Model
{
    protected $fillable = [
    'prestamo_id',
    'mes',
    'interes_base',
    'penalidad_interes',
    'penalidad_acumulada',
    'total_mes',
    'fecha_mes',
    'pagado',
];
}
