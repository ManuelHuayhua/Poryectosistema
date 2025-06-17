<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TablaUsuario extends Model
{
     use HasFactory;

    protected $table = 'tabla_usuario';

    protected $fillable = [
        'user_id',
        'prestamo_id',
        'numero_prestamo',
        'item',
        'renovacion',
        'junta',
        'fecha_prestamos',
        'fecha_pago',
        'monto',
        'interes',  // <-- AÑADIDO
        'interes_porcentaje',
        'descripcion',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penalidades()
    {
        return $this->hasMany(Penalidad::class, 'numero_prestamo', 'numero_prestamo')
                    ->where('user_id', $this->user_id);
    }

     // RELACIÓN CON PRÉSTAMO
    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }
    
}