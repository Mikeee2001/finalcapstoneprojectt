<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        // not logged in
        if (!auth()->check()) {
            return redirect()->route('signin');
        }

        // wrong role
        if (auth()->user()->role !== $role) {
            return redirect()->route('signin');
        }

        return $next($request);
    }
}
