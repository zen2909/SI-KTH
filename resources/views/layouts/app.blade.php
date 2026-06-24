<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SI-KTH Dashboard')</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="msapplication-TileColor" content="#165b33">
    <meta name="theme-color" content="#165b33">


    <!-- Tailwind CSS via Vite -->
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/@iconify/iconify@1.0.7/dist/iconify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</head>

<body class="bg-gray-50 font-inter antialiased">

    <!-- ======================== SIDEBAR ======================== -->
    <aside
        class="bg-white h-screen w-72 flex flex-col fixed left-0 top-0 shadow-sm z-50 transition-transform duration-300"
        id="sidebar">
        <div class="px-6 py-6 flex flex-col items-start h-full w-full">

            <!-- Brand / Logo -->
            <div class="flex items-center gap-3 mb-8">
                <div class="w-14 h-14 bg-emerald-700 rounded-lg flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('images/logo-jatim.png') }}" class="w-full h-full object-contain p-1"
                        alt="logo-jatim">
                </div>
                <div>
                    <h1 class="text-xl font-poppins font-bold text-emerald-800">SI-KTH</h1>
                    @auth
                        @if (auth()->user()->role == 'admin')
                            <p class="text-xs font-inter text-gray-500">Admin Panel</p>
                        @elseif(auth()->user()->role == 'penyuluh')
                            <p class="text-xs font-inter text-gray-500">Penyuluh Panel</p>
                        @elseif(auth()->user()->role == 'pimpinan')
                            <p class="text-xs font-inter text-gray-500">Pimpinan Panel</p>
                        @endif
                    @endauth

                </div>
            </div>

            <!-- Navigasi berdasarkan role (partial) -->
            <nav class="w-full flex-1 overflow-y-auto">
                @auth
                    @if (auth()->user()->role == 'admin')
                        @include('layouts.sidebar.sidebar-admin')
                    @elseif(auth()->user()->role == 'penyuluh')
                        @include('layouts.sidebar.sidebar-penyuluh')
                    @elseif(auth()->user()->role == 'pimpinan')
                        @include('layouts.sidebar.sidebar-pimpinan')
                    @endif
                @endauth
            </nav>

            <!-- Bagian bawah: profil & logout -->
            <div class="mt-auto pt-4 border-t border-gray-200 w-full">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 hover:border-r-4 hover:border-red-600 transition-colors duration-200">
                    <span class="icon-[material-symbols--logout] w-6 h-6 text-red-600"></span>
                    <span class="text-sm text-inter font-medium">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </aside>

    <!-- ======================== MAIN CONTENT ======================== -->
    <main class="ml-72 min-h-screen">

        <!-- Header / Top App Bar -->
        <header class="h-16 sticky top-0 z-40 bg-white border-b border-gray-200 flex justify-between items-center px-6">
            <div class="flex items-center gap-4">
                <button class="flex items-center p-2 hover:bg-gray-100 rounded-full transition-colors text-gray-600"
                    id="toggleSidebar">
                    <span class="icon-[material-symbols--menu-rounded] w-6 h-6"></span>
                </button>
                @auth
                    @if (auth()->user()->role == 'admin')
                        @include('layouts.header.header-admin')
                    @elseif(auth()->user()->role == 'penyuluh')
                        @include('layouts.header.header-penyuluh')
                    @elseif(auth()->user()->role == 'pimpinan')
                        @include('layouts.header.header-pimpinan')
                    @endif
                @endauth
            </div>

            <div class="flex items-center gap-6">

                <!-- Profil User -->
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-poppins font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs font-inter text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    @php
                        $fotoProfil = auth()->user()->foto_profil;
                        $fotoUrl = $fotoProfil ? asset('storage/' . $fotoProfil) : asset('images/default-avatar.png');
                    @endphp

                    <img src="{{ $fotoUrl }}" alt="Avatar"
                        class="w-8 h-8 rounded-full border border-gray-300 object-cover"
                        onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                </div>
            </div>
        </header>

        <!-- Konten Halaman -->
        <div class="p-6 space-y-6">
            @yield('content')
        </div>

    </main>

    <!-- ======================== SCRIPTS ======================== -->
    <script>
        // Toggle Sidebar
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('main');
        let isSidebarVisible = true;

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                if (isSidebarVisible) {
                    sidebar.style.transform = 'translateX(-100%)';
                    main.style.marginLeft = '0';
                } else {
                    sidebar.style.transform = 'translateX(0)';
                    main.style.marginLeft = '18rem';
                }
                isSidebarVisible = !isSidebarVisible;
            });
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- ============================================ -->
    <!-- MODAL YANG TIDAK MEMERLUKAN DATA -->
    <!-- ============================================ -->
    @include('components.modal.penyuluh.modal-edit-penyuluh', ['penyuluh' => auth()->user()->penyuluh])
    @include('components.modal.penyuluh.modal-ubah-foto', ['user' => auth()->user()])
    @include('components.modal.penyuluh.modal-kth', ['kth' => null, 'mode' => 'create'])
    @include('components.modal.penyuluh.modal-warning-edit-kth')
    @include('components.modal.penyuluh.modal-hapus-kth')
    @include('components.modal.penyuluh.modal-laporan', [
        'kth' => null,
        'laporan' => null,
        'mode' => 'create',
        'kthOptions' => $kthOptions ?? collect(),
    ])
    @include('components.modal.penyuluh.modal-preview-upload')
    @include('components.modal.penyuluh.modal-warning-laporan')
    @include('components.modal.penyuluh.modal-hapus-laporan')
    @include('components.modal.penyuluh.modal-revisi-laporan')

    @include('components.modal.penyuluh.modal-detail-laporan', ['laporan' => $laporan ?? null])
    @include('components.modal.admin.modal-approve-kth')
    @php
        $rejectUrl = route('kth.verifikasi.reject', ['id' => 0]);
    @endphp
    @include('components.modal.admin.modal-reject-kth', ['rejectUrl' => $rejectUrl])
    @include('components.modal.admin.modal-detail-kth-verifikasi', ['kth' => $kth ?? null])
    @include('components.modal.admin.modal-approve-laporan')
    @include('components.modal.admin.modal-reject-laporan')
    @include('components.modal.admin.modal-detail-laporan-verifikasi', ['laporan' => $laporan ?? null])

    @include('components.modal.admin.modal-hapus-kth-admin', ['kth' => null])
    @include('components.modal.admin.modal-hapus-laporan-admin')
    @include('components.modal.admin.modal-detail-laporan-admin', ['laporan' => $laporan ?? null])
    @include('components.modal.admin.modal-create-user', ['user' => null, 'mode' => 'create'])
    @include('components.modal.admin.modal-detail-user')
    @include('components.modal.admin.modal-detail-penyuluh')
    @include('components.modal.admin.modal-hapus-user', ['user' => null])
    @include('components.modal.admin.modal-ubah-foto', ['user' => auth()->user()])
    @include('components.modal.admin.modal-export-kth', [
        'totalData' => $totalKTH ?? 0,
        'kecamatanList' => $kecamatanList ?? [],
    ])
    @include('components.modal.admin.modal-export-laporan', [
        'totalData' => $totalLaporan ?? 0,
        'tahunList' => $tahunList ?? [],
    ])

    @include('components.modal.pimpinan.modal-detail-laporan', ['laporan' => $laporan ?? null])
    @include('components.modal.pimpinan.modal-export-kth', [
        'totalData' => $totalKTH ?? 0,
        'kecamatanList' => $kecamatanList ?? [],
    ])
    @include('components.modal.pimpinan.modal-export-laporan', [
        'totalData' => $totalLaporan ?? 0,
        'tahunList' => $tahunList ?? [],
    ])
    @include('components.modal.pimpinan.modal-ubah-foto', ['user' => auth()->user()])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

</body>



</html>
