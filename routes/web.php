<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\KTHVerifikasiController;
use App\Http\Controllers\Admin\LaporanVerifikasiController;
use App\Http\Controllers\Admin\KTHController as KTHAdminController;
use App\Http\Controllers\Admin\LaporanController as LaporanAdminController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ProfileController as ProfileAdminController;
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboard;
use App\Http\Controllers\Pimpinan\KTHController as KTHPimpinanController;
use App\Http\Controllers\Pimpinan\ProfileController as ProfilePimpinanController;
use App\Http\Controllers\Pimpinan\LaporanController as LaporanPimpinanController;
use App\Http\Controllers\Penyuluh\DashboardController as PenyuluhDashboard;
use App\Http\Controllers\Penyuluh\KTHController as KTHPenyuluhController;
use App\Http\Controllers\Penyuluh\LaporanController as LaporanPenyuluh;
use App\Http\Controllers\Penyuluh\ProfileController as ProfilePenyuluh;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return redirect('/penyuluh');
})->name('login');

Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        if ($role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role == 'penyuluh') {
            return redirect()->route('penyuluh.dashboard');
        } elseif ($role == 'pimpinan') {
            return redirect()->route('pimpinan.dashboard');
        }
    }
    // Belum login -> langsung ke login penyuluh
    return redirect()->route('login.penyuluh');
})->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
         Route::get('/kth/verifikasi', [KTHVerifikasiController::class, 'index'])->name('kth.verifikasi');
    Route::post('/kth/verifikasi/{id}/approve', [KTHVerifikasiController::class, 'approve'])->name('kth.verifikasi.approve');
    Route::post('/kth/verifikasi/{id}/reject', [KTHVerifikasiController::class, 'reject'])->name('kth.verifikasi.reject');
    Route::get('/kth/verifikasi/{id}', [KTHVerifikasiController::class, 'show'])->name('kth.verifikasi.show');
    Route::get('/kth/verifikasi/{id}/edit-data', [KTHVerifikasiController::class, 'editData'])->name('kth.verifikasi.edit-data');
    Route::get('/laporan/verifikasi', [LaporanVerifikasiController::class, 'index'])->name('laporan.verifikasi');
    Route::post('/laporan/verifikasi/{id}/approve', [LaporanVerifikasiController::class, 'approve'])->name('laporan.verifikasi.approve');
    Route::post('/laporan/verifikasi/{id}/reject', [LaporanVerifikasiController::class, 'reject'])->name('laporan.verifikasi.reject');
    Route::get('/laporan/verifikasi/{id}', [LaporanVerifikasiController::class, 'show'])->name('laporan.verifikasi.show');
    Route::get('/laporan/verifikasi/{id}/edit-data', [LaporanVerifikasiController::class, 'editData'])->name('laporan.verifikasi.edit-data'); 
    Route::get('/laporan/{id}/detail', [VerifikasiLaporanController::class, 'getDetail'])->name('admin.laporan.detail'); 
    Route::get('/kth', [KTHAdminController::class, 'index'])->name('kth.index');
    Route::get('/kth/search', [KTHAdminController::class, 'search'])->name('kth.search');
    Route::get('/kth/export-count', [KTHAdminController::class, 'exportCount'])->name('kth.export-count');
    Route::get('/kth/{id}', [KTHAdminController::class, 'show'])->name('kth.show');
    Route::delete('/kth/{id}', [KTHAdminController::class, 'destroy'])->name('kth.destroy');
    Route::post('/kth/export', [KTHAdminController::class, 'export'])->name('kth.export');
    Route::get('/laporan', [LaporanAdminController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/search', [LaporanAdminController::class, 'search'])->name('laporan.search');
    Route::post('/laporan/export', [LaporanAdminController::class, 'export'])->name('laporan.export');
    Route::get('/laporan/export-count', [LaporanAdminController::class, 'exportCount'])->name('laporan.export-count');  
    Route::get('/laporan/{id}', [LaporanAdminController::class, 'show'])->name('laporan.show');
    Route::delete('/laporan/{id}', [LaporanAdminController::class, 'destroy'])->name('laporan.destroy'); 
    Route::get('/user', [UserManagementController::class, 'index'])->name('user.index');
    Route::post('/user', [UserManagementController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserManagementController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserManagementController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserManagementController::class, 'destroy'])->name('user.destroy');    
    Route::get('/profile', [ProfileAdminController::class, 'index'])->name('admin.profile.index');
    Route::put('/profile', [ProfileAdminController::class, 'update'])->name('admin.profile.update');
    Route::put('/profile/password', [ProfileAdminController::class, 'updatePassword'])->name('admin.profile.password');
    Route::delete('/profile/photo', [ProfileAdminController::class, 'deletePhoto'])->name('admin.profile.photo.delete'); 
    });

    Route::middleware('role:penyuluh')->prefix('penyuluh')->group(function () {
        Route::get('/dashboard', [PenyuluhDashboard::class, 'index'])->name('penyuluh.dashboard');
        Route::resource('kth', KTHPenyuluhController::class)->except(['show'])->names('penyuluh.kth');
        Route::get('/kth/{kth}', [KTHPenyuluhController::class, 'show'])->name('penyuluh.kth.show');
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
        Route::get('/kth/map-data', [PimpinanDashboard::class, 'mapData'])->name('kth.map-data');
        Route::get('/chart-data', [PimpinanDashboard::class, 'getChartData'])->name('pimpinan.chart-data');
         Route::get('/kth', [KTHPimpinanController::class, 'index'])->name('pimpinan.kth.index');
         Route::get('/kth/search', [KTHPimpinanController::class, 'search'])->name('pimpinan.kth.search');
    Route::get('/kth/export-count', [KTHPimpinanController::class, 'exportCount'])->name('pimpinan.kth.export-count');
    Route::post('/kth/export', [KTHPimpinanController::class, 'export'])->name('pimpinan.kth.export');
    Route::get('/kth/{id}', [KTHPimpinanController::class, 'show'])->name('pimpinan.kth.show');
    Route::get('/profile', [ProfilePimpinanController::class, 'index'])->name('pimpinan.profile.index');
    Route::put('/profile', [ProfilePimpinanController::class, 'update'])->name('pimpinan.profile.update');
    Route::put('/profile/password', [ProfilePimpinanController::class, 'updatePassword'])->name('pimpinan.profile.password');
    Route::delete('/profile/photo', [ProfilePimpinanController::class, 'deletePhoto'])->name('pmipinan.profile.photo.delete'); 
    Route::get('/laporan', [LaporanPimpinanController::class, 'index'])->name('pimpinan.laporan.index');
    Route::get('/laporan/search', [LaporanPimpinanController::class, 'search'])->name('pimpinan.laporan.search');
    Route::post('/laporan/export', [LaporanPimpinanController::class, 'export'])->name('pimpinan.laporan.export');
    Route::get('/laporan/export-count', [LaporanPimpinanController::class, 'exportCount'])->name('pimpinan.laporan.export-count');  
    Route::get('/laporan/{id}', [LaporanPimpinanController::class, 'show'])->name('pimpinan.laporan.show');
    });
});

require __DIR__.'/auth.php';
