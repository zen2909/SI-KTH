<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login-penyuluh');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Cek role dari user yang login
        $requestedRole = $request->input('role'); // Ambil role dari form

        // Jika role tidak sesuai, logout dan beri error
        if ($user->role !== $requestedRole) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Anda tidak memiliki akses ke halaman ini.',
            ]);
        }

        // Redirect berdasarkan role
        switch ($user->role) {
            case 'admin':
                return redirect()->intended(route('admin.dashboard'));
            case 'pimpinan':
                return redirect()->intended(route('pimpinan.dashboard'));
            case 'penyuluh':
                return redirect()->intended(route('penyuluh.dashboard'));
            default:
                return redirect('/');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Simpan role sebelum logout
        $role = Auth::user()->role;

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect berdasarkan role yang logout
        switch ($role) {
            case 'admin':
                return redirect()->route('login.admin');
            case 'pimpinan':
                return redirect()->route('login.pimpinan');
            case 'penyuluh':
                return redirect()->route('login.penyuluh');
            default:
                return redirect('/');
        }
    }
}