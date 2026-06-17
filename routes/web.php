<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DashboardController as PimpinanDashboard;
use App\Http\Controllers\Penyuluh\DashboardController as PenyuluhDashboard;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware('role:penyuluh')->prefix('penyuluh')->group(function () {
        Route::get('/dashboard', [PenyuluhDashboard::class, 'index'])->name('penyuluh.dashboard');
    });

    Route::middleware('role:pimpinan')->prefix('pimpinan')->group(function () {
        Route::get('/dashboard', [PimpinanDashboard::class, 'index'])->name('pimpinan.dashboard');
    });
});

require __DIR__.'/auth.php';
