<?php

namespace App\Exports;

use App\Models\LaporanKth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
        return LaporanKth::with(['kth', 'penyuluh'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama KTH',
            'Jenis Usaha',
            'Periode Laporan',
            'Status Verifikasi',
            'Nama Penyuluh',
            'NIB',
            'PIRT',
            'Merek Dagang',
            'Potensi Produksi',
            'Satuan Produksi',
            'NTE per Bulan',
            'Jangkauan Pemasaran',
            'Kendala Usaha',
            'Kebutuhan Pengembangan',
            'Dibuat Pada',
        ];
    }

    public function map($laporan): array
    {
        static $row = 0;
        $row++;

        $statusLabels = [
            'pending' => 'Pending',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
        ];

        return [
            $row,
            $laporan->kth->nama_kth ?? '-',
            $laporan->jenis_usaha ?? '-',
            $laporan->periode_laporan ? $laporan->periode_laporan->format('F Y') : '-',
            $statusLabels[$laporan->status_verifikasi] ?? $laporan->status_verifikasi,
            $laporan->penyuluh->nama_lengkap ?? '-',
            $laporan->nib ?? '-',
            $laporan->pirt ?? '-',
            $laporan->merek_dagang ?? '-',
            $laporan->potensi_produksi ?? '-',
            $laporan->satuan_produksi ?? '-',
            $laporan->nte_per_bulan ?? '-',
            $laporan->jangkauan_pemasaran ?? '-',
            $laporan->kendala_usaha ?? '-',
            $laporan->kebutuhan_pengembangan ?? '-',
            $laporan->created_at ? $laporan->created_at->format('d/m/Y H:i') : '-',
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