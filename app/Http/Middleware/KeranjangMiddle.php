<?php

namespace App\Http\Middleware;

use App\Models\Keranjang;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KeranjangMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $total_item = 0;
        if (Auth::check()) {
            $keranjang = Keranjang::with(['product', 'user'])
                ->where('id_user', Auth::id())
                ->get()
                ->map(function ($item) {
                    $item->subtotal = $item->product->harga * $item->jumlah;

                    return $item;
                });

            $total_item = $keranjang->count();

            view()->share(['keranjang' => $keranjang, 'total_item' => $total_item]);
            //    dd($keranjang);
        }
        view()->share(['total_item' => $total_item]);

        return $next($request);
        if (! $auth = Auth::user()) {
            return redirect()->route('login.view');
        }
    }
}
