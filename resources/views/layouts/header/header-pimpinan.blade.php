@if (request()->routeIs('pimpinan.dashboard'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Dashboard Pimpinan</h2>
@elseif (request()->routeIs('penyuluh.kth'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Data KTH</h2>
@elseif (request()->routeIs('penyuluh.laporan.index'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Data Laporan</h2>
@elseif (request()->routeIs('penyuluh.profil'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Profil Saya</h2>
@endif
