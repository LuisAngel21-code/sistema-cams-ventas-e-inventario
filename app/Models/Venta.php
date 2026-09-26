<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'subtotal',
        'descuento',
        'total',
        'tipo_pago',
        'comprobante_tipo',
        'cliente_nombre',
        'vendedor_nombre',
        'estado',
        'sucursal_id',
        'usuario_id',
    ];

    protected $casts = [
        'total' => 'float',
        'subtotal' => 'float',
        'descuento' => 'float',
        'fecha' => 'datetime',
    ];

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function scopeFiltradasPorRango($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }
}