<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';

    public $timestamps = false;

    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'float',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function calcularSubtotal(): float
    {
        return $this->cantidad * $this->precio_unitario;
    }
}