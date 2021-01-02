<?php

namespace App\Http\Middleware;

use Closure;

class Principal
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
        if (\Auth::user() && (\Auth::user()->role == 'principal' || \Auth::user()->role == 'admin')) {
            return $next($request);
         }
         return route('login');
    }
}
