<div class="space-y-1">

    <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-700 font-semibold border-r-4 border-emerald-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors duration-200">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="text-sm font-inter font-medium">Dashboard</span>
    </a>

    <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('#') ? 'bg-emerald-50 text-emerald-700 font-semibold border-r-4 border-emerald-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors duration-200">
        <span class="material-symbols-outlined">fact_check</span>
        <span class="text-sm font-inter font-medium">Verifikasi KTH</span>
    </a>

    <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('#') ? 'bg-emerald-50 text-emerald-700 font-semibold border-r-4 border-emerald-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors duration-200">
        <span class="material-symbols-outlined">assignment_turned_in</span>
        <span class="text-sm font-inter font-medium">Verifikasi Laporan</span>
    </a>

    <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('#') ? 'bg-emerald-50 text-emerald-700 font-semibold border-r-4 border-emerald-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors duration-200">
        <span class="material-symbols-outlined">list_alt</span>
        <span class="text-sm font-inter font-medium">Daftar KTH</span>
    </a>

    <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('#') ? 'bg-emerald-50 text-emerald-700 font-semibold border-r-4 border-emerald-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors duration-200">
        <span class="material-symbols-outlined">description</span>
        <span class="text-sm font-inter font-medium">Daftar Laporan</span>
    </a>

    <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('#') ? 'bg-emerald-50 text-emerald-700 font-semibold border-r-4 border-emerald-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors duration-200">
        <span class="material-symbols-outlined">group</span>
        <span class="text-sm font-inter font-medium">Manajemen User</span>
    </a>


</div>
