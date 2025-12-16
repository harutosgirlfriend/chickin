<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vouchers;
use Illuminate\Http\Request;

class VouchersController extends Controller
{
    public function index()
    {
        $vouchers = Vouchers::all();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_voucher' => 'required|unique:vouchers,kode_voucher',
            'nilai_diskon' => 'required|integer',
            'min_belanja' => 'required|numeric',
            'mulai_berlaku' => 'required|date',
            'kadaluarsa_pada' => 'nullable|date|after_or_equal:mulai_berlaku',
            'tipe_diskon' => 'required|in:persen,nominal',
            'maks_diskon' => 'nullable|numeric',
        ]);

        Vouchers::create($request->all());

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil ditambahkan!');
    }

    public function edit($kode_voucher)
    {
        $voucher = Vouchers::findOrFail($kode_voucher);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, $kode_voucher)
    {
        $voucher = Vouchers::findOrFail($kode_voucher);

        $request->validate([
            'nilai_diskon' => 'required|integer',
            'min_belanja' => 'required|numeric',
            'mulai_berlaku' => 'required|date',
            'kadaluarsa_pada' => 'nullable|date|after_or_equal:mulai_berlaku',
            'tipe_diskon' => 'required|in:persen,nominal',
            'maks_diskon' => 'nullable|numeric',
        ]);

        $voucher->update($request->all());

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil diperbarui!');
    }

    public function destroy($kode_voucher)
    {
        $voucher = Vouchers::findOrFail($kode_voucher);
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dihapus!');
    }
}
