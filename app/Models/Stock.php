<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    public $timestamps = false;

    protected $fillable = [
        'producto_id',
        'sucursal_id',
        'cantidad',
    ];

    protected $casts = [
        'cantidad' => 'integer',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function incrementar(int $cantidad): void
    {
        $this->cantidad += $cantidad;
        $this->save();
    }

    public function decrementar(int $cantidad): void
    {
        $this->cantidad -= $cantidad;
        $this->save();
    }
}