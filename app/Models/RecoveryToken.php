<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RecoveryToken extends Model
{
    protected $table = 'recovery_tokens';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'token',
        'expira_en',
        'usado',
    ];

    protected $casts = [
        'expira_en' => 'datetime',
        'usado' => 'boolean',
    ];

    public static function generarPara(Usuario $usuario, int $minutosValidez = 30): self
    {
        return static::create([
            'usuario_id' => $usuario->id,
            'token' => Str::random(60),
            'expira_en' => now()->addMinutes($minutosValidez),
            'usado' => false,
        ]);
    }

    public function sigueVigente(): bool
    {
        return !$this->usado && $this->expira_en->isFuture();
    }
}