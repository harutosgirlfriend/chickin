<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\Keranjang;
use App\Models\PasswordResetToken;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
                'password' => 'min:8|confirmed|different:nama|different:email',
                'no_hp' => 'numeric|digits_between:12,13',
            ],
            [
                'email.unique' => 'Email sudah terdaftar, silahkan gunakan email lain',
                'password.required' => 'Password waib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirm' => 'Konfirmasi Kata sandi tidak cocok',
                'no_hp.numeric' => 'harus berisi nomor',
                'no_hp.digits_between' => 'Nomor HP harus berisi antara 12 sampai 13 angka.',
                'password.different' => 'Kata sandi tidak boleh sama dengan nama dan email',

            ]);

        Users::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'role' => 'customer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
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
        if ($user->status === 'Non Active') {
            return back()->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.',
            ]);
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

            return redirect()->intended('/cekrole');
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

        return redirect('/')->with('status', 'Anda telah logout.');
    }

    public function lupaPassword()
    {
        return view('admin.lupaPassword');

    }

    public function cekEmail(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak ditemukan dalam sistem kami',
        ]);
        $token = \Str::random(60);
        PasswordResetToken::updateOrCreate(
            [
                'email' => $request->email,
            ],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );
        Mail::to($request->email)->send(new ResetPasswordMail($token));

        return redirect()->route('lupa.password')->with('success', 'kami telah mengirimkan link ke email anda');

    }

    public function aturPassword($token)
    {
        $kodetoken = PasswordResetToken::where('token', $token)->first();
        if (! $kodetoken) {
            return redirect()->route('lupa.password')->withErrors(['token' => 'Token tidak valid atau telah kedaluwarsa. Silakan coba lagi.']);
        }

        return view('admin.resetPassword', compact('token'));

    }

 public function aturPasswordAction(Request $request)
{
    $request->validate([
        'token' => 'required',
        'password' => 'required|min:8|confirmed',
    ], [
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
    ]);

    $reset = PasswordResetToken::where('token', $request->token)->first();
    // dd($reset->email);

    if (!$reset) {
        return redirect()->route('login.view')
            ->withErrors(['password' => 'Token reset tidak valid atau sudah kadaluarsa']);
    }

    $user = Users::where('email', $reset->email)->first();

    if (!$user) {
        return redirect()->route('atur.password')
            ->withErrors(['password' => 'User tidak ditemukan']);
    }

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    PasswordResetToken::where('email', $reset->email)->delete();

    return redirect()->route('login.view')
        ->with('success', 'Password berhasil diubah, silakan login');
}



}
