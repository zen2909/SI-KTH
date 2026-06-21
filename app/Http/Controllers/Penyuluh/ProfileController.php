<?php

namespace App\Http\Controllers\Penyuluh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $penyuluh = $user->penyuluh;

        return view('penyuluh.profile', compact('user', 'penyuluh'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $penyuluh = $user->penyuluh;

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'golongan_pangkat' => 'nullable|string|max:50',
            'nik' => 'required|string|max:16|unique:penyuluh,nik,'.$penyuluh->id,
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'email_pribadi' => 'nullable|email|max:255',
            'jabatan' => 'nullable|string|max:255',
            'wilayah_kerja' => 'nullable|string',
        ]);

        $penyuluh->update($validated);
        $user->update(['name' => $validated['nama_lengkap']]);

        return redirect()->route('penyuluh.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateFoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Hapus foto lama jika ada
        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $file = $request->file('foto_profil');
        $fileName = 'foto_'.$user->id.'_'.time().'.'.$file->getClientOriginalExtension();

        try {
            // Buat instance ImageManager dengan driver GD
            $manager = new ImageManager(new Driver);

            // Proses gambar
            $image = $manager->read($file->getRealPath())
                ->cover(400, 400)
                ->toJpeg(80);

            // Debug: cek apakah image berhasil diproses
            // dd('Image berhasil diproses!', $image);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses gambar: '.$e->getMessage());
        }

        // Simpan ke storage
        $path = 'foto_profil/'.$fileName;
        Storage::disk('public')->put($path, (string) $image);

        // Update database
        $user->update(['foto_profil' => $path]);

        return redirect()->route('penyuluh.profil')->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function deleteFoto()
    {
        $user = Auth::user();

        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
            $user->update(['foto_profil' => null]);

            return redirect()->route('penyuluh.profil')->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->route('penyuluh.profil')->with('error', 'Foto tidak ditemukan.');
    }
}
