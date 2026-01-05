<?php 
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenghasilanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Tanggal',
            'Jumlah Produk',
            'Total Harga',
            'Total Harga Awal',
            'Metode Pembayaran',
            'Jumlah Potongan',
            'Ongkir',
            'Laba Bersih',
        ];
    }

    public function map($penghasilan): array
    {
        $totalHargaAwal = 0;

        foreach ($penghasilan->details as $detail) {
            $totalHargaAwal +=
                ($detail->product->harga_awal ?? 0) *
                ($detail->jumlah ?? 1);
        }

        $labaBersih =
            $penghasilan->total_harga
            - $totalHargaAwal
            - ($penghasilan->jumlah_potongan ?? 0);

        return [
            $penghasilan->kode_transaksi,
            $penghasilan->tanggal,
            $penghasilan->jumlah_produk,
            $penghasilan->total_harga,
            $totalHargaAwal,
            $penghasilan->metode_pembayaran,
            $penghasilan->jumlah_potongan ?? 0,
            $penghasilan->ongkir,
            $labaBersih,
        ];
    }
}
