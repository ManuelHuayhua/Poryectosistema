<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaMovimiento extends Model
{
    protected $table = 'caja_movimientos';

    protected $fillable = [
        'caja_periodo_id',
        'monto',
        'saldo_resultante',
        'tipo',
        'descripcion',
    ];

    public function cajaPeriodo(): BelongsTo
    {
        return $this->belongsTo(CajaPeriodo::class);
    }

     public function periodo()
    {
        return $this->belongsTo(CajaPeriodo::class, 'caja_periodo_id');
    }

    /* ---------- Scopes útiles ---------- */

    // Solo ingresos
    public function scopeIngresos($query)
    {
        return $query->where('tipo', 'ingreso');
    }

    // Solo egresos
    public function scopeEgresos($query)
    {
        return $query->where('tipo', 'egreso');
    }
    
}
