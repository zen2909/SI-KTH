<div class="space-y-1">
    <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('#') ? 'bg-emerald-50 text-emerald-700 font-semibold border-r-4 border-emerald-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors duration-200">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="text-sm font-inter font-medium">Dashboard</span>
    </a>

    <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('#') ? 'bg-emerald-50 text-emerald-700 font-semibold border-r-4 border-emerald-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors duration-200">
        <span class="material-symbols-outlined">monitoring</span>
        <span class="text-sm font-inter font-medium">Monitoring KTH</span>
    </a>

    <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('#') ? 'bg-emerald-50 text-emerald-700 font-semibold border-r-4 border-emerald-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors duration-200">
        <span class="material-symbols-outlined">assessment</span>
        <span class="text-sm font-inter font-medium">Monitoring Laporan</span>
    </a>

    <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('#') ? 'bg-emerald-50 text-emerald-700 font-semibold border-r-4 border-emerald-700' : 'text-gray-600 hover:bg-gray-50' }} transition-colors duration-200">
        <span class="material-symbols-outlined">file_download</span>
        <span class="text-sm font-inter font-medium">Ekspor Data</span>
    </a>
</div>
