<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class IsPanitia
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_panitia) {
            return $next($request);
        }

        if (Auth::check() && !Auth::user()->is_panitia) {
            return redirect('/blog');
        }

        // Jika tidak login sama sekali, redirect ke login
        return redirect('/login');
    }
}
