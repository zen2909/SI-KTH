@if (request()->routeIs('penyuluh.dashboard'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Dashboard Penyuluh</h2>
@elseif (request()->routeIs('penyuluh.kth.index'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Data Kelompok Tani Hutan</h2>
@elseif (request()->routeIs('penyuluh.laporan.index'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Data Laporan Kelompok Tani Hutan</h2>
@elseif (request()->routeIs('penyuluh.profil'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Profil Saya</h2>
@endif
