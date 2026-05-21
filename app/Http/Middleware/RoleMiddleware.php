<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Verificar si el usuario está logueado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Comprobar si el rol del usuario coincide con el requerido
        // Nota: Si en el futuro agregas un rol 'cocinero', el admin también debería poder entrar a cocina.
        if (Auth::user()->role !== $role && Auth::user()->role !== 'admin') {
            // Si no tiene permiso, lo mandamos al dashboard para que su redirección inteligente lo acomode
            return redirect()->route('dashboard')->with('error', 'No tienes acceso a esta sección.');
        }

        return $next($request);
    }
}
