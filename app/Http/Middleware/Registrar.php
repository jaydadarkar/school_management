<?php

namespace App\Http\Middleware;

use Closure;

class Registrar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user() && (\Auth::user()->role == 'registrar' || \Auth::user()->role == 'admin')) {
            return $next($request);
         }
         return route('login');
    }
}
