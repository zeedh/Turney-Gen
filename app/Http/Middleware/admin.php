<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->email === 'zidan@gmail.com') {
            return $next($request);
        }

        // abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        return redirect('/dashboard');
    }
}
