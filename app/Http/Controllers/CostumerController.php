<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CostumerController extends Controller
{


    public function index()
    {
     $product = Product::all();

     
        $data = Keranjang::with(['user', 'product'])
            ->where('id_user', Auth::id())
            ->get();
        return view('costumer.dashboard', ['data' => $data,'product' => $product]);
    }
    public function chat()
    {
    
        return view('costumer.chat');
    }
}
