<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenghasilanExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithCustomStartCell,
    WithStyles
{
    protected $data;
    protected $filter; // range / bulanan / tahunan
    protected $tanggalAwal;
    protected $tanggalAkhir;
    protected $bulan;
    protected $tahun;

    public function __construct(Collection $data, $filter = null, $tanggalAwal = null, $tanggalAkhir = null, $bulan = null, $tahun = null)
    {
        $this->data = $data;
        $this->filter = $filter;
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function startCell(): string
    {
        return 'A7';
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
            $totalHargaAwal += ($detail->product->harga_awal ?? 0) * ($detail->jumlah ?? 1);
        }

        $labaBersih = $penghasilan->total_harga - $totalHargaAwal - ($penghasilan->jumlah_potongan ?? 0);

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

    public function styles(Worksheet $sheet)
    {
        /* ===== KOP ===== */
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'CHICKin');

        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', 'LAPORAN PENGHASILAN');

        // Keterangan filter otomatis
        $sheet->mergeCells('A3:I3');
        $keterangan = '';
        if ($this->filter === 'range' && $this->tanggalAwal && $this->tanggalAkhir) {
            $keterangan = 'Periode: ' . Carbon::parse($this->tanggalAwal)->format('d F Y')
                . ' s/d ' . Carbon::parse($this->tanggalAkhir)->format('d F Y');
        } elseif ($this->filter === 'bulanan' && $this->bulan) {
            $keterangan = 'Bulanan: ' . Carbon::parse($this->bulan)->translatedFormat('F Y');
        } elseif ($this->filter === 'tahunan' && $this->tahun) {
            $keterangan = 'Tahunan: ' . $this->tahun;
        } else {
            $keterangan = 'Tanggal: ' . Carbon::now()->translatedFormat('d F Y');
        }
        $sheet->setCellValue('A3', $keterangan);

        // Style kop
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal('center');

        /* ===== HEADER ===== */
        $sheet->getStyle('A7:I7')->getFont()->setBold(true);
        $sheet->getStyle('A7:I7')
            ->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* ===== DATA ===== */
        $lastRow = 7 + $this->data->count();
        $sheet->getStyle("A7:I{$lastRow}")
            ->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* ===== TANDA TANGAN ===== */
        $ttdRow = $lastRow + 3;

        $sheet->mergeCells("H{$ttdRow}:I{$ttdRow}");
        $sheet->setCellValue("H{$ttdRow}", 'Mengetahui,');

        $sheet->mergeCells("H".($ttdRow + 4).":I".($ttdRow + 4));
        $sheet->setCellValue("H".($ttdRow + 4), '____________________');

        $sheet->mergeCells("H".($ttdRow + 5).":I".($ttdRow + 5));
        $sheet->setCellValue("H".($ttdRow + 5), 'Admin');

        return [];
    }
}
