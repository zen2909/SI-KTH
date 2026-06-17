<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SI-KTH Dashboard')</title>

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-50 font-inter antialiased">

    <!-- ======================== SIDEBAR ======================== -->
    <aside
        class="bg-white h-screen w-72 flex flex-col fixed left-0 top-0 shadow-sm z-50 transition-transform duration-300"
        id="sidebar">
        <div class="px-6 py-6 flex flex-col items-start h-full w-full">

            <!-- Brand / Logo -->
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-emerald-700 rounded-lg flex items-center justify-center text-white">
                    <span class="icon-[material-symbols--forest-outline] w-5 h-5"></span>
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
                        @include('layouts.partials.sidebar-admin')
                    @elseif(auth()->user()->role == 'penyuluh')
                        @include('layouts.partials.sidebar-penyuluh')
                    @elseif(auth()->user()->role == 'pimpinan')
                        @include('layouts.partials.sidebar-pimpinan')
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
                        <h2 class="text-xl font-poppins font-semibold text-primary">Dashboard Admin</h2>
                    @elseif(auth()->user()->role == 'penyuluh')
                        <h2 class="text-xl font-poppins font-semibold text-primary">Dashboard Penyuluh</h2>
                    @elseif(auth()->user()->role == 'pimpinan')
                        <h2 class="text-xl font-poppins font-semibold text-primary">Dashboard Pimpinan</h2>
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
                    <img src="{{ auth()->user()->foto_profil ? asset('storage/foto_profil/' . auth()->user()->foto_profil) : asset('images/default-avatar.png') }}"
                        alt="Avatar" class="w-8 h-8 rounded-full border border-gray-300 object-cover">
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

    @stack('scripts')
</body>

</html>
