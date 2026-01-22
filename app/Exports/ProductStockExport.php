<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProductStockExport implements
    FromCollection,
    WithCustomStartCell,
    WithHeadings,
    WithStyles
{
    public function startCell(): string
    {
        return 'B7';
    }

    public function collection()
    {
        return Product::select('kode_product', 'nama_product', 'kategori', 'stok', 'harga')
            ->get()
            ->map(function ($item, $key) {
                return [
                    'no' => $key + 1,               // Nomor urut
                    'kode_product' => $item->kode_product,
                    'nama_product' => $item->nama_product,
                    'kategori' => $item->kategori,
                    'stok' => (int) $item->stok,
                    'harga' => (float) $item->harga,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Produk',
            'Nama Produk',
            'Kategori',
            'Stok',
            'Harga',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        /* ===== LOGO ===== */
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('images/logo.png'));
        $drawing->setHeight(50);
        $drawing->setCoordinates('A1');
        $drawing->setWorksheet($sheet);

        /* ===== KOP ===== */
        $sheet->mergeCells('B1:G1');
        $sheet->setCellValue('B1', 'CHICKin');

        $sheet->mergeCells('B2:G2');
        $sheet->setCellValue('B2', 'LAPORAN STOK PRODUK');

        $sheet->mergeCells('B3:G3');
        $sheet->setCellValue('B3', 'Tanggal: ' . Carbon::now()->translatedFormat('d F Y'));

        $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B1:B3')->getAlignment()->setHorizontal('center');

        /* ===== HEADER ===== */
        $sheet->getStyle('B7:G7')->getFont()->setBold(true);
        $sheet->getStyle('B7:G7')->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* ===== DATA ===== */
        $data = $this->collection();
        $lastRow = 7 + $data->count() - 1;

        $sheet->getStyle("B7:G{$lastRow}")
            ->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* ===== TOTAL ===== */
        $totalStok = $data->sum('stok');
        $totalHarga = $data->sum('harga');

        $totalRow = $lastRow + 1;
        $sheet->mergeCells("B{$totalRow}:E{$totalRow}");
        $sheet->setCellValue("B{$totalRow}", 'TOTAL');
        $sheet->setCellValue("F{$totalRow}", $totalStok);
        $sheet->setCellValue("G{$totalRow}", $totalHarga);

        $sheet->getStyle("B{$totalRow}:G{$totalRow}")->getFont()->setBold(true);
        $sheet->getStyle("B{$totalRow}:G{$totalRow}")->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* ===== TANDA TANGAN ===== */
        $ttdRow = $totalRow + 3;
        $sheet->mergeCells("F{$ttdRow}:G{$ttdRow}");
        $sheet->setCellValue("F{$ttdRow}", 'Mengetahui,');

        $sheet->mergeCells("F".($ttdRow+2).":G".($ttdRow+2));
        $sheet->setCellValue("F".($ttdRow+2), '____________________');

        $sheet->mergeCells("F".($ttdRow+3).":G".($ttdRow+3));
        $sheet->setCellValue("F".($ttdRow+3), 'Admin');

        return [];
    }
}
