<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('pimpinan.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($user->id)],
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [];

        if ($request->filled('name')) {
            $data['name'] = $request->name;
        }

        if ($request->filled('email')) {
            $data['email'] = $request->email;
        }

        // 🔥 Proses upload foto
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            
            $file = $request->file('foto_profil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('users/foto', $filename, 'public');
            $data['foto_profil'] = $path;
        }

        if (!empty($data)) {
            $user->update($data);
        }

        // 🔥 Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->route('pimpinan.profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (empty($request->password)) {
            return redirect()->route('pimpinan.profile.index')
                ->with('info', 'Tidak ada perubahan pada password.');
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini salah.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('pimpinan.profile.index')
            ->with('success', 'Password berhasil diperbarui.');
    }

    public function deletePhoto()
    {
        $user = auth()->user();

        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->foto_profil = null;
        $user->save();

        return redirect()->route('pimpinan.profile.index')
            ->with('success', 'Foto profil berhasil dihapus.');
    }
}