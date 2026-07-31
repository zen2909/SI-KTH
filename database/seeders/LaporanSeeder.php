<?php

namespace Database\Seeders;

use App\Models\LaporanKth;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        // Data sepasang id_kth dan id_penyuluh
        $kthPenyuluhPairs = [
            ['id_kth' => 130, 'id_penyuluh' => 1],
            ['id_kth' => 131, 'id_penyuluh' => 1],
            ['id_kth' => 132, 'id_penyuluh' => 1],
            ['id_kth' => 133, 'id_penyuluh' => 9],
            ['id_kth' => 134, 'id_penyuluh' => 9],
            ['id_kth' => 135, 'id_penyuluh' => 9],
            ['id_kth' => 136, 'id_penyuluh' => 10],
            ['id_kth' => 137, 'id_penyuluh' => 10],
            ['id_kth' => 138, 'id_penyuluh' => 10],
            ['id_kth' => 139, 'id_penyuluh' => 11],
            ['id_kth' => 140, 'id_penyuluh' => 11],
            ['id_kth' => 141, 'id_penyuluh' => 11],
            ['id_kth' => 142, 'id_penyuluh' => 12],
            ['id_kth' => 143, 'id_penyuluh' => 12],
            ['id_kth' => 144, 'id_penyuluh' => 12],
            ['id_kth' => 145, 'id_penyuluh' => 13],
            ['id_kth' => 146, 'id_penyuluh' => 13],
            ['id_kth' => 147, 'id_penyuluh' => 13],
            ['id_kth' => 148, 'id_penyuluh' => 14],
            ['id_kth' => 149, 'id_penyuluh' => 14],
            ['id_kth' => 150, 'id_penyuluh' => 14],
            ['id_kth' => 151, 'id_penyuluh' => 15],
            ['id_kth' => 152, 'id_penyuluh' => 15],
            ['id_kth' => 153, 'id_penyuluh' => 15],
            ['id_kth' => 154, 'id_penyuluh' => 16],
            ['id_kth' => 155, 'id_penyuluh' => 16],
            ['id_kth' => 156, 'id_penyuluh' => 16],
            ['id_kth' => 157, 'id_penyuluh' => 17],
            ['id_kth' => 158, 'id_penyuluh' => 17],
            ['id_kth' => 159, 'id_penyuluh' => 17],
            ['id_kth' => 160, 'id_penyuluh' => 18],
            ['id_kth' => 161, 'id_penyuluh' => 18],
            ['id_kth' => 162, 'id_penyuluh' => 18],
            ['id_kth' => 163, 'id_penyuluh' => 19],
            ['id_kth' => 164, 'id_penyuluh' => 19],
            ['id_kth' => 165, 'id_penyuluh' => 19],
            ['id_kth' => 166, 'id_penyuluh' => 20],
            ['id_kth' => 167, 'id_penyuluh' => 20],
            ['id_kth' => 168, 'id_penyuluh' => 20],
            ['id_kth' => 169, 'id_penyuluh' => 21],
            ['id_kth' => 170, 'id_penyuluh' => 21],
            ['id_kth' => 171, 'id_penyuluh' => 21],
            ['id_kth' => 172, 'id_penyuluh' => 22],
            ['id_kth' => 173, 'id_penyuluh' => 22],
            ['id_kth' => 174, 'id_penyuluh' => 22],
            ['id_kth' => 175, 'id_penyuluh' => 23],
            ['id_kth' => 176, 'id_penyuluh' => 23],
            ['id_kth' => 177, 'id_penyuluh' => 23],
            ['id_kth' => 178, 'id_penyuluh' => 24],
            ['id_kth' => 179, 'id_penyuluh' => 24],
            ['id_kth' => 180, 'id_penyuluh' => 24],
            ['id_kth' => 181, 'id_penyuluh' => 25],
            ['id_kth' => 182, 'id_penyuluh' => 25],
            ['id_kth' => 183, 'id_penyuluh' => 25],
            ['id_kth' => 184, 'id_penyuluh' => 26],
            ['id_kth' => 185, 'id_penyuluh' => 26],
            ['id_kth' => 186, 'id_penyuluh' => 26],
            ['id_kth' => 187, 'id_penyuluh' => 27],
            ['id_kth' => 188, 'id_penyuluh' => 27],
            ['id_kth' => 189, 'id_penyuluh' => 27],
            ['id_kth' => 190, 'id_penyuluh' => 28],
            ['id_kth' => 191, 'id_penyuluh' => 28],
            ['id_kth' => 192, 'id_penyuluh' => 28],
        ];

        $laporans = [];

        // Data untuk jenis usaha
        $jenisUsahaOptions = [
            'Kayu Olahan',
            'Madu Hutan',
            'Getah Pinus',
            'Kopi Liberika',
            'Karet Alam',
            'Gaharu',
            'Rotan',
            'Bambu',
            'Daun Kayu Putih',
            'Kemiri'
        ];

        // Data untuk jangkauan pemasaran
        $jangkauanOptions = [
            'Lokal',
            'Kabupaten',
            'Provinsi',
            'Nasional',
            'Ekspor'
        ];

        // Data untuk kendala usaha
        $kendalaOptions = [
            'Modal terbatas',
            'Akses pasar sulit',
            'Harga fluktuatif',
            'Cuaca ekstrim',
            'Hama dan penyakit',
            'Keterbatasan alat produksi'
        ];

        // Data untuk kebutuhan pengembangan
        $kebutuhanOptions = [
            'Pelatihan manajemen',
            'Peralatan produksi',
            'Modal usaha',
            'Sertifikasi produk',
            'Pemasaran digital',
            'Kemitraan strategis'
        ];

        // Data untuk satuan produksi
        $satuanOptions = ['Kg', 'Ton', 'Liter', 'Unit'];

        // Periode laporan 2026 (Januari - Desember)
        $periodeOptions = [
            '2026-01-01',
            '2026-02-01',
            '2026-03-01',
            '2026-04-01',
            '2026-05-01',
            '2026-06-01',
            '2026-07-01',
            '2026-08-01',
            '2026-09-01',
            '2026-10-01',
            '2026-11-01',
            '2026-12-01'
        ];

        // Status verifikasi
        $statuses = ['pending', 'verified', 'rejected'];

        foreach ($kthPenyuluhPairs as $index => $pair) {
            // Setiap KTH punya jumlah laporan per bulan yang bervariasi
            // 1-3 laporan per bulan (tidak ada yang 0)
            $monthlyCount = [
                0 => rand(1, 3),  // Jan
                1 => rand(1, 3),  // Feb
                2 => rand(1, 3),  // Mar
                3 => rand(1, 3),  // Apr
                4 => rand(1, 3),  // Mei
                5 => rand(1, 3),  // Jun
                6 => rand(1, 3),  // Jul
                7 => rand(1, 3),  // Agu
                8 => rand(1, 3),  // Sep
                9 => rand(1, 3),  // Okt
                10 => rand(1, 3), // Nov
                11 => rand(1, 3), // Des
            ];

            // Buat beberapa bulan dengan jumlah yang lebih banyak (3-5) untuk variasi
            $bulanBanyak = array_rand($monthlyCount, 3);
            foreach ($bulanBanyak as $bulan) {
                $monthlyCount[$bulan] = rand(3, 5);
            }

            // Buat beberapa bulan dengan jumlah yang lebih sedikit (1) untuk variasi
            $bulanSedikit = array_rand($monthlyCount, 2);
            foreach ($bulanSedikit as $bulan) {
                $monthlyCount[$bulan] = 1;
            }

            foreach ($monthlyCount as $month => $count) {
                for ($i = 0; $i < $count; $i++) {
                    $status = $statuses[($month + $i) % count($statuses)];
                    $periode = $periodeOptions[$month];

                    // Data random
                    $jenisUsahaIndex = ($index + $month * 2 + $i * 3) % count($jenisUsahaOptions);
                    $jangkauanIndex = ($index + $month * 3 + $i * 5) % count($jangkauanOptions);
                    $kendalaIndex = ($index + $month * 5 + $i * 7) % count($kendalaOptions);
                    $kebutuhanIndex = ($index + $month * 7 + $i * 11) % count($kebutuhanOptions);
                    $satuanIndex = ($index + $month * 11 + $i * 13) % count($satuanOptions);

                    $potensiProduksi = rand(50, 500);
                    $ntePerBulan = rand(500000, 5000000);

                    // Catatan revisi hanya untuk rejected
                    $catatanRevisi = null;
                    if ($status === 'rejected') {
                        $catatanRevisi = 'Perbaiki data produksi dan lengkapi dokumentasi pendukung.';
                    }

                    $laporans[] = [
                        'id_kth' => $pair['id_kth'],
                        'id_penyuluh' => $pair['id_penyuluh'],
                        'periode_laporan' => $periode,
                        'jenis_usaha' => $jenisUsahaOptions[$jenisUsahaIndex],
                        'nib' => 'NIB-' . str_pad($pair['id_kth'], 5, '0', STR_PAD_LEFT) . '-' . str_pad($month + 1, 2, '0', STR_PAD_LEFT) . str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                        'pirt' => 'PIRT-' . str_pad($pair['id_penyuluh'], 3, '0', STR_PAD_LEFT) . str_pad($month + 1, 2, '0', STR_PAD_LEFT) . str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                        'sertifikat_halal_file' => null,
                        'merek_dagang' => 'Produk ' . $jenisUsahaOptions[$jenisUsahaIndex] . ' ' . str_pad($pair['id_kth'], 3, '0', STR_PAD_LEFT),
                        'potensi_produksi' => $potensiProduksi,
                        'satuan_produksi' => $satuanOptions[$satuanIndex],
                        'nte_per_bulan' => $ntePerBulan,
                        'jangkauan_pemasaran' => $jangkauanOptions[$jangkauanIndex],
                        'kendala_usaha' => $kendalaOptions[$kendalaIndex],
                        'kebutuhan_pengembangan' => $kebutuhanOptions[$kebutuhanIndex],
                        'keterangan_tambahan' => 'Laporan periode ' . date('F Y', strtotime($periode)) . ' dengan jenis usaha ' . $jenisUsahaOptions[$jenisUsahaIndex],
                        'status_verifikasi' => $status,
                        'catatan_revisi' => $catatanRevisi,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Insert data
        foreach ($laporans as $laporan) {
            LaporanKth::create($laporan);
        }
    }
}