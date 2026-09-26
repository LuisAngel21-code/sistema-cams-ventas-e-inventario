<?php

namespace App\Http\Controllers;

use App\Models\RecoveryToken;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller
{
    // HU-01: muestra la pantalla de acceso. Si ya se validó la contraseña,
    // también prepara la pantalla del código de verificación (HU-03).
    public function mostrarLogin()
    {
        $verificar = null;
        $qrDataUri = null;
        $qrSecret = null;

        if (session()->has('pending_2fa')) {
            $usuario = Usuario::find(session('pending_2fa'));

            if ($usuario) {
                if (empty($usuario->two_factor_secret)) {
                    $usuario->two_factor_secret = app(Google2FA::class)->generateSecretKey();
                    $usuario->save();
                }

                $qrSecret = $usuario->two_factor_secret;
                $company = 'Tienda Cams';
                $qrUrl = app(Google2FA::class)->getQRCodeUrl($company, $usuario->username, $qrSecret);

                $renderer = new \BaconQrCode\Renderer\ImageRenderer(
                    new \BaconQrCode\Renderer\RendererStyle\RendererStyle(200),
                    new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
                );
                $qrDataUri = 'data:image/svg+xml;base64,' . base64_encode((new \BaconQrCode\Writer($renderer))->writeString($qrUrl));

                $verificar = true;
            }
        }

        return view('auth.login', [
            'verificar' => $verificar,
            'qrDataUri' => $qrDataUri,
            'qrSecret' => $qrSecret,
        ]);
    }

    public function iniciarSesion(Request $request)
    {
        // HU-01: se piden el correo y la contraseña antes de dejar entrar.
        $credenciales = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // HU-01: se busca al usuario por su correo y se comprueba que esté activo.
        $usuario = Usuario::where('username', $credenciales['username'])
            ->where('activo', true)
            ->first();

        // HU-01: si los datos no coinciden, se avisa que no son válidos.
        if (!$usuario || !$usuario->verificarCredenciales($credenciales['password'])) {
            return back()->withErrors([
                'username' => 'Las credenciales ingresadas no son validas.',
            ])->onlyInput('username');
        }

        $recordarSesion = $request->boolean('remember');
        session(['pending_2fa' => $usuario->id, 'remember_login' => $recordarSesion]);

        return redirect()->route('login');
    }

    public function verificarCodigo(Request $request)
    {
        // HU-03: el código debe tener 6 dígitos para poder revisarlo.
        $datos = $request->validate([
            'codigo' => ['required', 'string', 'size:6'],
        ]);

        $usuario = Usuario::find(session('pending_2fa'));

        // HU-03: si no hay una verificación pendiente, se vuelve al acceso.
        if (!$usuario || empty($usuario->two_factor_secret)) {
            session()->forget('pending_2fa');
            return redirect()->route('login')->withErrors([
                'username' => 'Sesion no valida. Inicia sesion de nuevo.',
            ]);
        }

        $esValido = app(Google2FA::class)->verifyKey($usuario->two_factor_secret, $datos['codigo']);

        // HU-03: si el código no coincide o ya venció, se avisa y no se deja entrar.
        if (!$esValido) {
            return back()->withErrors([
                'codigo' => 'El codigo es incorrecto o ha expirado.',
            ])->onlyInput('codigo');
        }

        Auth::login($usuario, session('remember_login', false));
        $request->session()->regenerate();
        session()->forget(['pending_2fa', 'remember_login']);

        $destino = match($usuario->rol) {
            'administrador', 'jefe' => route('dashboard'),
            'encargado_almacen'     => route('productos.index'),
            'encargado_tienda'      => route('ventas.historial'),
            default                 => route('dashboard'),
        };

        return redirect($destino);
    }

    // HU-02: muestra la pantalla para pedir la recuperación con el correo.
    public function mostrarRecuperacion()
    {
        return view('auth.recuperar');
    }

    public function enviarEnlaceRecuperacion(Request $request)
    {
        $datos = $request->validate([
            'username' => ['required', 'string', 'email'],
        ]);

        // HU-02: solo se continúa si el correo está registrado en el sistema.
        $usuario = Usuario::where('username', $datos['username'])->first();

        if ($usuario) {
            RecoveryToken::generarPara($usuario);
        }

        return back()->with('status', 'Si el correo esta registrado, recibiras instrucciones.');
    }

    public function cancelarVerificacion(Request $request)
    {
        session()->forget('pending_2fa');

        return redirect()->route('login');
    }

    public function cerrarSesion(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}