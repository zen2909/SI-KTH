<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserNewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            // ============================================
            // ADMIN (2 user)
            // ============================================
            [
                'name' => 'Admin Utama',
                'email' => 'admin@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'admin',
                'foto_profil' => null,
            ],
            [
                'name' => 'Admin Sekunder',
                'email' => 'admin2@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'admin',
                'foto_profil' => null,
            ],

            // ============================================
            // PIMPINAN (2 user)
            // ============================================
            [
                'name' => 'Dr. Ir. Kepala Dinas Kehutanan',
                'email' => 'pimpinan@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'pimpinan',
                'foto_profil' => null,
            ],
            [
                'name' => 'Ir. Sekretaris Dinas Kehutanan',
                'email' => 'pimpinan2@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'pimpinan',
                'foto_profil' => null,
            ],

            // ============================================
            // PENYULUH (20 user)
            // ============================================
            [
                'name' => 'Dr. Ir. Slamet Riyadi, M.Si',
                'email' => 'slamet.riyadi@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Ir. Siti Aisyah, M.P',
                'email' => 'siti.aisyah@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Drs. Ahmad Subandi, S.Hut',
                'email' => 'ahmad.subandi@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Ir. Mohammad Ali, M.M',
                'email' => 'mohammad.ali@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Dra. Suharto, M.Si',
                'email' => 'suharto@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Ir. Sutrisno, M.P',
                'email' => 'sutrisno@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Dra. Siti Aisyah, S.Hut',
                'email' => 'siti.aisyah2@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Drs. Muhammad Fahrur, M.Si',
                'email' => 'fahrur.muhammad@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Ir. Junaidi, S.Hut',
                'email' => 'junaidi@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Dra. Karsono, M.Pd',
                'email' => 'karsono@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Ir. Bambang Wibowo, M.Si',
                'email' => 'bambang.wibowo@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Dra. Dewi Kartika, M.P',
                'email' => 'dewi.kartika@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Drs. Agus Santoso, S.Hut',
                'email' => 'agus.santoso@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Ir. Rina Marlina, M.M',
                'email' => 'rina.marlina@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Dra. Budi Santoso, M.Si',
                'email' => 'budi.santoso@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Ir. Eko Prasetyo, M.P',
                'email' => 'eko.prasetyo@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Dra. Fitri Handayani, S.Hut',
                'email' => 'fitri.handayani@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Drs. Gatot Subroto, M.Si',
                'email' => 'gatot.subroto@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Ir. Hesti Wahyuni, M.M',
                'email' => 'hesti.wahyuni@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
            [
                'name' => 'Dra. Indra Setiawan, M.Pd',
                'email' => 'indra.setiawan@disperhut.sumenepprov.go.id',
                'password' => 'password',
                'plain_password' => 'password',
                'role' => 'penyuluh',
                'foto_profil' => null,
            ],
        ];

        foreach ($users as $data) {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'plain_password' => $data['plain_password'],
                'role' => $data['role'],
                'foto_profil' => $data['foto_profil'],
            ]);
        }
    }
}