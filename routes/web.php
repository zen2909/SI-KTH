<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DashboardController as PimpinanDashboard;
use App\Http\Controllers\Penyuluh\DashboardController as PenyuluhDashboard;
use App\Http\Controllers\Penyuluh\KTHController as KTHPenyuluh;
use App\Http\Controllers\Penyuluh\LaporanController as LaporanPenyuluh;
use App\Http\Controllers\Penyuluh\ProfileController as ProfilePenyuluh;
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
        Route::resource('kth', KTHPenyuluh::class)->except(['show'])->names('penyuluh.kth');
        Route::get('/kth/{kth}', [KTHPenyuluh::class, 'show'])->name('penyuluh.kth.show');
        Route::resource('laporan', LaporanPenyuluh::class)->names('penyuluh.laporan');
        Route::get('/laporan/{laporan}/edit-data', [LaporanPenyuluh::class, 'editData'])->name('penyuluh.laporan.edit-data');
        Route::get('/laporan/{laporan}', [LaporanPenyuluh::class, 'show'])->name('penyuluh.laporan.show');
        Route::get('/profil', [ProfilePenyuluh::class, 'index'])->name('penyuluh.profil');
        Route::put('/profile', [ProfilePenyuluh::class, 'update'])->name('penyuluh.profile.update');
        Route::put('/profile/foto', [ProfilePenyuluh::class, 'updateFoto'])->name('penyuluh.profile.update-foto');
        Route::delete('/profile/foto', [ProfilePenyuluh::class, 'deleteFoto'])->name('penyuluh.profile.delete-foto');
    });

    Route::middleware('role:pimpinan')->prefix('pimpinan')->group(function () {
        Route::get('/dashboard', [PimpinanDashboard::class, 'index'])->name('pimpinan.dashboard');
    });
});

require __DIR__.'/auth.php';
