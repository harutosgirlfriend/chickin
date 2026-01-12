<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Product;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Storage;


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
    public function profile()
    {
        $users= Users::where('id', Auth::id())->first();


        return view('costumer.profile',compact('users'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email',
            'no_hp' => 'nullable|string|max:20'
        ]);

        $user = Auth::user();
        $user->update([
            'nama'  => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()
            ->route('costumer.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }
    public function changePassword()
    {
    

        return view('costumer.changePassword');
    }

public function ubahPassword(Request $request)
{
    $request->validate(
        [
            'password_lama' => 'required',
            'password' => 'required|min:8|confirmed|different:nama|different:email',
        ],
        [
            'password_lama.required' => 'Password lama wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok',
            'password.different' => 'Kata sandi tidak boleh sama dengan nama dan email',
        ]
    );

    $user = auth()->user();

   if (!Hash::check($request->password_lama, $user->password)) {
    return redirect()
        ->back()
        ->withErrors([
            'password_lama' => 'Password lama tidak sesuai'
        ], 'default')
        ->withInput();
}


    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return back()->with('success', 'Password berhasil diubah');
}
public function updatePhoto(Request $request)
{
    // dd($request);
    $request->validate([
        'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $user = Users::where('id', Auth::id())->first();
    $path = public_path('images/profile');


    if (!File::exists($path)) {
        File::makeDirectory($path, 0755, true);
    }

    if ($user->gambar && File::exists($path.'/'.$user->gambar)) {
        File::delete($path.'/'.$user->gambar);
    }

    $filename = uniqid('profile_') . '.' . $request->gambar->extension();
    $request->gambar->move($path, $filename);

    $user->update([
        'gambar' => $filename
    ]);

    return back()->with('success', 'Foto profil berhasil diperbarui');
}
public function deletePhoto()
{
    $user = auth()->user();

    if ($user->gambar && file_exists(public_path('images/profile/' . $user->gambar))) {
        unlink(public_path('images/profile/' . $user->gambar));
    }

    $user->gambar = null;
    $user->save();

    return back();
}


}
