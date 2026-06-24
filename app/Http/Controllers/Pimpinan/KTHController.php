<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Kth;
use App\Models\Penyuluh;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\KTHExport;

class KTHController extends Controller
{
    public function index(Request $request)
    {
        $query = Kth::with('penyuluh');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kth', 'like', "%{$search}%")
                  ->orWhere('desa', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%");
            });
        }

        // Filter status verifikasi
        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }

        // Filter status KTH
        if ($request->filled('status_kth')) {
            $query->where('status_kth', $request->status_kth);
        }

        // Filter kelas KTH
        if ($request->filled('kelas_kth')) {
            $query->where('kelas_kth', $request->kelas_kth);
        }

        // Filter kecamatan
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', 'like', "%{$request->kecamatan}%");
        }

        $kths = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistik
        $totalKTH = Kth::count();
        $totalVerified = Kth::where('status_verifikasi', 'verified')->count();
        $totalPending = Kth::where('status_verifikasi', 'pending')->count();
        $totalRejected = Kth::where('status_verifikasi', 'rejected')->count();

        // Data untuk filter dropdown
        $kecamatanList = Kth::select('kecamatan')->distinct()->pluck('kecamatan');

        return view('pimpinan.kth', compact(
            'kths',
            'totalKTH',
            'totalVerified',
            'totalPending',
            'totalRejected',
            'kecamatanList'
        ));
    }

    public function show($id)
    {
        $kth = Kth::with(['penyuluh', 'laporanKth'])->findOrFail($id);
        return response()->json($kth);
    }

    public function search(Request $request)
    {
        $search = $request->input('search', '');
        
        if (strlen($search) < 1) {
            return response()->json([]);
        }

        $kths = Kth::where('nama_kth', 'like', "%{$search}%")
            ->limit(10)
            ->get(['id', 'nama_kth', 'desa', 'kecamatan']);

        return response()->json($kths);
    }

    public function exportCount(Request $request)
    {
        $query = Kth::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kth', 'like', "%{$search}%")
                  ->orWhere('desa', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%");
            });
        }

        // Filter kecamatan
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
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

        $total = $query->count();

        return response()->json([
            'total' => $total,
            'message' => $total > 0 ? 'data ditemukan' : 'Tidak ada data yang sesuai'
        ]);
    }

    public function export(Request $request)
    {
        $query = Kth::with('penyuluh');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kth', 'like', "%{$search}%")
                  ->orWhere('desa', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%");
            });
        }

        // Filter kecamatan
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
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
            return Excel::download(new KTHExport($data), 'data_kth_' . date('Y-m-d') . '.xlsx');
        } else {
            $pdf = Pdf::loadView('exports.kth_pdf', ['data' => $data]);
            return $pdf->download('data_kth_' . date('Y-m-d') . '.pdf');
        }
    }
}