<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalidad extends Model
{

     protected $table = 'penalidades'; // 👈 solución clave
    protected $fillable = [
    'prestamo_id',
    'numero_prestamo', // 👈 AGREGA ESTO
    'numero_penalizacion',
    'suma_interes',
    'interes_penalidad',
    'interes_debe',
    'user_id',
    'tipo_operacion',
];
    public function prestamo()
{
    return $this->belongsTo(Prestamo::class);
}
}
