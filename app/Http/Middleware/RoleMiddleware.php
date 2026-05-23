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
        // Verificar si el usuario está logueado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Comprobacion del rol del usuario si coincide con el requerido
        if (Auth::user()->role !== $role && Auth::user()->role !== 'admin') {
            // Si no tiene permiso, lo mandamos al dashboard para que su redirección inteligente lo acomode
            return redirect()->route('dashboard')->with('error', 'No tienes acceso a esta sección.');
        }

        return $next($request);
    }
}
