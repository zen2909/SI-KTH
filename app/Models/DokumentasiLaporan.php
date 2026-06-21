<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentasiLaporan extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi_laporan';

    protected $fillable = [
        'id_laporan_kth',
        'file_path',
        'keterangan',
        'uploaded_by',
    ];

    // Relasi ke LaporanKth
    public function laporanKth()
    {
        return $this->belongsTo(LaporanKth::class, 'id_laporan_kth');
    }

    // Relasi ke User (uploader)
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
