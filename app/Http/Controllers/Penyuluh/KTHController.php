<?php

namespace App\Http\Controllers\Penyuluh;

use App\Http\Controllers\Controller;
use App\Http\Requests\Penyuluh\StoreKTHRequest;
use App\Http\Requests\Penyuluh\UpdateKTHRequest;
use App\Models\Kth;

class KTHController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kths = Kth::where('id_penyuluh', auth()->user()->penyuluh->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('penyuluh.kth', compact('kths'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKTHRequest $request)
    {
        $validated = $request->validated();

        // Tambahkan id_penyuluh dari user yang login
        $validated['id_penyuluh'] = auth()->user()->penyuluh->id;

        // Set default status verifikasi
        $validated['status_verifikasi'] = 'pending';

        $kth = Kth::create($validated);

        return redirect()
            ->route('penyuluh.kth.index')
            ->with('success', 'Data KTH berhasil ditambahkan dan menunggu verifikasi Admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kth $kth)
    {
        // Cek kepemilikan data
        if ($kth->id_penyuluh !== auth()->user()->penyuluh->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('penyuluh.kth.show', compact('kth'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kth $kth)
    {
        // Cek kepemilikan data
        if ($kth->id_penyuluh !== auth()->user()->penyuluh->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('penyuluh.kth.edit', compact('kth'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKTHRequest $request, Kth $kth)
    {
        // Cek kepemilikan data
        if ($kth->id_penyuluh !== auth()->user()->penyuluh->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validated();

        // Jika data sudah verified, ubah status menjadi pending
        if ($kth->status_verifikasi === 'verified' || $kth->status_verifikasi === 'rejected') {
            $validated['status_verifikasi'] = 'pending';
        }

        $kth->update($validated);

        $message = 'Data KTH berhasil diperbarui.';
        if ($kth->status_verifikasi === 'pending') {
            $message .= ' Data perlu diverifikasi ulang oleh Admin.';
        }

        return redirect()
            ->route('penyuluh.kth.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kth $kth)
    {
        // Cek kepemilikan data
        if ($kth->id_penyuluh !== auth()->user()->penyuluh->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $kth->delete();

        return redirect()
            ->route('penyuluh.kth.index')
            ->with('success', 'Data KTH berhasil dihapus.');
    }
}
