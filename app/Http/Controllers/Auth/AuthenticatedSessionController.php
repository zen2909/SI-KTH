<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login-penyuluh');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        $requestedRole = $request->input('role');

        if ($user->role !== $requestedRole) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Anda tidak memiliki akses ke halaman ini.',
            ]);
        }

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

    public function destroy(Request $request): RedirectResponse
    {
        $role = Auth::user()->role;

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

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