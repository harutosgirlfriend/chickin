<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Vouchers extends Model
{
    protected $table = 'vouchers';

    protected $primaryKey = 'kode_voucher';

    protected $fillable = [
        'kode', 'nilai_diskon', 'min_belanja', 'mulai_berlaku', 'kadaluarsa_pada','maks_diskon', 'tipe_diskon'
    ];

    protected $dates = [
        'mulai_berlaku', 'kadaluarsa_pada',
    ];
        protected $casts = [
         'mulai_berlaku' => 'datetime',
         'kadaluarsa_pada' => 'datetime',
    ];
    public function scopeValid(Builder $query, float $subtotal)
    {
        return $query
            ->where('mulai_berlaku', '<=', now())
            ->where('kadaluarsa_pada', '>=', now())
            ->where('min_belanja', '<=', $subtotal);
    }

    public function hitungDiskon(float $subtotal): float
    {
        if ($this->tipe_diskon === 'persen') {
            $diskon = $subtotal * ($this->nilai_diskon / 100);

            // batasi maksimal diskon (jika ada)
            if ($this->maks_diskon) {
                $diskon = min($diskon, $this->maks_diskon);
            }

            return $diskon;
        }

        // nominal
        return min($this->nilai_diskon, $subtotal);
    }
       public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'kode_voucher', 'kode_voucher');
    }
}
