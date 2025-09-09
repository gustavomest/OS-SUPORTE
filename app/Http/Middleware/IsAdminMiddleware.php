<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   // app/Http/Middleware/IsAdminMiddleware.php
public function handle(Request $request, Closure $next): Response
{
    // Verifica se o usuário está autenticado E se ele é um admin
    if (auth()->check() && auth()->user()->is_admin) {
        return $next($request);
    }

    // Se não for admin, redireciona para a home com uma mensagem de erro
    return redirect('/dashboard')->with('error', 'Você não tem permissão para acessar esta página.');
}
}
