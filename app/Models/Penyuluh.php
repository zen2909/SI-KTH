<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyuluh extends Model
{
    use HasFactory;

    protected $table = 'penyuluh';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nip',
        'golongan_pangkat',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'email_pribadi',
        'jabatan',
        'wilayah_kerja',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi inverse ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke KTH (sebagai penyuluh yang menginput)
    public function kth()
    {
        return $this->hasMany(Kth::class, 'id_penyuluh');
    }

    // Relasi ke LaporanKTH (sebagai penyuluh yang input laporan)
    public function laporanKth()
    {
        return $this->hasMany(LaporanKth::class, 'id_penyuluh');
    }
}