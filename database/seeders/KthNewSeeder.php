<?php

namespace Database\Seeders;

use App\Models\Kth;
use Illuminate\Database\Seeder;

class KthNewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar id_penyuluh
        $penyuluhIds = [
            1, 9, 10, 11, 12, 13, 14, 15, 16, 17, 
            18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28
        ];

        // Data KTH untuk setiap penyuluh (3 data per penyuluh)
        $kths = [];

        foreach ($penyuluhIds as $index => $id_penyuluh) {
            // Status verifikasi: pending, verified, rejected
            $statuses = ['pending', 'verified', 'rejected'];
            
            foreach ($statuses as $statusIndex => $status) {
                // Nama KTH dan Ketua yang berbeda-beda
                $namaKthOptions = [
                    'pending' => [
                        'Lestari Jaya',
                        'Hijau Lestari',
                        'Rimba Hijau',
                        'Sumber Rejeki',
                        'Alam Lestari',
                        'Bina Mandiri',
                        'Maju Bersama',
                        'Tani Makmur',
                        'Harapan Baru',
                        'Sejahtera Abadi',
                        'Cemerlang',
                        'Asri Lestari',
                        'Bahagia',
                        'Makmur Sentosa',
                        'Griya Asri',
                        'Sumber Makmur',
                        'Berkah Alam',
                        'Rindang Lestari',
                        'Tunas Muda',
                        'Karya Bakti',
                        'Wana Lestari',
                        'Segara Asri',
                        'Cipta Karya',
                        'Mitra Tani',
                        'Sinar Harapan',
                    ],
                    'verified' => [
                        'Mutiara Hijau',
                        'Kencana Lestari',
                        'Tirta Alam',
                        'Gunung Sejahtera',
                        'Sumber Sari',
                        'Bumi Lestari',
                        'Duta Tani',
                        'Tani Sejahtera',
                        'Rimba Raya',
                        'Karya Mandiri',
                        'Sumber Agung',
                        'Tani Jaya',
                        'Lestari Abadi',
                        'Sejahtera Mandiri',
                        'Tani Asri',
                        'Karya Lestari',
                        'Bina Lestari',
                        'Maju Lestari',
                        'Tani Sentosa',
                        'Rimba Jaya',
                        'Tani Mulya',
                        'Sumber Lestari',
                        'Berkah Lestari',
                        'Tani Subur',
                        'Alam Asri',
                    ],
                    'rejected' => [
                        'Cipta Lestari',
                        'Bina Sejahtera',
                        'Tani Berkah',
                        'Rimba Subur',
                        'Sumber Tani',
                        'Karya Tani',
                        'Maju Tani',
                        'Tani Lestari',
                        'Bumi Sejahtera',
                        'Tani Cemerlang',
                        'Lestari Asri',
                        'Tani Mandiri',
                        'Sumber Alam',
                        'Bina Tani',
                        'Tani Raya',
                        'Karya Sejahtera',
                        'Tani Bahagia',
                        'Rimba Mandiri',
                        'Tani Abadi',
                        'Lestari Jaya',
                        'Sumber Jaya',
                        'Tani Kencana',
                        'Bumi Tani',
                        'Alam Sejahtera',
                        'Tani Berjaya',
                    ]
                ];

                // Nama Ketua yang berbeda-beda
                $namaKetuaOptions = [
                    'Slamet Riyadi',
                    'Ahmad Subandi',
                    'Mohammad Ali',
                    'Suharto',
                    'Sutrisno',
                    'Muhammad Fahrur',
                    'Junaidi',
                    'Karsono',
                    'Bambang Wibowo',
                    'Agus Santoso',
                    'Budi Santoso',
                    'Eko Prasetyo',
                    'Gatot Subroto',
                    'Indra Setiawan',
                    'Abdul Manan',
                    'Sujianto',
                    'Taufik Hidayat',
                    'Muhammad Nasir',
                    'Slamet Santoso',
                    'Achmad Zaini',
                    'Miftahul Huda',
                    'Khairul Anam',
                    'Abdurrahman',
                    'Muhammad Syafi',
                    'Ahmad Fauzi',
                ];

                // Kecamatan options
                $kecamatanOptions = [
                    'Kalianget',
                    'Kota Sumenep',
                    'Gili Genting',
                    'Bluto',
                    'Dungkek',
                    'Gapura',
                    'Batuputih',
                    'Ganding',
                    'Banyuates',
                    'Pamekasan',
                    'Sampang',
                    'Bangkalan',
                ];

                $desaOptions = [
                    'Kalianget',
                    'Pabian',
                    'Gili Genting',
                    'Bluto',
                    'Dungkek',
                    'Gapura',
                    'Batuputih',
                    'Ganding',
                    'Banyuates',
                    'Pamekasan',
                ];

                // Hitung index untuk memilih nama yang berbeda
                $nameIndex = ($id_penyuluh + $statusIndex) % count($namaKthOptions[$status]);
                $ketuaIndex = ($id_penyuluh + $statusIndex * 2) % count($namaKetuaOptions);
                $kecIndex = ($id_penyuluh + $statusIndex * 3) % count($kecamatanOptions);
                $desaIndex = ($id_penyuluh + $statusIndex * 5) % count($desaOptions);

                // Generate nomor register
                $nomorRegister = 'REG-' . str_pad($id_penyuluh, 3, '0', STR_PAD_LEFT) . 
                                 '/' . strtoupper(substr($namaKthOptions[$status][$nameIndex], 0, 3)) . 
                                 '/' . (2024 - $statusIndex);

                // Tanggal register
                $tanggalRegister = date('Y-m-d', strtotime('-' . ($statusIndex * 30) . ' days'));

                // Status KTH: Aktif atau Tidak Aktif
                $statusKth = ($statusIndex === 2) ? 'Tidak Aktif' : 'Aktif';
                $tahunTidakAktif = ($statusKth === 'Tidak Aktif') ? (2024 - $statusIndex) : null;

                $kths[] = [
                    'id_penyuluh' => $id_penyuluh,
                    'nama_kth' => $namaKthOptions[$status][$nameIndex],
                    'kelas_kth' => ['Pemula', 'Madya', 'Utama'][$statusIndex],
                    'desa' => $desaOptions[$desaIndex],
                    'kecamatan' => $kecamatanOptions[$kecIndex],
                    'kabupaten' => 'Sumenep',
                    'latitude' => -7.0 - ($id_penyuluh / 100) - ($statusIndex / 1000),
                    'longitude' => 113.0 + ($id_penyuluh / 100) + ($statusIndex / 1000),
                    'nama_ketua' => $namaKetuaOptions[$ketuaIndex],
                    'no_hp_ketua' => '0812' . str_pad($id_penyuluh, 4, '0', STR_PAD_LEFT) . str_pad($statusIndex, 2, '0', STR_PAD_LEFT),
                    'nomor_register' => $nomorRegister,
                    'tanggal_register' => $tanggalRegister,
                    'status_kth' => $statusKth,
                    'tahun_tidak_aktif' => $tahunTidakAktif,
                    'status_verifikasi' => $status,
                    'catatan_revisi' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert data
        foreach ($kths as $kth) {
            Kth::create($kth);
        }
    }
}