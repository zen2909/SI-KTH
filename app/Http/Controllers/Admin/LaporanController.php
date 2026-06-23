<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanKth;
use App\Models\Kth;
use App\Models\Penyuluh;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LaporanKth::with(['kth', 'penyuluh']);

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('jenis_usaha', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('kth', function ($q) use ($search) {
                      $q->where('nama_kth', 'like', "%{$search}%");
                  });
            });
        }

        // Filter status_verifikasi
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        // Filter periode (tahun) - Perbaikan untuk PostgreSQL
        if ($request->filled('periode')) {
            $query->whereRaw('EXTRACT(YEAR FROM periode_laporan) = ?', [$request->periode]);
        }

        $laporans = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistik
        $totalLaporan = LaporanKth::count();
        $totalVerified = LaporanKth::where('status_verifikasi', 'verified')->count();
        $totalPending = LaporanKth::where('status_verifikasi', 'pending')->count();
        $totalRejected = LaporanKth::where('status_verifikasi', 'rejected')->count();

        // Data untuk filter dropdown (tahun dari periode_laporan) - Perbaikan untuk PostgreSQL
        $tahunList = LaporanKth::selectRaw('DISTINCT EXTRACT(YEAR FROM periode_laporan) as tahun')
            ->whereNotNull('periode_laporan')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->map(function ($item) {
                return (int) $item;
            });

        return view('admin.laporan', compact(
            'laporans',
            'totalLaporan',
            'totalVerified',
            'totalPending',
            'totalRejected',
            'tahunList'
        ));
    }

    public function search(Request $request)
{
    $search = $request->input('search', '');
    
    // Ubah dari strlen < 2 menjadi < 1 (1 huruf saja sudah muncul)
    if (strlen($search) < 1) {
        return response()->json([]);
    }

    $kths = Kth::where('nama_kth', 'ilike', "%{$search}%")
        ->limit(10)
        ->get(['id', 'nama_kth', 'desa', 'kecamatan']);

    return response()->json($kths);
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporan = LaporanKth::with(['kth', 'penyuluh', 'dokumentasi'])->findOrFail($id);
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $laporan
            ]);
        }
        
        return response()->json($laporan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporan = LaporanKth::findOrFail($id);
        
        // Hapus file sertifikat jika ada
        if ($laporan->sertifikat_halal_file && Storage::disk('public')->exists($laporan->sertifikat_halal_file)) {
            Storage::disk('public')->delete($laporan->sertifikat_halal_file);
        }
        
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }

   public function export(Request $request)
{
    $query = LaporanKth::with(['kth', 'penyuluh']);

    // Filter pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->whereHas('kth', function ($q) use ($search) {
                $q->where('nama_kth', 'like', "%{$search}%");
            })->orWhere('jenis_usaha', 'like', "%{$search}%");
        });
    }

    // Filter periode (tahun)
    if ($request->filled('periode')) {
        $query->whereYear('periode_laporan', $request->periode);
    }

    // Filter status verifikasi
    if ($request->filled('status_verifikasi')) {
        $statuses = $request->status_verifikasi;
        
        if (is_array($statuses) && count($statuses) == 1) {
            $query->where('status_verifikasi', $statuses[0]);
        } else if (is_array($statuses) && count($statuses) > 1) {
            $query->whereIn('status_verifikasi', $statuses);
        } else if (is_string($statuses)) {
            $query->where('status_verifikasi', $statuses);
        }
    }

    $data = $query->orderBy('created_at', 'desc')->get();
    $totalData = $data->count();

    if ($totalData == 0) {
        return redirect()->back()->with('info', 'Tidak ada data yang sesuai dengan filter yang dipilih.');
    }

    if ($request->format == 'excel') {
        return Excel::download(new LaporanExport($data), 'data_laporan_' . date('Y-m-d') . '.xlsx');
    } else {
        // 🔥 Gunakan view PDF yang sudah dibuat
        $pdf = Pdf::loadView('exports.laporan_pdf', ['data' => $data]);
        return $pdf->download('data_laporan_' . date('Y-m-d') . '.pdf');
    }
}

    /**
     * Get count of filtered laporan for export
     */
   public function exportCount(Request $request)
{
    try {
        // Log request untuk debugging
        \Log::info('Export Count Request:', $request->all());

        $query = LaporanKth::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('kth', function ($q) use ($search) {
                    $q->where('nama_kth', 'like', "%{$search}%");
                })->orWhere('jenis_usaha', 'like', "%{$search}%");
            });
        }

        // Filter periode (tahun)
        if ($request->filled('periode')) {
            $query->whereYear('periode_laporan', $request->periode);
        }

        // Filter status verifikasi
        if ($request->filled('status_verifikasi')) {
            $statuses = $request->status_verifikasi;
            
            if (is_array($statuses)) {
                if (count($statuses) == 1) {
                    $query->where('status_verifikasi', $statuses[0]);
                } else {
                    $query->whereIn('status_verifikasi', $statuses);
                }
            } else {
                $query->where('status_verifikasi', $statuses);
            }
        }

        $total = $query->count();

        return response()->json([
            'success' => true,
            'total' => $total,
            'message' => $total > 0 ? 'data ditemukan' : 'Tidak ada data yang sesuai'
        ]);

    } catch (\Exception $e) {
        \Log::error('Export count error: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        
        return response()->json([
            'success' => false,
            'total' => 0,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}
}