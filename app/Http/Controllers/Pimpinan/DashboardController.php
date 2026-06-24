<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Kth;
use App\Models\LaporanKth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    // Ambil tahun dari request, default tahun sekarang
    $selectedYear = $request->input('year', now()->year);
    
    // Statistik KTH
    $totalKTH = Kth::count();
    $kthVerified = Kth::where('status_verifikasi', 'verified')->count();
    $kthPending = Kth::where('status_verifikasi', 'pending')->count();
    $kthRejected = Kth::where('status_verifikasi', 'rejected')->count();
    $kthAktif = Kth::where('status_kth', 'Aktif')->count();

    // Statistik Laporan
    $totalLaporan = LaporanKth::count();
    $laporanVerified = LaporanKth::where('status_verifikasi', 'verified')->count();
    $laporanPending = LaporanKth::where('status_verifikasi', 'pending')->count();
    $laporanRejected = LaporanKth::where('status_verifikasi', 'rejected')->count();

    // Statistik User
    $totalUser = User::count();
    $totalPenyuluh = User::where('role', 'penyuluh')->count();
    $totalAdmin = User::where('role', 'admin')->count();
    $totalPimpinan = User::where('role', 'pimpinan')->count();

    // Verification Status KTH
    $verifiedPercent = $totalKTH > 0 ? round(($kthVerified / $totalKTH) * 100) : 0;
    $pendingPercent = $totalKTH > 0 ? round(($kthPending / $totalKTH) * 100) : 0;
    $rejectedPercent = $totalKTH > 0 ? round(($kthRejected / $totalKTH) * 100) : 0;

    // 🔥 Persentase Laporan
    $laporanVerifiedPercent = $totalLaporan > 0 ? round(($laporanVerified / $totalLaporan) * 100) : 0;
    $laporanPendingPercent = $totalLaporan > 0 ? round(($laporanPending / $totalLaporan) * 100) : 0;
    $laporanRejectedPercent = $totalLaporan > 0 ? round(($laporanRejected / $totalLaporan) * 100) : 0;

    // 🔥 KTH Class Distribution - Cek data sebenarnya
    $kelasUtama = Kth::where('kelas_kth', 'ILIKE', 'utama')->count();
$kelasMadya = Kth::where('kelas_kth', 'ILIKE', 'madya')->count();
$kelasPemula = Kth::where('kelas_kth', 'ILIKE', 'pemula')->count();
$totalKelas = $kelasUtama + $kelasMadya + $kelasPemula;

    // 🔥 DEBUG: Cek data KTH
    // Hapus komentar di bawah untuk debug
    // dd([
    //     'totalKTH' => $totalKTH,
    //     'kelasUtama' => $kelasUtama,
    //     'kelasMadya' => $kelasMadya,
    //     'kelasPemula' => $kelasPemula,
    //     'totalKelas' => $totalKelas,
    //     'sample_kth' => Kth::select('id', 'nama_kth', 'kelas_kth')->limit(5)->get()->toArray()
    // ]);

    // Persentase
    $kelasUtamaPercent = $totalKelas > 0 ? round(($kelasUtama / $totalKelas) * 100) : 0;
    $kelasMadyaPercent = $totalKelas > 0 ? round(($kelasMadya / $totalKelas) * 100) : 0;
    $kelasPemulaPercent = $totalKelas > 0 ? round(($kelasPemula / $totalKelas) * 100) : 0;

    // 🔥 CEK: Jika total 100% tapi ada pembulatan yang menyebabkan kurang dari 100
    $totalPersen = $kelasUtamaPercent + $kelasMadyaPercent + $kelasPemulaPercent;
    if ($totalPersen < 100 && $totalPersen > 0) {
        $selisih = 100 - $totalPersen;
        $maxPercent = max($kelasUtamaPercent, $kelasMadyaPercent, $kelasPemulaPercent);
        if ($kelasUtamaPercent == $maxPercent) {
            $kelasUtamaPercent += $selisih;
        } elseif ($kelasMadyaPercent == $maxPercent) {
            $kelasMadyaPercent += $selisih;
        } else {
            $kelasPemulaPercent += $selisih;
        }
    }

    // 🔥 NTE TREND dengan pemilihan tahun
    $nteData = $this->getNTETrend($selectedYear);
    $nteTrend = $nteData['trend'];
    $maxNte = $nteData['max'];
    $months = $nteData['months'];
    $satuan = $nteData['satuan'];
    $hasData = $nteData['hasData'];
    
    $currentYear = now()->year;
    $years = range(1990, $currentYear);
    $years = array_reverse($years);

    // Critical Regional Updates
    $updates = [];

    $recentKTH = Kth::where('status_verifikasi', 'verified')
        ->orderBy('updated_at', 'desc')
        ->limit(3)
        ->get();

    foreach ($recentKTH as $kth) {
        $updates[] = [
            'type' => 'success',
            'icon_class' => 'bg-green-100',
            'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
            'icon_color' => 'text-green-700',
            'title' => $kth->nama_kth . ' - KTH Terverifikasi',
            'description' => 'Data KTH ' . $kth->nama_kth . ' telah berhasil diverifikasi oleh admin.',
            'time' => $kth->updated_at->diffForHumans(),
            'button_text' => 'Lihat Detail',
            'button_link' => '#',
        ];
    }

    // 🔥 KTH Paling Aktif
    $kthPalingAktif = DB::table('laporan_kth')
        ->join('kth', 'laporan_kth.id_kth', '=', 'kth.id')
        ->select(
            'kth.id',
            'kth.nama_kth',
            DB::raw('COUNT(laporan_kth.id) as jumlah_laporan')
        )
        ->groupBy('kth.id', 'kth.nama_kth')
        ->orderBy('jumlah_laporan', 'desc')
        ->limit(5)
        ->get();

    $recentLaporan = LaporanKth::with('kth')
        ->where('status_verifikasi', 'pending')
        ->orderBy('created_at', 'desc')
        ->limit(2)
        ->get();

    foreach ($recentLaporan as $laporan) {
        $updates[] = [
            'type' => 'warning',
            'icon_class' => 'bg-rose-200',
            'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>',
            'icon_color' => 'text-red-700',
            'title' => 'Laporan Baru dari ' . ($laporan->kth->nama_kth ?? 'KTH'),
            'description' => 'Laporan ' . ($laporan->jenis_usaha ?? '') . ' menunggu verifikasi.',
            'time' => $laporan->created_at->diffForHumans(),
            'button_text' => 'Review',
            'button_link' => '#',
        ];
    }

    usort($updates, function ($a, $b) {
        return strtotime($b['time']) - strtotime($a['time']);
    });

    $updates = array_slice($updates, 0, 5);

    $avgNTE = LaporanKth::where('status_verifikasi', 'verified')->avg('nte_per_bulan') ?? 0;

    return view('pimpinan.index', compact(
        'totalKTH',
        'kthVerified',
        'kthPending',
        'kthRejected',
        'kthAktif',
        'totalLaporan',
        'laporanVerified',
        'laporanPending',
        'laporanRejected',
        'laporanVerifiedPercent',
        'laporanPendingPercent',
        'laporanRejectedPercent',
        'totalUser',
        'totalPenyuluh',
        'totalAdmin',
        'totalPimpinan',
        'verifiedPercent',
        'pendingPercent',
        'rejectedPercent',
        'kthPalingAktif',
        'kelasUtama',
        'kelasMadya',
        'kelasPemula',
        'kelasUtamaPercent',
        'kelasMadyaPercent',
        'kelasPemulaPercent',
        'nteTrend',
        'maxNte',
        'months',
        'satuan',
        'selectedYear',
        'years',
        'hasData',
        'updates',
        'avgNTE'
    ));
}

    /**
     * 🔥 AJAX endpoint untuk mendapatkan data chart
     */
    public function getChartData(Request $request)
    {
        $year = $request->input('year', now()->year);
        $nteData = $this->getNTETrend($year);
        
        return response()->json([
            'success' => true,
            'data' => [
                'trend' => $nteData['trend'],
                'max' => $nteData['max'],
                'months' => $nteData['months'],
                'satuan' => $nteData['satuan'],
                'hasData' => $nteData['hasData'],
                'year' => $year
            ]
        ]);
    }

    /**
     * 🔥 PRIVATE METHOD - Get NTE trend dengan satuan otomatis
     */
    private function getNTETrend($year = null)
    {
        $year = $year ?? now()->year;
        $nteTrend = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $maxValue = 0;
        $hasData = false;

        // Ambil data mentah untuk tahun yang dipilih
        for ($i = 1; $i <= 12; $i++) {
            $monthData = LaporanKth::whereMonth('periode_laporan', $i)
                ->whereYear('periode_laporan', $year)
                ->where('status_verifikasi', 'verified')
                ->sum('nte_per_bulan');
            
            $nteTrend[] = $monthData;
            
            if ($monthData > 0) {
                $hasData = true;
            }
            
            if ($monthData > $maxValue) {
                $maxValue = $monthData;
            }
        }
        $maxValue = $maxValue > 0 ? $maxValue : 1;

        // Tentukan satuan berdasarkan nilai maksimum
        if ($maxValue >= 1000000) {
            $divider = 1000000;
            $satuan = 'Jt';
        } elseif ($maxValue >= 1000) {
            $divider = 1000;
            $satuan = 'K';
        } else {
            $divider = 1;
            $satuan = '';
        }

        // Konversi semua nilai
        $convertedTrend = [];
        foreach ($nteTrend as $value) {
            $convertedTrend[] = $divider > 1 ? round($value / $divider, 1) : $value;
        }

        return [
            'trend' => $convertedTrend,
            'max' => $divider > 1 ? round($maxValue / $divider, 1) : $maxValue,
            'months' => $months,
            'satuan' => $satuan,
            'hasData' => $hasData
        ];
    }

    /**
     * Get KTH data for map
     */
    public function mapData()
    {
        try {
            $kths = Kth::select('id', 'nama_kth', 'desa', 'kecamatan', 'kelas_kth', 'status_verifikasi', 'latitude', 'longitude')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();

            return response()->json($kths);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}