<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKth extends Model
{
    use HasFactory;

    protected $table = 'laporan_kth';

    protected $fillable = [
        'id_kth',
        'id_penyuluh',
        'periode_laporan',
        'jenis_usaha',
        'nib',
        'pirt',
        'sertifikat_halal_file',
        'merek_dagang',
        'potensi_produksi',
        'nte_per_bulan',
        'jangkauan_pemasaran',
        'kendala_usaha',
        'kebutuhan_pengembangan',
        'keterangan_tambahan',
        'status_verifikasi',
        'catatan_revisi',
    ];

    protected $casts = [
        'periode_laporan' => 'date',
        'nte_per_bulan' => 'decimal:2',
    ];

    // Relasi ke KTH
    public function kth()
    {
        return $this->belongsTo(Kth::class, 'id_kth');
    }

    // Relasi ke Penyuluh (yang input laporan)
    public function penyuluh()
    {
        return $this->belongsTo(Penyuluh::class, 'id_penyuluh');
    }

    // Relasi ke DokumentasiLaporan
    public function dokumentasiLaporan()
    {
        return $this->hasMany(DokumentasiLaporan::class, 'id_laporan_kth');
    }
}