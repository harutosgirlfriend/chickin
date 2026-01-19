<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductStockExport implements
    FromCollection,
    WithCustomStartCell,
    WithHeadings,
    WithStyles
{
    protected $dataCount;

    public function startCell(): string
    {
        return 'A7';
    }

public function collection()
{
    return Product::select(
        'kode_product',
        'nama_product',
        'kategori',
        'stok',
        'harga'
    )->get()->map(function ($item) {
        $item->stok = (string) $item->stok; // ⬅️ INI KUNCI
        return $item;
    });
}




    public function headings(): array
    {
        return [
            'Kode Produk',
            'Nama Produk',
            'Kategori',
            'Stok',
            'Harga',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        /* KOP */
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'CHICKin');

        $sheet->mergeCells('A2:E2');
        $sheet->setCellValue('A2', 'LAPORAN STOK PRODUK');

        $sheet->mergeCells('A3:E3');
        $sheet->setCellValue(
            'A3',
            'Tanggal: ' . Carbon::now()->translatedFormat('d F Y')
        );

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal('center');

        /* HEADER */
        $sheet->getStyle('A7:E7')->getFont()->setBold(true);
        $sheet->getStyle('A7:E7')->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* DATA */
        $lastRow = 7 + $this->dataCount;
        $sheet->getStyle("A7:E{$lastRow}")
            ->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* TANDA TANGAN */
        $ttdRow = $lastRow + 3;

        $sheet->mergeCells("D{$ttdRow}:E{$ttdRow}");
        $sheet->setCellValue("D{$ttdRow}", 'Mengetahui,');

        $sheet->mergeCells('D'.($ttdRow + 4).':E'.($ttdRow + 4));
        $sheet->setCellValue('D'.($ttdRow + 4), '____________________');

        $sheet->mergeCells('D'.($ttdRow + 5).':E'.($ttdRow + 5));
        $sheet->setCellValue('D'.($ttdRow + 5), 'Admin');

        return [];
    }
}
