@if (request()->routeIs('admin.dashboard'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Dashboard Admin</h2>
@elseif (request()->routeIs('kth.verifikasi'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Verifikasi Data Kelompok Tani Hutan</h2>
@elseif (request()->routeIs('laporan.verifikasi'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Verifikasi Laporan Kelompok Tani Hutan</h2>
@elseif (request()->routeIs('kth.index'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Daftar Kelompok Tani Hutan</h2>
@elseif (request()->routeIs('laporan.index'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Daftar Laporan Kelompok Tani Hutan</h2>
@elseif (request()->routeIs('user.index'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Daftar Pengguna</h2>
@elseif (request()->routeIs('admin.profile.index'))
    <h2 class="text-xl font-poppins font-semibold text-primary">Profil Saya</h2>
@endif
