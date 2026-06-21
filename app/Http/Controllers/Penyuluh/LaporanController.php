<?php

namespace App\Http\Controllers\Penyuluh;

use App\Http\Controllers\Controller;
use App\Http\Requests\Penyuluh\StoreLaporanRequest;
use App\Http\Requests\Penyuluh\UpdateLaporanRequest;
use App\Models\Kth;
use App\Models\LaporanKth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $penyuluh = $user->penyuluh;

        // Ambil KTH yang valid untuk dropdown
        $kthOptions = Kth::where('id_penyuluh', $penyuluh->id)
            ->whereIn('status_verifikasi', ['pending', 'verified'])
            ->orderBy('nama_kth')
            ->get(['id', 'nama_kth']);

        $query = LaporanKth::where('id_penyuluh', $penyuluh->id)
            ->with('kth');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('kth', function ($q) use ($search) {
                $q->where('nama_kth', 'like', "%{$search}%");
            })->orWhere('id', 'like', "%{$search}%");
        }

        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }

        if ($request->filled('periode')) {
            $query->where('periode_laporan', $request->periode);
        }

        $laporans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('penyuluh.laporan', compact('laporans', 'kthOptions'));
    }

    public function store(StoreLaporanRequest $request)
{
    $validated = $request->validated();
    $validated['id_penyuluh'] = auth()->user()->penyuluh->id;
    $validated['status_verifikasi'] = 'pending';

    // 🔥 LOG UNTUK DEBUG
    \Log::info('Store - Potensi Produksi:', [
        'potensi_produksi' => $request->potensi_produksi,
        'satuan_produksi' => $request->satuan_produksi,
    ]);

    // Upload sertifikat halal
    if ($request->hasFile('sertifikat_halal_file')) {
        $file = $request->file('sertifikat_halal_file');
        $fileName = 'sertifikat_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('sertifikat', $fileName, 'public');
        $validated['sertifikat_halal_file'] = $path;
    }

    $laporan = LaporanKth::create($validated);

    // 🔥 LOG SETELAH CREATE
    \Log::info('Store - Laporan tersimpan:', [
        'id' => $laporan->id,
        'potensi_produksi' => $laporan->potensi_produksi,
        'satuan_produksi' => $laporan->satuan_produksi,
    ]);

    // Upload dokumentasi
    if ($request->hasFile('dokumentasi')) {
        foreach ($request->file('dokumentasi') as $file) {
            $fileName = 'dokumentasi_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dokumentasi', $fileName, 'public');
            $laporan->dokumentasi()->create([
                'file_path' => $path,
                'uploaded_by' => auth()->id(),
                'keterangan' => 'Dokumentasi kegiatan KTH',
            ]);
        }
    }

    return redirect()
        ->route('penyuluh.laporan.index')
        ->with('success', 'Laporan berhasil ditambahkan dan menunggu verifikasi Admin.');
}

public function update(UpdateLaporanRequest $request, LaporanKth $laporan)
{
    if ($laporan->id_penyuluh !== auth()->user()->penyuluh->id) {
        abort(403, 'Anda tidak memiliki akses ke data ini.');
    }

    $validated = $request->validated();

    // 🔥 LOG UNTUK DEBUG
    \Log::info('Update - Potensi Produksi:', [
        'id' => $laporan->id,
        'potensi_produksi' => $request->potensi_produksi,
        'satuan_produksi' => $request->satuan_produksi,
        'old_potensi' => $laporan->potensi_produksi,
        'old_satuan' => $laporan->satuan_produksi,
    ]);

    if ($laporan->status_verifikasi === 'verified' || $laporan->status_verifikasi === 'rejected') {
        $validated['status_verifikasi'] = 'pending';
    }

    // Upload sertifikat halal baru
    if ($request->hasFile('sertifikat_halal_file')) {
        if ($laporan->sertifikat_halal_file && Storage::disk('public')->exists($laporan->sertifikat_halal_file)) {
            Storage::disk('public')->delete($laporan->sertifikat_halal_file);
        }
        $file = $request->file('sertifikat_halal_file');
        $fileName = 'sertifikat_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('sertifikat', $fileName, 'public');
        $validated['sertifikat_halal_file'] = $path;
    }

    $laporan->update($validated);

    // 🔥 LOG SETELAH UPDATE
    \Log::info('Update - Laporan diupdate:', [
        'id' => $laporan->id,
        'potensi_produksi' => $laporan->potensi_produksi,
        'satuan_produksi' => $laporan->satuan_produksi,
    ]);

    // Upload dokumentasi baru
    if ($request->hasFile('dokumentasi')) {
        foreach ($request->file('dokumentasi') as $file) {
            $fileName = 'dokumentasi_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dokumentasi', $fileName, 'public');
            $laporan->dokumentasi()->create([
                'file_path' => $path,
                'uploaded_by' => auth()->id(),
                'keterangan' => 'Dokumentasi kegiatan KTH',
            ]);
        }
    }

    // Hapus dokumentasi yang ditandai
    if ($request->has('deleted_dokumentasi')) {
        foreach ($request->deleted_dokumentasi as $docId) {
            $doc = $laporan->dokumentasi()->find($docId);
            if ($doc) {
                if (Storage::disk('public')->exists($doc->file_path)) {
                    Storage::disk('public')->delete($doc->file_path);
                }
                $doc->delete();
            }
        }
    }

    $message = 'Laporan berhasil diperbarui.';
    if ($laporan->status_verifikasi === 'pending') {
        $message .= ' Data perlu diverifikasi ulang oleh Admin.';
    }

    return redirect()
        ->route('penyuluh.laporan.index')
        ->with('success', $message);
}

public function editData($id)
{
    try {
        $laporan = LaporanKth::with(['kth', 'dokumentasi', 'penyuluh'])->find($id);
        
        if (!$laporan) {
            return response()->json(['error' => 'Laporan tidak ditemukan'], 404);
        }
        
        if ($laporan->id_penyuluh !== auth()->user()->penyuluh->id) {
            return response()->json(['error' => 'Anda tidak memiliki akses ke data ini.'], 403);
        }

        $dokumentasi = $laporan->dokumentasi()->get(['id', 'file_path']);

        // 🔥 FORMAT PERIODE LAPORAN KE Y-m-d
        $periodeLaporan = null;
        if ($laporan->periode_laporan) {
            $periodeLaporan = \Carbon\Carbon::parse($laporan->periode_laporan)->format('Y-m-d');
        }

        return response()->json([
            'id' => $laporan->id,
            'id_kth' => $laporan->id_kth,
            'nama_kth' => $laporan->kth ? $laporan->kth->nama_kth : 'Data KTH',
            'periode_laporan' => $periodeLaporan, // 🔥 Format Y-m-d
            'jenis_usaha' => $laporan->jenis_usaha,
            'nib' => $laporan->nib,
            'pirt' => $laporan->pirt,
            'sertifikat_halal_file' => $laporan->sertifikat_halal_file,
            'merek_dagang' => $laporan->merek_dagang,
            'potensi_produksi' => $laporan->potensi_produksi ?? 0,
            'satuan_produksi' => $laporan->satuan_produksi ?? 'Kg',
            'nte_per_bulan' => $laporan->nte_per_bulan ?? 0,
            'jangkauan_pemasaran' => $laporan->jangkauan_pemasaran,
            'kendala_usaha' => $laporan->kendala_usaha,
            'kebutuhan_pengembangan' => $laporan->kebutuhan_pengembangan,
            'keterangan_tambahan' => $laporan->keterangan_tambahan,
            'status_verifikasi' => $laporan->status_verifikasi,
            'catatan_revisi' => $laporan->catatan_revisi,
            'dokumentasi' => $dokumentasi->map(function($doc) {
                return [
                    'id' => $doc->id,
                    'file_path' => $doc->file_path,
                    'file_name' => basename($doc->file_path),
                    'size' => Storage::disk('public')->exists($doc->file_path) ? Storage::disk('public')->size($doc->file_path) : 0,
                ];
            }),
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error di editData: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    public function destroy(LaporanKth $laporan)
    {
        if ($laporan->id_penyuluh !== auth()->user()->penyuluh->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        // Hapus file sertifikat
        if ($laporan->sertifikat_halal_file && Storage::disk('public')->exists($laporan->sertifikat_halal_file)) {
            Storage::disk('public')->delete($laporan->sertifikat_halal_file);
        }

        // Hapus file dokumentasi
        foreach ($laporan->dokumentasi as $dok) {
            if (Storage::disk('public')->exists($dok->file_path)) {
                Storage::disk('public')->delete($dok->file_path);
            }
        }

        $laporan->delete();

        return redirect()
            ->route('penyuluh.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function show(LaporanKth $laporan)
    {
        if ($laporan->id_penyuluh !== auth()->user()->penyuluh->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('penyuluh.laporan.show', compact('laporan'));
    }

    /** 
     * Get data laporan untuk edit via AJAX
     */
    
}
