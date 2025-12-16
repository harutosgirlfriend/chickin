<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class autoherizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $auth = Auth::user();
        if ($auth->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }
        if ($auth->role === 'customer') {

            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
