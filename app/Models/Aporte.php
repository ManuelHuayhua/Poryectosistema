<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aporte extends Model
{
    use HasFactory;
     protected $fillable = ['numero_cliente', 'nombre', 'apellido'];
// Relación: un aporte puede tener muchos pagos
   public function pagos()
{
    return $this->hasMany(PagoReporte::class, 'aporte_id');
}
    }
