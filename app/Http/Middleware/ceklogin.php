<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ceklogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        session(['form_checkout' => true]);

        session(['keranjang_pending' => $request->all()]);

        if (! $auth = Auth::user()) {
            return redirect()->route('login.view');
        }

        return $next($request);
    }
}
