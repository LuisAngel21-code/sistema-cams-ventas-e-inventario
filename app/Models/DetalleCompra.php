<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'detalle_compras';

    public $timestamps = false;

    protected $fillable = [
        'compra_id',
        'producto_id',
        'cantidad',
        'costo',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'costo' => 'float',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}