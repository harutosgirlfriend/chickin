<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

// BARIS INI DIPERBAIKI: Anda harus mengimplementasikan Authenticatable
class Users extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $table = 'users';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = ['nama', 'no_hp', 'password', 'email', 'role','created_at', 'updated_at','gambar','status'];

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_user', 'id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_user', 'id');
    }
    public function chat()
    {
        return $this->hasMany(ChatModel::class, 'id_pengirim', 'id');
    }
    public function feedback()
    {
        return $this->hasMany(Fedbacks::class, 'id_user', 'id');
    }
}
