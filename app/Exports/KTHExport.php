<?php

namespace App\Exports;

use App\Models\Kth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KTHExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function collection()
    {
        if ($this->data) {
            return $this->data;
        }
        return Kth::with('penyuluh')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama KTH',
            'Desa',
            'Kecamatan',
            'Kabupaten',
            'Kelas KTH',
            'Status KTH',
            'Status Verifikasi',
            'Nama Ketua',
            'No HP Ketua',
            'Nama Penyuluh',
            'Tanggal Register',
            'Dibuat Pada',
        ];
    }

    public function map($kth): array
    {
        static $row = 0;
        $row++;

        return [
            $row,
            $kth->nama_kth ?? '-',
            $kth->desa ?? '-',
            $kth->kecamatan ?? '-',
            $kth->kabupaten ?? '-',
            $kth->kelas_kth ?? '-',
            $kth->status_kth ?? '-',
            $kth->status_verifikasi ?? '-',
            $kth->nama_ketua ?? '-',
            $kth->no_hp_ketua ?? '-',
            $kth->penyuluh->nama_lengkap ?? '-',
            $kth->tanggal_register ? \Carbon\Carbon::parse($kth->tanggal_register)->format('d/m/Y') : '-',
            $kth->created_at ? $kth->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0E4C34'],
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
            ],
        ];
    }
}