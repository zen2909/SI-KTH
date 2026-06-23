<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanKth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class LaporanVerifikasiController extends Controller
{
    public function index(Request $request)
    {
        // 🔥 TAMPILKAN SEMUA LAPORAN PENDING (TANPA FILTER KTH VERIFIED)
        $query = LaporanKth::with(['kth', 'penyuluh'])
            ->where('status_verifikasi', 'pending');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('kth', function ($q2) use ($search) {
                    $q2->where('nama_kth', 'like', "%{$search}%");
                })->orWhere('jenis_usaha', 'like', "%{$search}%");
            });
        }

        // Filter periode
        if ($request->filled('periode')) {
            $query->where('periode_laporan', $request->periode);
        }

        $laporans = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistik
        $totalPending = LaporanKth::where('status_verifikasi', 'pending')->count();
        $totalVerified = LaporanKth::where('status_verifikasi', 'verified')->count();
        $totalRejected = LaporanKth::where('status_verifikasi', 'rejected')->count();

        return view('admin.verifikasilaporan', compact('laporans', 'totalPending', 'totalVerified', 'totalRejected'));
    }

    public function approve($id)
    {
        try {
            $laporan = LaporanKth::with('kth')->findOrFail($id);

            if ($laporan->status_verifikasi !== 'pending') {
                return redirect()->back()->with('error', 'Laporan ini sudah diverifikasi atau ditolak.');
            }

            if ($laporan->kth->status_verifikasi !== 'verified') {
                $kthStatus = $laporan->kth->status_verifikasi;
                $statusLabel = $kthStatus === 'rejected' ? 'Ditolak' : 'Pending';
                return redirect()->back()->with('error', "Tidak dapat memverifikasi laporan karena KTH induk berstatus {$statusLabel}. Harap verifikasi KTH terlebih dahulu.");
            }

            $laporan->status_verifikasi = 'verified';
            $laporan->catatan_revisi = null;
            $laporan->save();

            return redirect()->back()->with('success', 'Laporan berhasil diverifikasi.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            $request->validate([
                'catatan_revisi' => 'required|string|min:10',
            ]);

            $laporan = LaporanKth::with('kth')->findOrFail($id);

            if ($laporan->status_verifikasi !== 'pending') {
                return redirect()->back()->with('error', 'Laporan ini sudah diverifikasi atau ditolak.');
            }

            if ($laporan->kth->status_verifikasi !== 'verified') {
                $kthStatus = $laporan->kth->status_verifikasi;
                $statusLabel = $kthStatus === 'rejected' ? 'Ditolak' : 'Pending';
                return redirect()->back()->with('error', "Tidak dapat menolak laporan karena KTH induk berstatus {$statusLabel}. Harap verifikasi KTH terlebih dahulu.");
            }

            $laporan->status_verifikasi = 'rejected';
            $laporan->catatan_revisi = $request->catatan_revisi;
            $laporan->save();

            return redirect()->back()->with('success', 'Data laporan berhasil ditolak.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getDetail($id): JsonResponse
{
    try {
        $laporan = Laporan::with(['kth', 'penyuluh', 'dokumentasi'])->findOrFail($id);
        
        return response()->json([
            'id' => $laporan->id,
            'nama_kth' => $laporan->kth->nama_kth ?? '-',
            'nama_penyuluh' => $laporan->penyuluh->nama_lengkap ?? '-',
            'periode' => $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('F Y') : '-',
            'status' => $laporan->status_verifikasi ?? 'pending',
            'jenis_usaha' => $laporan->jenis_usaha ?? '-',
            'nib' => $laporan->nib ?? '-',
            'pirt' => $laporan->pirt ?? '-',
            'merek_dagang' => $laporan->merek_dagang ?? '-',
            'potensi_produksi' => $laporan->potensi_produksi ?? '0',
            'satuan_produksi' => $laporan->satuan_produksi ?? 'Kg',
            'nte_per_bulan' => $laporan->nte_per_bulan ?? 0,
            'jangkauan_pemasaran' => $laporan->jangkauan_pemasaran ?? '-',
            'kendala_usaha' => $laporan->kendala_usaha ?? '-',
            'kebutuhan_pengembangan' => $laporan->kebutuhan_pengembangan ?? '-',
            'keterangan_tambahan' => $laporan->keterangan_tambahan ?? '-',
            'sertifikat_halal_file' => $laporan->sertifikat_halal_file,
            'dokumentasi' => $laporan->dokumentasi->map(function($doc) {
                return [
                    'id' => $doc->id,
                    'file_path' => $doc->file_path,
                    'file_name' => $doc->file_name ?? basename($doc->file_path),
                ];
            }),
            'catatan_revisi' => $laporan->catatan_revisi,
            'updated_at' => $laporan->updated_at ? $laporan->updated_at->format('d M Y') : '-',
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Data laporan tidak ditemukan',
            'message' => $e->getMessage()
        ], 404);
    }
}

    public function show($id)
    {
        $laporan = LaporanKth::with(['kth', 'penyuluh', 'dokumentasi'])->findOrFail($id);
        return response()->json($laporan);
    }

    public function editData($id)
    {
        $laporan = LaporanKth::with(['kth', 'penyuluh', 'dokumentasi'])->findOrFail($id);

        $dokumentasi = $laporan->dokumentasi()->get(['id', 'file_path']);

        return response()->json([
            'id' => $laporan->id,
            'id_kth' => $laporan->id_kth,
            'nama_kth' => $laporan->kth ? $laporan->kth->nama_kth : 'Data KTH',
            'periode_laporan' => $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('Y-m-d') : '',
            'jenis_usaha' => $laporan->jenis_usaha,
            'nib' => $laporan->nib,
            'pirt' => $laporan->pirt,
            'sertifikat_halal_file' => $laporan->sertifikat_halal_file,
            'merek_dagang' => $laporan->merek_dagang,
            'potensi_produksi' => $laporan->potensi_produksi,
            'nte_per_bulan' => $laporan->nte_per_bulan,
            'jangkauan_pemasaran' => $laporan->jangkauan_pemasaran,
            'kendala_usaha' => $laporan->kendala_usaha,
            'kebutuhan_pengembangan' => $laporan->kebutuhan_pengembangan,
            'keterangan_tambahan' => $laporan->keterangan_tambahan,
            'status_verifikasi' => $laporan->status_verifikasi,
            'catatan_revisi' => $laporan->catatan_revisi,
            'dokumentasi' => $dokumentasi->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'file_path' => $doc->file_path,
                    'file_name' => basename($doc->file_path),
                ];
            }),
        ]);
    }
}