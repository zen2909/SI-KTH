<div class="space-y-1">

    <a href={{ route('penyuluh.dashboard') }}
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('penyuluh.dashboard') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[material-symbols--dashboard-outline] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-[14px] font-inter font-medium">Dashboard</span>
    </a>

    <a href={{ route('penyuluh.kth.index') }}
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('penyuluh.kth.index') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[material-symbols--potted-plant-outline-sharp] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-[14px] font-inter font-medium">Data KTH</span>
    </a>

    <a href={{ route('penyuluh.laporan.index') }}
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('penyuluh.laporan.index') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[lucide--notepad-text] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-[14px] font-inter font-medium">Laporan</span>
    </a>

    <span class="text-[10px] font-inter font-medium text-gray-500 ml-3 py-3">SYSTEM</span>

    <a href={{ route('penyuluh.profil') }}
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('penyuluh.profil') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[iconamoon--profile]  w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-[14px] font-inter font-medium">Profil Saya</span>
    </a>

</div>
