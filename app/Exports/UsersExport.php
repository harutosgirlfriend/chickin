<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell
{
    public function startCell(): string
    {
        // Data tabel mulai dari A7
        return 'A7';
    }

    public function collection()
    {
        return User::select('nama', 'email', 'role', 'status')->get();
    }

    public function headings(): array
    {
        return ['Nama', 'Email', 'Role', 'Status'];
    }

    public function styles(Worksheet $sheet)
    {
        /* ===== KOP ===== */
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', 'CHICKin');

        $sheet->mergeCells('A2:D2');
        $sheet->setCellValue('A2', 'LAPORAN DATA USER');

        $sheet->mergeCells('A3:D3');
        $sheet->setCellValue('A3', 'Tanggal: ' . Carbon::now()->translatedFormat('d F Y'));

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal('center');

        /* ===== HEADER TABEL ===== */
        $sheet->getStyle('A7:D7')->getFont()->setBold(true);
        $sheet->getStyle('A7:D7')->getBorders()->getAllBorders()->setBorderStyle('thin');

        /* ===== BORDER DATA ===== */
        $lastRow = 7 + User::count();
        $sheet->getStyle("A7:D{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle('thin');

        /* ===== TANDA TANGAN ===== */
        $ttdRow = $lastRow + 3;
        $sheet->mergeCells("C{$ttdRow}:D{$ttdRow}");
        $sheet->setCellValue("C{$ttdRow}", 'Mengetahui,');

        $sheet->mergeCells("C" . ($ttdRow + 4) . ":D" . ($ttdRow + 4));
        $sheet->setCellValue("C" . ($ttdRow + 4), '____________________');

        $sheet->mergeCells("C" . ($ttdRow + 5) . ":D" . ($ttdRow + 5));
        $sheet->setCellValue("C" . ($ttdRow + 5), 'Admin');

        return [];
    }
}

