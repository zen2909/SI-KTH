<div class="space-y-1">

    <a href="{{ route('admin.dashboard') }}"
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('admin.dashboard') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[material-symbols--dashboard-outline] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-sm font-inter font-medium">Dashboard</span>
    </a>

    <a href="{{ route('kth.verifikasi') }}"
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('kth.verifikasi') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[icon-park-outline--success] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-sm font-inter font-medium">Verifikasi KTH</span>
    </a>

    <a href="{{ route('laporan.verifikasi') }}"
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('laporan.verifikasi') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[icon-park-outline--doc-success] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-sm font-inter font-medium">Verifikasi Laporan</span>
    </a>

    <a href="{{ route('kth.index') }}"
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('kth.index') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[material-symbols--potted-plant-outline-sharp] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-sm font-inter font-medium">Daftar KTH</span>
    </a>

    <a href="{{ route('laporan.index') }}"
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('laporan.index') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[lucide--notepad-text] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-sm font-inter font-medium">Daftar Laporan</span>
    </a>

    <a href="{{ route('user.index') }}"
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('user.index') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[ix--user-management-settings] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-sm font-inter font-medium">Manajemen User</span>
    </a>

    <span class="text-[10px] font-inter font-medium text-gray-500 ml-3 py-3">SYSTEM</span>

    <a href="{{ route('admin.profile.index') }}"
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('admin.profile.index') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[iconamoon--profile] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-[14px] font-inter font-medium">Profil Saya</span>
    </a>


</div>
