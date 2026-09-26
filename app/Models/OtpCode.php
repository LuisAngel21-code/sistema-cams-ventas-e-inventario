<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $table = 'otp_codes';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'codigo',
        'expira_en',
        'verificado',
    ];

    protected $casts = [
        'expira_en' => 'datetime',
        'verificado' => 'boolean',
    ];

    public static function generarPara(Usuario $usuario, int $minutosValidez = 5): self
    {
        return static::create([
            'usuario_id' => $usuario->id,
            'codigo' => (string) random_int(100000, 999999),
            'expira_en' => now()->addMinutes($minutosValidez),
            'verificado' => false,
        ]);
    }

    public function esValido(string $codigoIngresado): bool
    {
        return $this->codigo === $codigoIngresado
            && !$this->verificado
            && $this->expira_en->isFuture();
    }

    public function marcarVerificado(): void
    {
        $this->verificado = true;
        $this->save();
    }
}