<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $usuario = $request->user();

        if (!$usuario) {
            return redirect()->route('login');
        }

        if (!in_array($usuario->rol, $roles)) {
            abort(403, 'No tienes permisos para acceder a este modulo.');
        }

        return $next($request);
    }
}