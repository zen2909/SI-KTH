@extends('layouts.app')

@section('title', 'Daftar KTH')

@section('content')
    <div class="space-y-6">
        {{-- Header & Tombol Tambah --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="mb-2">
                <h1 class="text-2xl font-bold text-primary font-poppins">
                    Daftar KTH
                </h1>
                <p class="text-sm text-[#404943] font-normal mt-1">
                    Kelola dan pantau Kelompok Tani Hutan di wilayah tugas Anda.
                </p>
            </div>
            <button type="button" onclick="window.openKTHModal('create')"
                class="inline-flex items-center gap-2 px-4 py-3 bg-primary text-white rounded-xl shadow hover:bg-[#1f4d36] hover:scale-105 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah KTH Baru</span>
            </button>
        </div>

        <!-- Statistik Cards -->
        <div class="self-stretch grid grid-cols-5 gap-4">
            <!-- Total KTH -->
            <div class="p-6 bg-white rounded-3xl border-l-4 border-blue-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-600 text-sm font-normal font-inter">Total KTH</p>
                        <p class="text-blue-600 text-4xl lg:text-5xl font-bold font-['Poppins'] leading-[57.60px]">
                            {{ $totalKTH }}
                        </p>
                    </div>
                    <div class="flex items-center px-3 py-2 bg-blue-100 rounded-xl">
                        <span class="icon-[material-symbols--forest-outline-rounded] w-6 h-6 bg-blue-600"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-blue-600 text-sm font-inter">Total keseluruhan</span>
                </div>
            </div>

            <!-- Terverifikasi -->
            <div class="p-6 bg-white rounded-3xl border-l-4 border-green-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-green-600 text-sm font-normal font-inter">Verified</p>
                        <p class="text-green-600 text-4xl lg:text-5xl font-bold font-['Poppins'] leading-[57.60px]">
                            {{ $totalVerified }}
                        </p>
                    </div>
                    <div class="flex items-center px-3 py-2 bg-green-100 rounded-xl">
                        <span class="icon-[ix--success] w-6 h-6 bg-green-600"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-green-600 text-sm font-inter">Sudah diverifikasi</span>
                </div>
            </div>

            <!-- Pending -->
            <div class="p-6 bg-white rounded-3xl border-l-4 border-amber-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-amber-600 text-sm font-normal font-inter">Pending</p>
                        <p class="text-amber-600 text-4xl lg:text-5xl font-bold font-['Poppins'] leading-[57.60px]">
                            {{ $totalPending }}
                        </p>
                    </div>
                    <div class="flex items-center px-3 py-2 bg-amber-100 rounded-xl">
                        <span class="icon-[tabler--clock] w-6 h-6 bg-amber-600"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-amber-600 text-sm font-inter">Menunggu verifikasi</span>
                </div>
            </div>

            <!-- Ditolak -->
            <div class="p-6 bg-white rounded-3xl border-l-4 border-red-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-red-600 text-sm font-normal font-inter">Rejected</p>
                        <p class="text-red-600 text-4xl lg:text-5xl font-bold font-['Poppins'] leading-[57.60px]">
                            {{ $totalRejected }}
                        </p>
                    </div>
                    <div class="flex items-center px-3 py-2 bg-red-100 rounded-xl">
                        <span class="icon-[carbon--close-outline] w-6 h-6 bg-red-600"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-red-600 text-sm font-inter">Tidak lolos verifikasi</span>
                </div>
            </div>

            <!-- Non-Aktif -->
            <div class="p-6 bg-white rounded-3xl border-l-4 border-gray-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-600 text-sm font-normal font-inter">Non-Aktif</p>
                        <p class="text-gray-600 text-4xl lg:text-5xl font-bold font-['Poppins'] leading-[57.60px]">
                            {{ $totalNonAktif ?? 0 }}
                        </p>
                    </div>
                    <div class="flex items-center px-3 py-2 bg-gray-100 rounded-xl">
                        <span class="icon-[fe--disabled] w-6 h-6 bg-gray-600"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-gray-600 text-sm font-inter">Tidak aktif</span>
                </div>
            </div>
        </div>

        {{-- Filter & Pencarian --}}
        <div class="bg-white rounded-3xl shadow p-4 flex flex-wrap items-center gap-3">
            <form action="{{ route('penyuluh.kth.index') }}" method="GET"
                class="flex flex-wrap items-center gap-3 w-full">
                {{-- Search --}}
                <div class="relative flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama KTH atau kecamatan..."
                        class="w-full h-12 pl-12 pr-4 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] text-base focus:outline-none focus:ring-2 focus:ring-primary">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                {{-- Filter Status Verifikasi --}}
                <div class="relative w-48">
                    <select name="status_verifikasi" onchange="this.form.submit()"
                        class="w-full h-12 px-4 pr-10 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] text-base appearance-none focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">Status Verifikasi</option>
                        <option value="pending" {{ request('status_verifikasi') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="verified" {{ request('status_verifikasi') == 'verified' ? 'selected' : '' }}>Verified
                        </option>
                        <option value="rejected" {{ request('status_verifikasi') == 'rejected' ? 'selected' : '' }}>Rejected
                        </option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500 pointer-events-none"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>

                {{-- Filter Status KTH --}}
                <div class="relative w-48">
                    <select name="status_kth" onchange="this.form.submit()"
                        class="w-full h-12 px-4 pr-10 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] text-base appearance-none focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">Status KTH</option>
                        <option value="Aktif" {{ request('status_kth') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ request('status_kth') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak
                            Aktif</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500 pointer-events-none"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>

                <button type="button" onclick="resetFilters()"
                    class="h-12 px-6 border border-[#c0c9c1] rounded-xl text-[#404943] flex items-center gap-2 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Reset Filter
                </button>
            </form>
        </div>

        {{-- Tabel KTH --}}
        <div class="bg-white rounded-3xl overflow-hidden border border-[#edeeef] shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#c0c9c1]">
                    <thead class="bg-[#f3f4f5]">
                        <tr class="bg-zinc-100 border-b border-stone-300">
                            <th class="px-6 py-4 text-left min-w-[200px]">
                                <span class="text-primary text-sm font-bold font-inter uppercase tracking-wide">Nama
                                    KTH</span>
                            </th>
                            <th class="px-6 py-4 text-center min-w-[100px]">
                                <span
                                    class="text-primary text-sm font-bold font-inter uppercase tracking-wide">Kelas</span>
                            </th>
                            <th class="px-6 py-4 text-center min-w-[120px]">
                                <span class="text-primary text-sm font-bold font-inter uppercase tracking-wide">Status
                                    KTH</span>
                            </th>
                            <th class="px-6 py-4 text-center min-w-[140px]">
                                <span class="text-primary text-sm font-bold font-inter uppercase tracking-wide">Status
                                    Verifikasi</span>
                            </th>
                            <th class="px-6 py-4 text-center min-w-[120px]">
                                <span
                                    class="text-primary text-sm font-bold font-inter uppercase tracking-wide">Kecamatan</span>
                            </th>
                            <th class="px-6 py-4 text-center min-w-[100px]">
                                <span class="text-primary text-sm font-bold font-inter uppercase tracking-wide">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#c0c9c1]">
                        @forelse($kths as $kth)
                            <tr class="hover:bg-gray-50">
                                <!-- Nama KTH -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <div class="text-zinc-900 text-sm font-normal font-inter">
                                                {{ $kth->nama_kth }}</div>
                                            <div class="text-neutral-700 text-xs font-normal font-inter leading-4">
                                                Desa {{ $kth->desa }}, {{ $kth->kecamatan }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center px-6 py-4">
                                    @if ($kth->kelas_kth == 'Utama')
                                        <span class="items-center justify-center px-3 bg-red-100 rounded-lg inline-block">
                                            <span class="text-red-700 text-xs font-semibold font-inter leading-4">
                                                Utama
                                            </span>
                                        </span>
                                    @elseif($kth->kelas_kth == 'Madya')
                                        <span class="items-center justify-center px-3 bg-red-100 rounded-lg inline-block">
                                            <span class="text-red-700 text-xs font-semibold font-inter leading-4">
                                                Madya
                                            </span>
                                        </span>
                                    @elseif($kth->kelas_kth == 'Pemula')
                                        <span
                                            class="items-center justify-center px-3 bg-green-100 rounded-lg inline-block">
                                            <span class="text-green-700 text-xs font-semibold font-inter leading-4">
                                                Pemula
                                            </span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Status KTH -->
                                <td class="text-center px-6 py-4">
                                    @if ($kth->status_kth == 'Aktif')
                                        <span
                                            class="px-2.5 py-0.5 bg-green-100 rounded-full inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                            <span
                                                class="text-green-800 text-xs font-medium font-inter leading-4">Aktif</span>
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-0.5 bg-slate-100 rounded-full inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>
                                            <span class="text-slate-600 text-xs font-medium font-inter leading-4">Tidak
                                                Aktif</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Status Verifikasi -->
                                <td class="text-center px-6 py-4">
                                    @if ($kth->status_verifikasi == 'verified')
                                        <span class="px-2 py-1 bg-primary/10 rounded-lg inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-primary" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span
                                                class="text-primary text-xs font-semibold font-inter leading-4">Verified</span>
                                        </span>
                                    @elseif($kth->status_verifikasi == 'pending')
                                        <span class="px-2 py-1 bg-amber-100 rounded-lg inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-amber-800" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span
                                                class="text-amber-800 text-xs font-semibold font-inter leading-4">Menunggu</span>
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 rounded-lg inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-red-800" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span
                                                class="text-red-800 text-xs font-semibold font-inter leading-4">Ditolak</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Kecamatan -->
                                <td class="text-center px-6 py-4">
                                    <span
                                        class="text-neutral-700 text-sm font-normal font-inter">{{ $kth->kecamatan }}</span>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openDetailKTHPenyuluhModal({{ $kth->id }})"
                                            class="text-neutral hover:outline-2 hover:outline-yellow-500 hover:text-yellow-500 hover:bg-neutral bg-yellow-500 rounded-lg p-2 transition-all duration-200"
                                            title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                        @php
                                            $tanggalRegister = $kth->tanggal_register
                                                ? \Carbon\Carbon::parse($kth->tanggal_register)->format('Y-m-d')
                                                : '';
                                        @endphp

                                        <button type="button"
                                            onclick="openEditKTHModal(
            '{{ $kth->id }}',
            '{{ addslashes($kth->nama_kth) }}',
            '{{ $kth->kelas_kth }}',
            '{{ $kth->nomor_register }}',
            '{{ $kth->tanggal_register ? \Carbon\Carbon::parse($kth->tanggal_register)->format('Y-m-d') : '' }}',
            '{{ $kth->kabupaten }}',
            '{{ $kth->kecamatan }}',
            '{{ $kth->desa }}',
            '{{ addslashes($kth->nama_ketua) }}',
            '{{ $kth->no_hp_ketua }}',
            '{{ $kth->status_kth }}',
            '{{ $kth->tahun_tidak_aktif }}',
            '{{ $kth->latitude }}',
            '{{ $kth->longitude }}',
            '{{ $kth->status_verifikasi }}'  // <-- Tambahkan ini
        )"
                                            class="text-neutral hover:outline-2 hover:outline-blue-600 hover:bg-neutral bg-blue-600 rounded-lg p-2 transition-all duration-200 hover:text-blue-600 pt-1.5"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        @if ($kth->status_verifikasi == 'rejected')
                                            <button type="button" onclick="openCatatanRevisiModal({{ $kth->id }})"
                                                class="text-neutral hover:outline-2 hover:outline-yellow-500 hover:bg-neutral bg-yellow-500 rounded-lg p-2 transition-all duration-200 hover:text-yellow-500 pt-1.5"
                                                title="Lihat Catatan Revisi">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5""
                                                    viewBox="0 0 24 24">
                                                    <path d="M0 0h24v24H0z" fill="none" />
                                                    <path fill="currentColor"
                                                        d="M6 22q-.825 0-1.412-.587T4 20V4q0-.825.588-1.412T6 2h7.175q.4 0 .763.15t.637.425l4.85 4.85q.275.275.425.638t.15.762V20q0 .825-.587 1.413T18 22zm7-14V4H6v16h12V9h-4q-.425 0-.712-.288T13 8M6 4v5zv16z" />
                                                </svg>
                                            </button>
                                        @endif
                                        <button type="button"
                                            onclick="openHapusKTHModal({{ $kth->id }}, '{{ addslashes($kth->nama_kth) }}')"
                                            class="text-neutral hover:outline-2 hover:outline-red-600 hover:bg-neutral bg-red-600 rounded-lg p-2 transition-all duration-200 hover:text-red-600 pt-1.5"
                                            title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-[#404943]">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        <p class="text-base font-medium">Belum ada data KTH</p>
                                        <p class="text-sm text-gray-500 mt-1">Mulai tambahkan data KTH baru dengan klik
                                            tombol "Tambah KTH Baru"</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($kths->hasPages())
                <div
                    class="px-6 py-4 bg-[#f3f4f5] border-t border-[#c0c9c133] flex flex-wrap items-center justify-between gap-3">
                    <p class="text-xs font-medium text-[#404943]">
                        Menampilkan {{ $kths->firstItem() ?? 0 }}-{{ $kths->lastItem() ?? 0 }} dari {{ $kths->total() }}
                        KTH
                    </p>
                    <div class="flex items-center gap-2">
                        {{-- Previous --}}
                        @if ($kths->onFirstPage())
                            <button
                                class="h-8 w-8 flex items-center justify-center rounded-lg border border-[#c0c9c133] text-[#404943] opacity-50 cursor-not-allowed"
                                disabled>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                        @else
                            <a href="{{ $kths->previousPageUrl() }}"
                                class="h-8 w-8 flex items-center justify-center rounded-lg border border-[#c0c9c133] text-[#404943] hover:bg-gray-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($kths->getUrlRange(1, $kths->lastPage()) as $page => $url)
                            @if ($page == $kths->currentPage())
                                <span
                                    class="h-8 w-8 flex items-center justify-center rounded-lg bg-[#0e4c34] text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="h-8 w-8 flex items-center justify-center rounded-lg border border-[#c0c9c133] text-[#404943] hover:bg-gray-200">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($kths->hasMorePages())
                            <a href="{{ $kths->nextPageUrl() }}"
                                class="h-8 w-8 flex items-center justify-center rounded-lg border border-[#c0c9c133] text-[#404943] hover:bg-gray-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @else
                            <button
                                class="h-8 w-8 flex items-center justify-center rounded-lg border border-[#c0c9c133] text-[#404943] opacity-50 cursor-not-allowed"
                                disabled>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            @endif
            <!-- Pagination -->
            <div
                class="px-6 py-4 bg-zinc-100 border-t border-stone-300 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-neutral-700 text-sm font-normal font-inter leading-6">
                    Menampilkan <span class="font-semibold">{{ $kths->firstItem() ?? 0 }}</span>
                    dari <span class="font-semibold">{{ $kths->total() }}</span> KTH
                </div>
                <div>
                    {{ $kths->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
    @include('components.modal.penyuluh.modal-detail-kth', ['kth' => $kth ?? null])
    {{-- Script untuk reset filter --}}
    <script>
        function resetFilters() {
            window.location.href = "{{ route('penyuluh.kth.index') }}";
        }
    </script>
@endsection
