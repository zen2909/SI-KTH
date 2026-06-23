<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kth;
use App\Models\LaporanKth;
use App\Models\Penyuluh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik KTH
        $totalKTH = Kth::count();
        $kthVerified = Kth::where('status_verifikasi', 'verified')->count();
        $kthPending = Kth::where('status_verifikasi', 'pending')->count();
        $kthRejected = Kth::where('status_verifikasi', 'rejected')->count();

        // Statistik Laporan
        $totalLaporan = LaporanKth::count();
        $laporanPending = LaporanKth::where('status_verifikasi', 'pending')->count();
        $laporanVerified = LaporanKth::where('status_verifikasi', 'verified')->count();
        $laporanRejected = LaporanKth::where('status_verifikasi', 'rejected')->count();

        // Statistik User
        $totalUser = User::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalPenyuluh = User::where('role', 'penyuluh')->count();
        $totalPimpinan = User::where('role', 'pimpinan')->count();

        // Data untuk grafik status KTH
        $kthStatusData = [
            'verified' => $kthVerified,
            'pending' => $kthPending,
            'rejected' => $kthRejected,
        ];

        // Data untuk grafik laporan per bulan (12 bulan terakhir)
        $laporanPerBulan = LaporanKth::select(
            DB::raw('EXTRACT(MONTH FROM periode_laporan) as bulan'),
            DB::raw('EXTRACT(YEAR FROM periode_laporan) as tahun'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('periode_laporan', now()->year)
        ->groupBy('bulan', 'tahun')
        ->orderBy('bulan')
        ->get()
        ->pluck('total', 'bulan')
        ->toArray();

        // Inisialisasi data 12 bulan dengan 0
        $chartData = array_fill(1, 12, 0);
        foreach ($laporanPerBulan as $bulan => $total) {
            $chartData[(int)$bulan] = $total;
        }

        // Data aktivitas terbaru (gabungan dari berbagai sumber)
        $activities = $this->getRecentActivities();

        // Hitung persentase untuk donut chart
        $verifiedPercent = $totalKTH > 0 ? round(($kthVerified / $totalKTH) * 100) : 0;
        $pendingPercent = $totalKTH > 0 ? round(($kthPending / $totalKTH) * 100) : 0;
        $rejectedPercent = $totalKTH > 0 ? round(($kthRejected / $totalKTH) * 100) : 0;

        return view('admin.index', compact(
            'totalKTH',
            'kthVerified',
            'kthPending',
            'kthRejected',
            'totalLaporan',
            'laporanPending',
            'laporanVerified',
            'laporanRejected',
            'totalUser',
            'totalAdmin',
            'totalPenyuluh',
            'totalPimpinan',
            'totalLaporan',
            'kthStatusData',
            'chartData',
            'activities',
            'verifiedPercent',
            'pendingPercent',
            'rejectedPercent'
        ));
    }

    private function getRecentActivities()
    {
        $activities = [];

        // Ambil aktivitas dari KTH terbaru
        $kthActivities = Kth::with('penyuluh')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        foreach ($kthActivities as $kth) {
            $statusColor = [
                'verified' => 'bg-gray-300 text-gray-600',
                'pending' => 'bg-yellow-50 text-orange-600',
                'rejected' => 'bg-rose-200 text-red-700',
            ][$kth->status_verifikasi] ?? 'bg-gray-100 text-gray-500';

            $statusLabel = [
                'verified' => 'Verified',
                'pending' => 'Pending',
                'rejected' => 'Rejected',
            ][$kth->status_verifikasi] ?? ucfirst($kth->status_verifikasi);

            $activities[] = [
                'name' => $kth->nama_kth ?? 'KTH',
                'initials' => Str::upper(substr($kth->nama_kth ?? 'K', 0, 2)),
                'id' => str_pad($kth->id, 6, '0', STR_PAD_LEFT),
                'activity' => $kth->status_verifikasi == 'pending' ? 'Menunggu verifikasi data KTH' : 'Data KTH ' . $statusLabel,
                'date' => $kth->created_at ? $kth->created_at->format('d M, H:i') : '-',
                'status' => $statusLabel,
                'statusClass' => $statusColor,
            ];
        }

        // Ambil aktivitas dari laporan terbaru
        $laporanActivities = LaporanKth::with(['kth', 'penyuluh'])
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get();

        foreach ($laporanActivities as $laporan) {
            $statusColor = [
                'verified' => 'bg-gray-300 text-gray-600',
                'pending' => 'bg-yellow-50 text-orange-600',
                'rejected' => 'bg-rose-200 text-red-700',
            ][$laporan->status_verifikasi] ?? 'bg-gray-100 text-gray-500';

            $statusLabel = [
                'verified' => 'Verified',
                'pending' => 'Pending',
                'rejected' => 'Rejected',
            ][$laporan->status_verifikasi] ?? ucfirst($laporan->status_verifikasi);

            $activities[] = [
                'name' => $laporan->kth->nama_kth ?? 'KTH',
                'initials' => Str::upper(substr($laporan->kth->nama_kth ?? 'L', 0, 2)),
                'id' => str_pad($laporan->id, 6, '0', STR_PAD_LEFT),
                'activity' => $laporan->jenis_usaha ? 'Laporan ' . $laporan->jenis_usaha : 'Mengirim laporan KTH',
                'date' => $laporan->created_at ? $laporan->created_at->format('d M, H:i') : '-',
                'status' => $statusLabel,
                'statusClass' => $statusColor,
            ];
        }

        // Urutkan berdasarkan tanggal (descending)
        usort($activities, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        // Ambil 5 teratas
        return array_slice($activities, 0, 5);
    }
}