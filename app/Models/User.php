<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi one-to-one ke Penyuluh (hanya jika role penyuluh)
    public function penyuluh()
    {
        return $this->hasOne(Penyuluh::class, 'user_id');
    }

    // Method untuk mengecek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPenyuluh()
    {
        return $this->role === 'penyuluh';
    }

    public function isPimpinan()
    {
        return $this->role === 'pimpinan';
    }

    // Relasi ke dokumentasi yang diupload
    public function dokumentasiLaporan()
    {
        return $this->hasMany(DokumentasiLaporan::class, 'uploaded_by');
    }
}
