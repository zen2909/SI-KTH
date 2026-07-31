<?php

namespace App\Http\Controllers\Pimpinan;

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
                $q->whereHas('kth', function ($q) use ($search) {
                    $q->where('nama_kth', 'like', "%{$search}%");
                })->orWhere('jenis_usaha', 'like', "%{$search}%");
            });
        }

        // Filter periode
        if ($request->filled('periode')) {
            $query->where('periode_laporan', 'like', "%{$request->periode}%");
        }

        $laporans = $query->orderBy('created_at', 'desc')->paginate(10);
$tahunList = LaporanKth::selectRaw('EXTRACT(YEAR FROM periode_laporan) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');
        // Statistik
        $totalLaporan = LaporanKth::count();
        $totalVerified = LaporanKth::where('status_verifikasi', 'verified')->count();
        $totalPending = LaporanKth::where('status_verifikasi', 'pending')->count();
        $totalRejected = LaporanKth::where('status_verifikasi', 'rejected')->count();
        

        return view('pimpinan.laporan', compact(
            'laporans',
            'totalLaporan',
            'totalVerified',
            'totalPending',
            'totalRejected',
             'tahunList'
        ));
    }

    public function show($id)
    {
        $laporan = LaporanKth::with(['kth', 'penyuluh', 'dokumentasi'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $laporan
        ]);
         return response()->json($laporan);
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