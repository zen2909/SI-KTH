<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penyuluh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('penyuluh');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        $totalAdmin = User::where('role', 'admin')->count();
        $totalPenyuluh = User::where('role', 'penyuluh')->count();
        $totalPimpinan = User::where('role', 'pimpinan')->count();
        $totalUsers = User::count();
        $newUsers = User::where('created_at', '>=', now()->subDays(30))->count();

        return view('admin.user', compact(
            'users',
            'totalAdmin',
            'totalPenyuluh',
            'totalPimpinan',
            'totalUsers',
            'newUsers'
        ));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:admin,penyuluh,pimpinan',
        'nip' => 'required_if:role,penyuluh|nullable|string|max:50',
        'nik' => 'required_if:role,penyuluh|nullable|string|max:16|unique:penyuluh,nik',
    ]);

    $data = $request->only(['name', 'email', 'role']);
    $data['password'] = Hash::make($request->password);
    if ($request->filled('password')) {
        $data['plain_password'] = Crypt::encryptString($request->password);
    }


    $user = User::create($data);

    if ($request->role == 'penyuluh') {
        Penyuluh::create([
            'user_id' => $user->id,
            'nama_lengkap' => $request->name,
            'nip' => $request->nip,
            'golongan_pangkat' => '-',
            'nik' => $request->nik,
            'tempat_lahir' => '-',
            'tanggal_lahir' => now(),
            'jenis_kelamin' => 'L',
            'alamat' => '-',
            'no_telepon' => '-',
            'email_pribadi' => $request->email,
            'jabatan' => '-',
            'wilayah_kerja' => '-',
        ]);
    }

    return redirect()->route('user.index')
        ->with('success', 'Pengguna berhasil ditambahkan.');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with('penyuluh')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    try {
        $user = User::with('penyuluh')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 404);
    }
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        'password' => 'nullable|string|min:8|confirmed',
        'role' => 'required|in:admin,penyuluh,pimpinan',
        'nip' => 'required_if:role,penyuluh|nullable|string|max:50',
        'nik' => 'required_if:role,penyuluh|nullable|string|max:16|unique:penyuluh,nik,' . $user->id . ',user_id',
    ]);

    $data = $request->only(['name', 'email', 'role']);

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
        $data['plain_password'] = Crypt::encryptString($request->password);
    }

    $user->update($data);

    // Update data penyuluh jika role penyuluh
    if ($request->role == 'penyuluh') {
        $penyuluh = Penyuluh::where('user_id', $user->id)->first();
        $penyuluhData = [
            'nama_lengkap' => $request->name,
            'nip' => $request->nip,
            'nik' => $request->nik,
        ];
        
        if ($penyuluh) {
            $penyuluh->update($penyuluhData);
        } else {
            $penyuluhData['user_id'] = $user->id;
            $penyuluhData['golongan_pangkat'] = '-';
            $penyuluhData['tempat_lahir'] = '-';
            $penyuluhData['tanggal_lahir'] = now();
            $penyuluhData['jenis_kelamin'] = 'L';
            $penyuluhData['alamat'] = '-';
            $penyuluhData['no_telepon'] = '-';
            $penyuluhData['email_pribadi'] = $request->email;
            $penyuluhData['jabatan'] = '-';
            $penyuluhData['wilayah_kerja'] = '-';
            Penyuluh::create($penyuluhData);
        }
    } else {
        Penyuluh::where('user_id', $user->id)->delete();
    }

    return redirect()->route('user.index')
        ->with('success', 'Pengguna berhasil diupdate.');
}

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            if ($user->role == 'penyuluh') {
                Penyuluh::where('user_id', $user->id)->delete();
            }

            $user->delete();

            return redirect()->route('user.index')
                ->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('user.index')
                ->with('error', 'Gagal menghapus user.');
        }
    }

    public function getDetail($id)
{
    $user = User::with('penyuluh')->findOrFail($id);
    
    // 🔥 Cek dan dekripsi password dengan aman
    $plainPassword = null;
    if ($user->plain_password) {
        try {
            $plainPassword = Crypt::decryptString($user->plain_password);
        } catch (\Exception $e) {
            // Jika gagal dekripsi, gunakan default atau null
            $plainPassword = 'password123';
        }
    } else {
        $plainPassword = 'password123';
    }
    
    return response()->json([
        'success' => true,
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'foto_profil' => $user->foto_profil,
            'plain_password' => $plainPassword,
            'penyuluh' => $user->penyuluh,
        ]
    ]);
}
}