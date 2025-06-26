<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaMovimiento extends Model
{
    protected $table = 'caja_movimientos';

    protected $fillable = [
        'monto',
        'saldo_resultante',
        'tipo',
        'descripcion',
    ];

    public function cajaPeriodo(): BelongsTo
    {
        return $this->belongsTo(CajaPeriodo::class);
    }
}
