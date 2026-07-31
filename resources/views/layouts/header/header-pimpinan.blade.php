@if (request()->routeIs('pimpinan.dashboard'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Dashboard Pimpinan</h2>
@elseif (request()->routeIs('pimpinan.kth.index'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Data Kelompok Tani Hutan</h2>
@elseif (request()->routeIs('pimpinan.laporan.index'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Data Laporan Kelompok Tani Hutan</h2>
@elseif (request()->routeIs('pimpinan.profile.index'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Profil Saya</h2>
@endif
