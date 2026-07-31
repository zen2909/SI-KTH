@extends('layouts.app')

@section('title', 'Manajemen User Admin')

@section('content')
    <div class="w-full space-y-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-emerald-900 font-poppins">Kelola
                    Pengguna</h1>
                <p class="text-base text-neutral-700 font-inter mt-1">Kelola hak akses dan profil administrator
                    sistem KTH secara digital.</p>
            </div>

            <button type="button" onclick="openModalCreateUserAdmin('create')"
                class="px-6 py-3 bg-emerald-900 rounded-xl text-white hover:bg-emerald-800 transition flex items-center gap-2 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-base font-normal font-['Inter']">Tambah User</span>
            </button>
        </div>

        {{-- Statistik Cards --}}
        <div class="self-stretch grid grid-cols-3 gap-4">

            <div class="p-6 bg-white rounded-3xl border-l-4 border-blue-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-600 text-sm font-normal font-['Inter']">Total
                            Admin</p>
                        <p class="text-blue-600 text-4xl lg:text-5xl font-bold font-['Poppins'] leading-[57.60px]">
                            {{ number_format($totalAdmin) }}
                        </p>
                    </div>
                    <div class="flex justify-center items-center px-3 py-2 bg-blue-100 rounded-xl">
                        <span class="icon-[ri--admin-line] w-6 h-6 bg-blue-600"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-emerald-900 text-sm font-['Inter']">Jumlah Admin</span>
                </div>
            </div>

            <div class="p-6 bg-white rounded-3xl border-l-4 border-emerald-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-emerald-600 text-sm font-normal font-['Inter']">Total
                            Penyuluh</p>
                        <p class="text-emerald-600 text-4xl lg:text-5xl font-bold font-['Poppins'] leading-[57.60px]">
                            {{ number_format($totalPenyuluh) }}
                        </p>
                    </div>
                    <div class="flex items-center justify-center px-3 py-2 bg-emerald-100 rounded-xl">
                        <span class="icon-[mdi--people-outline] w-6 h-6 bg-emerald-600"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-emerald-600 text-sm font-['Inter']">Jumlah Penyuluh</span>
                </div>
            </div>

            <div class="p-6 bg-white rounded-3xl border-l-4 border-red-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-red-600 text-sm font-normal font-['Inter']">Total
                            Pimpinan</p>
                        <p class="text-red-600 text-4xl lg:text-5xl font-bold font-['Poppins'] leading-[57.60px]">
                            {{ number_format($totalPimpinan) }}
                        </p>
                    </div>
                    <div class="flex items-center justify-center px-3 py-2 bg-red-100 rounded-xl">
                        <span class="icon-[fluent-mdl2--party-leader] w-6 h-6 bg-red-600"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-red-600 text-sm font-['Inter']">Jumlah Pimpinan</span>
                </div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white rounded-3xl shadow-sm border border-stone-300/30 p-6 mb-6">
            <form action="{{ route('user.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                {{-- Search --}}
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-neutral-700 text-sm font-normal font-inter mb-2">
                        Cari User
                    </label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau email..."
                            class="w-full pl-12 pr-4 py-3 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] text-base focus:outline-none focus:ring-2 focus:ring-primary placeholder:text-gray-400">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Filter Role --}}
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-neutral-700 text-sm font-normal font-inter mb-2">
                        Role Pengguna
                    </label>
                    <select name="role"
                        class="w-full px-4 py-3 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-base font-inter appearance-none cursor-pointer">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="penyuluh" {{ request('role') == 'penyuluh' ? 'selected' : '' }}>Penyuluh
                        </option>
                        <option value="pimpinan" {{ request('role') == 'pimpinan' ? 'selected' : '' }}>Pimpinan
                        </option>
                    </select>
                </div>

                <!-- Tombol Aksi (sejajar ke samping) -->
                <div class="flex items-end gap-3 min-w-[200px]">
                    <button type="submit"
                        class="px-6 py-3 bg-emerald-900 text-white rounded-xl font-medium hover:bg-emerald-800 transition-colors whitespace-nowrap">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('kth.index') }}"
                        class="px-6 py-3 bg-gray-200 text-neutral-700 rounded-xl font-medium hover:bg-gray-300 transition-colors whitespace-nowrap">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Tabel User --}}
        <div class="bg-white rounded-3xl shadow-sm border border-stone-300/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-zinc-100 border-b border-stone-300">
                            <th class="px-6 py-4 text-left min-w-[200px]">
                                <span class="text-primary text-sm font-bold font-inter uppercase tracking-wide">Nama</span>
                            </th>
                            <th class="px-6 py-4 text-left min-w-[200px]">
                                <span class="text-primary text-sm font-bold font-inter uppercase tracking-wide">Email</span>
                            </th>
                            <th class="px-6 py-4 text-center min-w-[200px]">
                                <span class="text-primary text-sm font-bold font-inter uppercase tracking-wide">Role</span>
                            </th>
                            <th class="px-6 py-4 text-center min-w-[200px]">
                                <span class="text-primary text-sm font-bold font-inter uppercase tracking-wide">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="border-t border-stone-300/20 hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        @if ($user->foto_profil)
                                            <img src="{{ asset('storage/' . $user->foto_profil) }}"
                                                alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div
                                                class="w-10 h-10 bg-green-200 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-green-950 text-base font-bold font-['Inter']">
                                                    {{ Str::upper(substr($user->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-zinc-900 text-base font-normal font-['Inter']">
                                                {{ $user->name }}</div>
                                            @if ($user->email)
                                                <div class="text-neutral-500 text-xs font-['Inter']">{{ $user->email }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-neutral-700 text-base font-normal font-['Inter']">{{ $user->email }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($user->role == 'admin')
                                        <span
                                            class="inline-flex items-center gap-1.5 p-4 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            Admin
                                        </span>
                                    @elseif($user->role == 'penyuluh')
                                        <span
                                            class="inline-flex items-center gap-1.5 p-4 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            Penyuluh
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 p-4 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            Pimpinan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Tombol Detail Penyuluh --}}
                                        @if ($user->role == 'penyuluh')
                                            <button type="button"
                                                onclick="openDetailPenyuluhAdminModal(
            '{{ addslashes($user->name) }}',
            '{{ $user->email }}',
            '{{ $user->foto_profil }}',
            '{{ addslashes($user->penyuluh->nip ?? '') }}',
            '{{ addslashes($user->penyuluh->nik ?? '') }}',
            '{{ addslashes($user->penyuluh->tempat_lahir ?? '') }}',
            '{{ $user->penyuluh->tanggal_lahir ?? '' }}',
            '{{ addslashes($user->penyuluh->jenis_kelamin ?? '') }}',
            '{{ addslashes($user->penyuluh->alamat ?? '') }}',
            '{{ addslashes($user->penyuluh->no_telepon ?? '') }}',
            '{{ addslashes($user->penyuluh->email_pribadi ?? '') }}',
            '{{ addslashes($user->penyuluh->jabatan ?? '') }}',
            '{{ addslashes($user->penyuluh->golongan_pangkat ?? '') }}',
            '{{ addslashes($user->penyuluh->wilayah_kerja ?? '') }}',
            '{{ $user->plain_password ?? 'password123' }}',)"
                                                class="text-neutral hover:outline-2 hover:outline-yellow-500 hover:text-yellow-500 hover:bg-neutral bg-yellow-500 rounded-lg p-2 transition-all duration-200"
                                                title="Detail Penyuluh">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                    viewBox="0 0 24 24">
                                                    <path d="M0 0h24v24H0z" fill="none" />
                                                    <path fill="currentColor"
                                                        d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0" />
                                                </svg>
                                            </button>
                                        @else
                                            {{-- Tombol Detail untuk Admin/Pimpinan --}}
                                            <button type="button"
                                                onclick="openDetailUserAdminModal(
                            '{{ addslashes($user->name) }}',
                            '{{ $user->email }}',
                            '{{ $user->foto_profil }}',
                            '{{ $user->role }}'
                        )"
                                                class="text-neutral hover:outline-2 hover:outline-yellow-500 hover:text-yellow-500 hover:bg-neutral bg-yellow-500 rounded-lg p-2 transition-all duration-200"
                                                title="Detail User">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                    viewBox="0 0 24 24">
                                                    <path d="M0 0h24v24H0z" fill="none" />
                                                    <path fill="currentColor"
                                                        d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0" />
                                                </svg>
                                            </button>
                                        @endif

                                        <button type="button"
                                            onclick="openModalCreateUserAdmin('edit', {{ $user->id }})"
                                            class="text-neutral hover:outline-2 hover:outline-blue-600 hover:bg-neutral bg-blue-600 rounded-lg p-2 transition-all duration-200 hover:text-blue-600 pt-1.5"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>

                                        {{-- Tombol Hapus --}}
                                        <button type="button"
                                            onclick="openHapusUserAdminModal(
        {{ $user->id }}, 
        '{{ addslashes($user->name) }}', 
        '{{ $user->email }}', 
        '{{ $user->role }}', 
        '{{ $user->foto_profil }}'
    )"
                                            class="text-neutral hover:outline-2 hover:outline-red-600 hover:bg-neutral bg-red-600 rounded-lg p-2 transition-all duration-200 hover:text-red-600 pt-1.5"
                                            title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{ route('user.destroy', $user->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-base font-medium text-neutral-500">Tidak ada pengguna</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div
                class="px-8 py-5 bg-white border-t border-stone-300/20 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-neutral-700 text-sm font-inter">
                    Menampilkan <span class="font-bold">{{ $users->firstItem() ?? 0 }}</span> -
                    <span class="font-bold">{{ $users->lastItem() ?? 0 }}</span>
                    dari <span class="font-bold">{{ $users->total() }}</span> pengguna
                </div>
                <div>
                    {{ $users->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    alert('{{ session('success') }}');
                }
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'Tutup'
                    });
                } else {
                    alert('{{ session('error') }}');
                }
            });
        </script>
    @endif

    @push('scripts')
        <script>
            // ============================================
            // FUNGSI BUKA MODAL DETAIL USER
            // ============================================
            function openDetailUserModal(userId) {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Mengambil data pengguna',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`/admin/user-management/${userId}/detail`)
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            const user = data.data;
                            let html = `
                        <div class="text-left">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 rounded-full bg-green-200 flex items-center justify-center text-2xl font-bold text-green-800">
                                    ${user.foto ? `<img src="/storage/${user.foto}" class="w-full h-full rounded-full object-cover">` : user.name.charAt(0).toUpperCase()}
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-zinc-900">${user.name}</h3>
                                    <p class="text-sm text-neutral-500">${user.email}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-neutral-500 font-medium uppercase">Username</p>
                                    <p class="text-sm font-semibold text-zinc-900">${user.username || '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-500 font-medium uppercase">Role</p>
                                    <p class="text-sm font-semibold text-zinc-900">${user.role ? user.role.charAt(0).toUpperCase() + user.role.slice(1) : '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-500 font-medium uppercase">No Telepon</p>
                                    <p class="text-sm font-semibold text-zinc-900">${user.no_telepon || '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-500 font-medium uppercase">Alamat</p>
                                    <p class="text-sm font-semibold text-zinc-900">${user.alamat || '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-500 font-medium uppercase">Status</p>
                                    <p class="text-sm font-semibold ${user.email_verified_at ? 'text-green-600' : 'text-yellow-600'}">
                                        ${user.email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi'}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-500 font-medium uppercase">Bergabung</p>
                                    <p class="text-sm font-semibold text-zinc-900">${user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-'}</p>
                                </div>
                            </div>
                        </div>
                    `;
                            Swal.fire({
                                title: 'Detail Pengguna',
                                html: html,
                                icon: 'info',
                                confirmButtonText: 'Tutup',
                                confirmButtonColor: '#0E4C34',
                                width: 600,
                            });
                        }
                    })
                    .catch(error => {
                        Swal.close();
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal mengambil data pengguna',
                            icon: 'error',
                            confirmButtonText: 'Tutup'
                        });
                    });
            }

            // ============================================
            // FUNGSI HAPUS USER
            // ============================================
            function openHapusUserModal(id, name) {
                Swal.fire({
                    title: 'Hapus Pengguna?',
                    html: `
                <p>Apakah Anda yakin ingin menghapus pengguna <strong>"${name}"</strong>?</p>
                <p class="text-xs text-red-500 mt-2">⚠️ Tindakan ini tidak dapat dibatalkan!</p>
            `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        </script>
    @endpush
@endsection
