<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PenghasilanExport implements FromCollection, WithCustomStartCell, WithHeadings, WithMapping, WithStyles
{
    protected $data;
    protected $filter;
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
        return 'B7';
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No', // Nomor urut
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
        static $no = 0;
        $no++;

        $totalHargaAwal = 0;
        foreach ($penghasilan->details as $detail) {
            $totalHargaAwal += ($detail->product->harga_awal ?? 0) * ($detail->jumlah ?? 1);
        }

        $labaBersih = $penghasilan->total_harga - $totalHargaAwal - ($penghasilan->jumlah_potongan ?? 0);

        return [
            $no,
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
        /* ===== LOGO ===== */
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('images/logo.png')); // Path logo
        $drawing->setHeight(50);
        $drawing->setCoordinates('A1'); // Tempat logo
        $drawing->setWorksheet($sheet);

        /* ===== KOP ===== */
        $sheet->mergeCells('B1:K1');
        $sheet->setCellValue('B1', 'CHICKin');

        $sheet->mergeCells('B2:K2');
        $sheet->setCellValue('B2', 'LAPORAN KEUANGAN');

        // Keterangan filter otomatis
        $sheet->mergeCells('B3:K3');
        $keterangan = '';
        if ($this->filter === 'range' && $this->tanggalAwal && $this->tanggalAkhir) {
            $keterangan = 'Periode: '.Carbon::parse($this->tanggalAwal)->format('d F Y')
                .' s/d '.Carbon::parse($this->tanggalAkhir)->format('d F Y');
        } elseif ($this->filter === 'bulanan' && $this->bulan) {
            $keterangan = 'Bulanan: '.Carbon::parse($this->bulan)->translatedFormat('F Y');
        } elseif ($this->filter === 'tahunan' && $this->tahun) {
            $keterangan = 'Tahunan: '.$this->tahun;
        } else {
            $keterangan = 'Tanggal: '.Carbon::now()->translatedFormat('d F Y');
        }
        $sheet->setCellValue('B3', $keterangan);

        $sheet->getStyle('B1:B3')->getFont()->setBold(true);
        $sheet->getStyle('B1')->getFont()->setSize(16);
        $sheet->getStyle('B1:B3')->getAlignment()->setHorizontal('center');

        /* ===== HEADER ===== */
        $sheet->getStyle('B7:K7')->getFont()->setBold(true);
        $sheet->getStyle('B7:K7')->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* ===== DATA ===== */
        $lastRow = 7 + $this->data->count();

        $sheet->getStyle("B7:K{$lastRow}")
            ->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* ===== TOTAL ===== */
        $grandTotalHarga = $this->data->sum('total_harga');
        $grandTotalHargaAwal = $this->data->sum(function($row){
            $total = 0;
            foreach($row->details as $d){
                $total += ($d->product->harga_awal ?? 0) * ($d->jumlah ?? 1);
            }
            return $total;
        });
        $grandTotalPotongan = $this->data->sum('jumlah_potongan');
        $grandTotalOngkir = $this->data->sum('ongkir');
        $grandTotalLaba = $this->data->sum(function($row){
            $totalAwal = 0;
            foreach($row->details as $d){
                $totalAwal += ($d->product->harga_awal ?? 0) * ($d->jumlah ?? 1);
            }
            return $row->total_harga - $totalAwal - ($row->jumlah_potongan ?? 0);
        });

        $totalRow = $lastRow + 1;
        $sheet->mergeCells("B{$totalRow}:D{$totalRow}");
        $sheet->setCellValue("B{$totalRow}", 'TOTAL');
        $sheet->setCellValue("E{$totalRow}", $grandTotalHarga);
        $sheet->setCellValue("F{$totalRow}", $grandTotalHargaAwal);
        $sheet->setCellValue("H{$totalRow}", $grandTotalPotongan);
        $sheet->setCellValue("I{$totalRow}", $grandTotalOngkir);
        $sheet->setCellValue("K{$totalRow}", $grandTotalLaba);

        $sheet->getStyle("B{$totalRow}:K{$totalRow}")->getFont()->setBold(true);
        $sheet->getStyle("B{$totalRow}:K{$totalRow}")->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* ===== TANDA TANGAN ===== */
        $ttdRow = $totalRow + 3;
        $sheet->mergeCells("J{$ttdRow}:K{$ttdRow}");
        $sheet->setCellValue("J{$ttdRow}", 'Mengetahui,');

        $sheet->mergeCells("J".($ttdRow+2).":K".($ttdRow+2));
        $sheet->setCellValue("J".($ttdRow+2), '____________________');

        $sheet->mergeCells("J".($ttdRow+3).":K".($ttdRow+3));
        $sheet->setCellValue("J".($ttdRow+3), 'Admin');

        return [];
    }
}
