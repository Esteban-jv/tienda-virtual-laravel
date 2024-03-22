<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     * Siempre tiene que retornar una respuesta, no puede ser false, no puede ser null ni 0
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!is_null($request->user()) AND $request->user()->isAdmin())
            return $next($request);
        abort(403);
    }
}
