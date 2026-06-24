<div class="space-y-1">
    <a href="{{ route('pimpinan.dashboard') }}"
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('pimpinan.dashboard') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[material-symbols--dashboard-outline] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-sm font-inter font-medium">Dashboard</span>
    </a>

    <a href="{{ route('pimpinan.kth.index') }}"
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('pimpinan.kth.index') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[material-symbols--potted-plant-outline-sharp] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-sm font-inter font-medium">Monitoring KTH</span>
    </a>

    <a href="{{ route('pimpinan.laporan.index') }}"
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('pimpinan.laporan.index') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[lucide--notepad-text] w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-sm font-inter font-medium">Monitoring Laporan</span>
    </a>

    <span class="text-[10px] font-inter font-medium text-gray-500 ml-3 py-3">SYSTEM</span>

    <a href="{{ route('pimpinan.profile.index') }}"
        class="flex items-center gap-3 py-3 w-full rounded-lg {{ request()->routeIs('pimpinan.profile.index') ? 'border-r-4 border-primary text-primary bg-gray-100' : 'hover:border-r-4 hover:border-primary hover:text-primary hover:bg-gray-100 transition-colors duration-200' }}">
        <span class="icon-[iconamoon--profile]  w-6 h-6 hover:text-primary ml-3"></span>
        <span class="text-[14px] font-inter font-medium">Profil Saya</span>
    </a>
</div>
