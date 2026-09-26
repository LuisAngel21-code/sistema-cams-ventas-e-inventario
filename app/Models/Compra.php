<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'sucursal_id',
        'usuario_id',
        'total',
    ];

    protected $casts = [
        'total' => 'float',
        'fecha' => 'datetime',
    ];

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}