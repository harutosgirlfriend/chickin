<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class UsersExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell
{
    public function startCell(): string
    {
        return 'B7'; // Data tabel mulai dari B7
    }

    public function collection()
    {
        return User::select('nama', 'email', 'role', 'status')
            ->get()
            ->map(function ($item, $key) {
                return [
                    'no' => $key + 1,  // Nomor urut
                    'nama' => $item->nama,
                    'email' => $item->email,
                    'role' => $item->role,
                    'status' => $item->status,
                ];
            });
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'Email', 'Role', 'Status'];
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
        $sheet->mergeCells('B1:F1');
        $sheet->setCellValue('B1', 'CHICKin');

        $sheet->mergeCells('B2:F2');
        $sheet->setCellValue('B2', 'LAPORAN DATA USER');

        $sheet->mergeCells('B3:F3');
        $sheet->setCellValue('B3', 'Tanggal: ' . Carbon::now()->translatedFormat('d F Y'));

        $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B1:B3')->getAlignment()->setHorizontal('center');

        /* ===== HEADER ===== */
        $sheet->getStyle('B7:F7')->getFont()->setBold(true);
        $sheet->getStyle('B7:F7')->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* ===== DATA ===== */
        $data = $this->collection();
        $lastRow = 7 + $data->count() - 1;

        $sheet->getStyle("B7:F{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle('thin');

        /* ===== TOTAL AKUN ===== */
        $totalCustomer = $data->where('role', 'customer')->count();
        $totalAdmin = $data->where('role', 'admin')->count();

        $totalRow = $lastRow + 1;
        $sheet->mergeCells("B{$totalRow}:D{$totalRow}");
        $sheet->setCellValue("B{$totalRow}", "TOTAL AKUN");
        $sheet->setCellValue("E{$totalRow}", "Customer: {$totalCustomer}");
        $sheet->setCellValue("F{$totalRow}", "Admin: {$totalAdmin}");

        $sheet->getStyle("B{$totalRow}:F{$totalRow}")->getFont()->setBold(true);
        $sheet->getStyle("B{$totalRow}:F{$totalRow}")->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* ===== TANDA TANGAN ===== */
        $ttdRow = $totalRow + 3;
        $sheet->mergeCells("E{$ttdRow}:F{$ttdRow}");
        $sheet->setCellValue("E{$ttdRow}", 'Mengetahui,');

        $sheet->mergeCells("E".($ttdRow+2).":F".($ttdRow+2));
        $sheet->setCellValue("E".($ttdRow+2), '____________________');

        $sheet->mergeCells("E".($ttdRow+3).":F".($ttdRow+3));
        $sheet->setCellValue("E".($ttdRow+3), 'Admin');

        return [];
    }
}
