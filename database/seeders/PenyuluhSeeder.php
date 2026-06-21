<?php

namespace Database\Seeders;

use App\Models\Penyuluh;
use App\Models\User;
use Illuminate\Database\Seeder;

class PenyuluhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari user dengan role penyuluh (asumsi email 'penyuluh@example.com' dari UserSeeder)
        $user = User::where('email', 'penyuluh@example.com')->first();

        if (! $user) {
            $this->command->warn('User dengan email penyuluh@example.com tidak ditemukan. Jalankan UserSeeder terlebih dahulu.');

            return;
        }

        // Cek apakah data penyuluh sudah ada untuk user ini (agar tidak duplikat)
        $existing = Penyuluh::where('user_id', $user->id)->first();
        if ($existing) {
            $this->command->info('Data penyuluh untuk user ini sudah ada, dilewati.');

            return;
        }

        // Buat data penyuluh
        Penyuluh::create([
            'user_id' => $user->id,
            'nama_lengkap' => 'Ahmad Subarjo, S.Hut',
            'nip' => '19780512 200312 1 002',
            'golongan_pangkat' => 'Pembina Tk. I (IV/b)',
            'nik' => '3275041205780003',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1978-05-12',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Rimba Mulya No. 42, Kel. Pasir Angin, Kec. Mega Mendung, Kabupaten Bogor, Jawa Barat 16770',
            'no_telepon' => '+62 812-3456-7890',
            'email_pribadi' => 'ahmad.subarjo@gmail.com',
            'jabatan' => 'Penyuluh Kehutanan Ahli Madya',
            'wilayah_kerja' => 'BKPH Madani Timur, Jawa Barat',
        ]);

        $this->command->info('Data penyuluh berhasil dibuat untuk user '.$user->email);
    }
}
