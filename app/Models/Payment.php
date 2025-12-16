<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
        protected $table = 'payment';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'payment_type',
        'status',
        'kode_transaksi '

    ];


}
