<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kth extends Model
{
    use HasFactory;

    protected $table = 'kth';

    protected $fillable = [
        'id_penyuluh',
        'nama_kth',
        'kelas_kth',
        'desa',
        'kecamatan',
        'kabupaten',
        'latitude',
        'longitude',
        'nama_ketua',
        'no_hp_ketua',
        'nomor_register',
        'tanggal_register',
        'status_kth',
        'tahun_tidak_aktif',
        'status_verifikasi',
        'catatan_revisi',
    ];

    protected $casts = [
        'tanggal_register' => 'date',
        'tahun_tidak_aktif' => 'integer',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    // Relasi ke Penyuluh (yang menginput KTH)
    public function penyuluh()
    {
        return $this->belongsTo(Penyuluh::class, 'id_penyuluh');
    }

    // Relasi ke LaporanKTH
    public function laporanKth()
    {
        return $this->hasMany(LaporanKth::class, 'id_kth');
    }
}