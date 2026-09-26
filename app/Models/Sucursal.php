<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursales';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // HU-13: cada sucursal agrupa a sus usuarios para organizar las tiendas.
    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}