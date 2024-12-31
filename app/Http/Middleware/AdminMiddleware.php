<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/login'); // Redirigir a la página de inicio de sesión
        }

        // Verificar si el usuario es admin
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.'); // Redirigir a la página principal si no es admin
        }

        return $next($request); // Continuar con la solicitud
    }
}
