<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;
     // Nombre real de la tabla
    protected $table = 'configuraciones';

    protected $fillable = [
        'tipo_origen',
        'interes',
        'penalidad',
    ];
    
}
