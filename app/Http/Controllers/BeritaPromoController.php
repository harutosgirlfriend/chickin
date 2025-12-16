<?php

namespace App\Http\Controllers;

use App\Models\BeritaPromo;

class BeritaPromoController extends Controller
{
    public function index()
    {
        $beritaPromo = BeritaPromo::all();

        return view('costumer.beritapromo', ['beritaPromo' => $beritaPromo]);
    }
}
