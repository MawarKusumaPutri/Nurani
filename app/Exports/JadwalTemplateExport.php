<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class JadwalTemplateExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Return sample data
        return collect([
            [
                'Matematika',
                'Budi Santoso',
                '7A',
                'Senin',
                '08:00 - 09:30',
                'Ruang 7A',
                'Jadwal rutin setiap minggu'
            ],
            [
                'Bahasa Indonesia',
                'Siti Aminah',
                '7A',
                'Senin',
                '09:30 - 11:00',
                'Ruang 7A',
                ''
            ],
            [
                'IPA',
                'Ahmad Hidayat',
                '7A',
                'Selasa',
                '08:00 - 09:30',
                'Laboratorium',
                'Praktikum di lab'
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'Mata Pelajaran',
            'Nama Guru',
            'Kelas',
            'Hari',
            'Waktu',
            'Ruang',
            'Keterangan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4CAF50']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}
