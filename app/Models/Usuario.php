<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'password_hash',
        'rol',
        'sucursal_id',
        'activo',
        'two_factor_secret',
        'remember_token',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function setPasswordAttribute($passwordPlano)
    {
        $this->attributes['password_hash'] = Hash::make($passwordPlano);
    }

    public function verificarCredenciales($passwordIngresada)
    {
        return Hash::check($passwordIngresada, $this->password_hash);
    }

    public function esAdministrador(): bool
    {
        return $this->rol === 'administrador';
    }

    public function esJefe(): bool
    {
        return $this->rol === 'jefe';
    }

    public function esEncargadoAlmacen(): bool
    {
        return $this->rol === 'encargado_almacen';
    }

    public function esEncargadoTienda(): bool
    {
        return $this->rol === 'encargado_tienda';
    }

    public function esAdmin(): bool
    {
        return in_array($this->rol, ['administrador', 'jefe']);
    }
}