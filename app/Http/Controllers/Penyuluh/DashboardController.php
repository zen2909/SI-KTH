<?php

namespace App\Http\Controllers\Penyuluh;

use App\Http\Controllers\Controller;
use App\Models\Kth;
use App\Models\LaporanKth;
use App\Models\User;
use App\Models\Penyuluh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $penyuluh = $user->penyuluh;

        // Total KTH
        $totalKTH = Kth::where('id_penyuluh', $penyuluh->id)->count();

        // Total KTH per status verifikasi
        $pendingKTH = Kth::where('id_penyuluh', $penyuluh->id)
            ->where('status_verifikasi', 'pending')
            ->count();

        $verifiedKTH = Kth::where('id_penyuluh', $penyuluh->id)
            ->where('status_verifikasi', 'verified')
            ->count();

        $rejectedKTH = Kth::where('id_penyuluh', $penyuluh->id)
            ->where('status_verifikasi', 'rejected')
            ->count();

        // Total Laporan
        $totalLaporan = LaporanKth::where('id_penyuluh', $penyuluh->id)->count();

        // Total Laporan per status verifikasi
        $pendingLaporan = LaporanKth::where('id_penyuluh', $penyuluh->id)
            ->where('status_verifikasi', 'pending')
            ->count();

        $verifiedLaporan = LaporanKth::where('id_penyuluh', $penyuluh->id)
            ->where('status_verifikasi', 'verified')
            ->count();

        $rejectedLaporan = LaporanKth::where('id_penyuluh', $penyuluh->id)
            ->where('status_verifikasi', 'rejected')
            ->count();

        // Persentase untuk donut chart (KTH)
        $totalAllKTH = $totalKTH > 0 ? $totalKTH : 1;
        $verifiedPercent = round(($verifiedKTH / $totalAllKTH) * 100);
        $pendingPercent = round(($pendingKTH / $totalAllKTH) * 100);
        $rejectedPercent = round(($rejectedKTH / $totalAllKTH) * 100);

        // 🔥 DATA UNTUK GRAFIK LAPORAN PER BULAN (JANUARI - DESEMBER)
        $bulanList = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $data = array_fill(0, 12, 0);

        // 🔥 AMBIL DATA LAPORAN PER BULAN UNTUK TAHUN BERJALAN
        $tahunIni = now()->year;
        $laporanData = LaporanKth::where('id_penyuluh', $penyuluh->id)
            ->whereYear('periode_laporan', $tahunIni)
            ->select(
                \Illuminate\Support\Facades\DB::raw('EXTRACT(MONTH FROM periode_laporan) as month'),
                \Illuminate\Support\Facades\DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('periode_laporan')
            ->groupBy(\Illuminate\Support\Facades\DB::raw('EXTRACT(MONTH FROM periode_laporan)'))
            ->orderBy(\Illuminate\Support\Facades\DB::raw('EXTRACT(MONTH FROM periode_laporan)'), 'asc')
            ->get();

        // 🔥 MAP DATA KE BULAN YANG SESUAI
        foreach ($laporanData as $item) {
            $monthIndex = (int) $item->month - 1; // 0 = Januari
            if ($monthIndex >= 0 && $monthIndex < 12) {
                $data[$monthIndex] = (int) $item->total;
            }
        }

        $chartData = [
            'labels' => $bulanList,
            'data' => $data,
            'maxValue' => max($data) > 0 ? max($data) : 10,
        ];

        return view('penyuluh.index', compact(
            'totalKTH',
            'pendingKTH',
            'verifiedKTH',
            'rejectedKTH',
            'totalLaporan',
            'pendingLaporan',
            'verifiedLaporan',
            'rejectedLaporan',
            'verifiedPercent',
            'pendingPercent',
            'rejectedPercent',
            'chartData'
        ));
    }

    /**
     * Get data laporan per bulan untuk 6 bulan terakhir
     */
    private function getLaporanPerBulan($penyuluhId)
    {
        $labels = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->format('M');

            $count = LaporanKth::where('id_penyuluh', $penyuluhId)
                ->whereYear('periode_laporan', $month->year)
                ->whereMonth('periode_laporan', $month->month)
                ->count();

            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
