<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role jika belum ada (gunakan guard 'web')
        $roles = ['admin', 'penyuluh', 'pimpinan'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Data user untuk masing-masing role
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => 'password',
            ],
            [
                'name' => 'Penyuluh Lapangan',
                'email' => 'penyuluh@example.com',
                'role' => 'penyuluh',
                'password' => 'password',
            ],
            [
                'name' => 'Pimpinan Dinas',
                'email' => 'pimpinan@example.com',
                'role' => 'pimpinan',
                'password' => 'password',
            ],
        ];

        foreach ($users as $data) {
            // Cek apakah user dengan email tersebut sudah ada, jika belum buat
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'], // isi kolom enum sesuai PRD
                    'foto_profil' => null,       // default null
                ]
            );

            // Assign role via Spatie
            $user->assignRole($data['role']);
        }

        $this->command->info('Seeder User berhasil: 1 admin, 1 penyuluh, 1 pimpinan dibuat.');
    }
}
