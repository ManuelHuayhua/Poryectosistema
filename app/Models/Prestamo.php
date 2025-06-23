<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'numero_prestamo',
    'monto',
    'interes',
    'interes_pagar',
    'porcentaje_penalidad', 
    'interes_penalidad',
    'penalidades_acumuladas',
    'interes_acumulado',
    'total_pagar',
    'fecha_inicio',
    'fecha_fin',
    'fecha_pago',
    'estado',
    'descripcion',
    'interes_total',
    'n_junta',
    'item_prestamo', // Nuevo campo agregado
    'notificacion_pago',

];

 protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'fecha_pago' => 'datetime',
    ];
     
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function penalidades()
{
    return $this->hasMany(Penalidad::class);
}

}
