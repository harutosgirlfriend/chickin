<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'log_aktivitas';

    protected $fillable = [
        'id_user',
        'kode_product',
        'aksi',
        'stok_sebelum',
        'stok_sesudah',
        'created_at',
        'updated_at',
        
    ];
      public function product()
    {

        return $this->belongsTo(Product::class, 'kode_product', 'kode_product');
    }
    public function users()
    {
        return $this->belongsTo(Users::class, 'id_user', 'id');
    }
}
