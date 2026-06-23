<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kth;
use Illuminate\Http\Request;

class KTHVerifikasiController extends Controller
{
    public function index(Request $request)
    {
        // 🔥 HANYA TAMPILKAN KTH DENGAN STATUS PENDING
        $query = Kth::with('penyuluh')->where('status_verifikasi', 'pending');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kth', 'like', "%{$search}%")
                  ->orWhere('desa', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%");
            });
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

        // Data untuk filter dropdown
        $kecamatanList = Kth::select('kecamatan')->distinct()->pluck('kecamatan');

        return view('admin.verifikasikth', compact(
            'kths',
            'kecamatanList'
        ));

    }

    public function approve($id)
    {
        $kth = Kth::findOrFail($id);

        // 🔥 CEK APAKAH STATUSNYA PENDING
        if ($kth->status_verifikasi !== 'pending') {
            return redirect()->back()->with('error', 'Data KTH ini sudah diverifikasi atau ditolak.');
        }

        $kth->update([
            'status_verifikasi' => 'verified',
            'catatan_revisi' => null,
        ]);

        return redirect()->back()->with('success', 'Data KTH berhasil diverifikasi.');
    }

public function reject(Request $request, $id)
{
    // 🔥 VALIDASI
    $request->validate([
        'catatan_revisi' => 'required|string|min:10',
    ]);

    // 🔥 AMBIL ID DARI HIDDEN INPUT
    $kthId = $request->kth_id ?? $id;
    
    // 🔥 CARI KTH
    $kth = Kth::find($kthId);
    
    if (!$kth) {
        return redirect()->back()->with('error', 'Data KTH tidak ditemukan.');
    }

    if ($kth->status_verifikasi !== 'pending') {
        return redirect()->back()->with('error', 'Data KTH ini sudah diverifikasi atau ditolak.');
    }

    // 🔥 UPDATE DATA
    $kth->status_verifikasi = 'rejected';
    $kth->catatan_revisi = $request->catatan_revisi;
    $kth->save();

    // 🔥 DEBUG - Cek hasil update
    \Log::info('KTH Rejected:', [
        'id' => $kth->id,
        'status' => $kth->status_verifikasi,
        'catatan_revisi' => $kth->catatan_revisi,
    ]);

    return redirect()->back()->with('success', 'Data KTH berhasil ditolak.');
}

    public function show($id)
    {
        $kth = Kth::with('penyuluh')->findOrFail($id);
        return response()->json($kth);
    }
}