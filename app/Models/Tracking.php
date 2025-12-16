<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = 'tracking';

    protected $primaryKey = 'kode_tracking';

    protected $fillable = [
        'kode_tracking',
        'kode_transaksi',
        'status',

    ];

    //  public $timestamps = false;
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'kode_transaksi', 'kode_transaksi');
    }
}
