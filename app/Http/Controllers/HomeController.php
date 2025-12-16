<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.regis');
    }

    public function regis(Request $request)
    {
        $validation = $request->validate(
            [
                'email' => 'unique:users,email',
                'nama' => 'string',
                'password' => 'min:8|confirmed',
                'no_hp' => 'numeric|digits_between:12,13',
            ],
            [
                'email.unique' => 'Email sudah terdaftar, silahkan gunakan email lain',
                'password.required' => 'Password waib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirm' => 'Konfirmasi Kata sandi tidak cocok',
                'no_hp.numeric' => 'harus berisi nomor',
                'no_hp.digits_between' => 'Nomor HP harus berisi antara 12 sampai 13 angka.',

            ]);

        Users::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'role' => 'customer',
        ]);

        return view('admin.login');
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        $user = Users::where('email', $credentials['email'])->first();

        if (! $user) {

            return back()->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        if (Auth::attempt($credentials)) {

            $auth = Auth::user();

            if ($request->session()->has('checkout')) {
                $dataproduct = Session::get('product_checkout');
                $request->session()->pull('checkout');

                // dd($request);
                return redirect()->route('checkout', ['product' => $dataproduct]);

            }

            if ($request->session()->has('form_checkout')) {

                $dataKeranjang = Session::get('keranjang_pending');
                $index = Keranjang::with(['product', 'user'])
                    ->where('id_user', Auth::id())
                    ->where('kode_product', $dataKeranjang['kode_product'])
                    ->first();

                if ($index) {
                    $index->jumlah += $dataKeranjang['jumlah'];
                    $index->save();
                } else {
                    Keranjang::create([
                        'kode_product' => $dataKeranjang['kode_product'],
                        'jumlah' => $dataKeranjang['jumlah'],
                        'id_user' => $auth->id]);
                }
                $request->session()->pull('form_checkout');

                return redirect()->route('detail', ['kode_product' => $dataKeranjang['kode_product']]);

            }
            $request->session()->regenerate();

            return redirect()->intended('/cekrole'); // Laravel akan secara otomatis tahu user mana yang login

        } else {
            return back()->withErrors(['password' => 'Password salah.']);
        }
    }

    public function loginView()
    {
        return view('admin.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Anda telah logout.'); // 4️⃣ Redirect ke halaman login
    }
}
