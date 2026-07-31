@extends('layouts.app')

@section('title', 'Daftar Laporan KTH')

@section('content')
    <div class="space-y-6">
        {{-- Header & Tombol Buat Laporan --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="mb-2">
                <h1 class="text-2xl font-bold text-primary font-poppins">
                    Daftar Laporan KTH
                </h1>
                <p class="text-sm text-[#404943] font-normal mt-1">
                    Kelola dan pantau seluruh laporan Kelompok Tani Hutan di
                    wilayah Anda.
                </p>
            </div>
            <button type="button" onclick="window.openLaporanModal('create')"
                class="inline-flex items-center gap-2 px-4 py-3 bg-[#2b644a] text-white rounded-xl shadow hover:bg-[#1f4d36] transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Buat Laporan Baru</span>
            </button>
        </div>

        {{-- Statistik Cards --}}
        <div class="self-stretch grid grid-cols-4 gap-4">
            <div class="p-6 bg-white rounded-3xl border-l-4 border-blue-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-600 text-sm font-normal font-['Inter']">Total Laporan</p>
                        <p class="text-blue-600 text-4xl lg:text-5xl font-bold font-['Poppins'] leading-[57.60px]">
                            {{ number_format($totalLaporan) }}
                        </p>
                    </div>
                    <div class="flex items-center px-3 py-2 bg-blue-100 rounded-xl">
                        <span class="icon-[carbon--report] w-6 h-6 bg-blue-600"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-blue-600 text-sm font-['Inter']">Seluruh laporan dari semua KTH</span>
                </div>
            </div>

            <div class="p-6 bg-white rounded-3xl border-l-4 border-green-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-green-600 text-sm font-normal font-['Inter']">Verified</p>
                        <p class="text-green-600 text-4xl lg:text-5xl font-bold font-['Poppins'] leading-[57.60px]">
                            {{ number_format($totalVerified) }}
                        </p>
                    </div>
                    <div class="flex items-center px-3 py-2 bg-green-100 rounded-xl">
                        <span class="icon-[ix--success] w-6 h-6 bg-green-600"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-green-600 text-sm font-['Inter']">Sudah diverifikasi</span>
                </div>
            </div>

            <div class="p-6 bg-white rounded-3xl border-l-4 border-amber-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-amber-600 text-sm font-normal font-['Inter']">Pending</p>
                        <p class="text-amber-600 text-4xl lg:text-5xl font-bold font-['Poppins'] leading-[57.60px]">
                            {{ number_format($totalPending) }}
                        </p>
                    </div>
                    <div class="flex items-center px-3 py-2 bg-amber-100 rounded-xl">
                        <span class="icon-[tabler--clock] w-6 h-6 bg-amber-600"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-amber-600 text-sm font-['Inter']">Menunggu verifikasi</span>
                </div>
            </div>

            <div class="p-6 bg-white rounded-3xl border-l-4 border-red-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-red-600 text-sm font-normal font-['Inter']">Ditolak</p>
                        <p class="text-red-600 text-4xl lg:text-5xl font-bold font-['Poppins'] leading-[57.60px]">
                            {{ number_format($totalRejected) }}
                        </p>
                    </div>
                    <div class="flex items-center px-3 py-2 bg-red-100 rounded-xl">
                        <span class="icon-[carbon--close-outline] w-6 h-6 bg-red-600"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-red-600 text-sm font-['Inter']">Tidak lolos verifikasi</span>
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
                        placeholder="Cari nama KTH atau Periode Laporan..."
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

                <div class="relative w-48">
                    <select name="periode" onchange="this.form.submit()"
                        class="w-full h-12 px-4 pr-10 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] text-base appearance-none focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">Periode Laporan</option>
                        <option value="Semester I" {{ request('periode') == 'Semester I' ? 'selected' : '' }}>Semester I
                        </option>
                        <option value="Semester II" {{ request('periode') == 'Semester II' ? 'selected' : '' }}>Semester II
                        </option>
                        <option value="Tahunan" {{ request('periode') == 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
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

        {{-- Tabel Laporan --}}
        <div class="bg-white rounded-3xl overflow-hidden border border-[#edeeef] shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#c0c9c1]">
                    <thead class="bg-[#f3f4f5]">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">PERIODE</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">NAMA KTH</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">VERIFIKASI</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">STATUS KTH</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-[#404943] tracking-wider">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#c0c9c133]">
                        @forelse($laporans as $laporan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-base text-[#191c1d]">{{ $laporan->periode_laporan->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 flex items-center justify-center bg-[#d2e8dc] rounded-full">
                                            <span class="font-bold text-[#0e4c34] text-base">
                                                {{ strtoupper(substr($laporan->kth->nama_kth ?? 'U', 0, 2)) }}
                                            </span>
                                        </div>
                                        <span class="text-base text-[#191c1d]">{{ $laporan->kth->nama_kth ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @php
                                        $statusClass =
                                            [
                                                'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                'verified' => 'bg-green-100 text-green-800 border-green-200',
                                                'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                            ][$laporan->status_verifikasi] ?? 'bg-gray-100 text-gray-800';
                                        $dotClass =
                                            [
                                                'pending' => 'bg-amber-500',
                                                'verified' => 'bg-green-500',
                                                'rejected' => 'bg-red-500',
                                            ][$laporan->status_verifikasi] ?? 'bg-gray-500';
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium border {{ $statusClass }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                        {{ ucfirst($laporan->status_verifikasi) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    @if ($laporan->kth && $laporan->kth->status_kth == 'Aktif')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-primary">
                                            <span
                                                class="icon-[material-symbols--done-all] w-4 h-4 mr-1 text-primary"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <span class="icon-[ic--sharp-close] w-4 h-4 mr-1 text-red-800"></span>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button"
                                            onclick="openDetailLaporanPenyuluhModal({{ $laporan->id }})"
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
                                        <button type="button" onclick="openEditLaporanModal({{ $laporan->id }})"
                                            class="text-neutral hover:outline-2 hover:outline-blue-600 hover:bg-neutral bg-blue-600 rounded-lg p-2 transition-all duration-200 hover:text-blue-600 pt-1.5"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        @if ($laporan->status_verifikasi == 'rejected')
                                            <button type="button" onclick="openRevisiLaporanModal({{ $laporan->id }})"
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
                                            onclick="openHapusLaporanModal({{ $laporan->id }}, '{{ $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('d/m/Y') : '-' }}', '{{ addslashes($laporan->kth->nama_kth ?? '-') }}')"
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
                                <td colspan="5" class="px-6 py-10 text-center text-[#404943]">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="text-base font-medium">Belum ada laporan</p>
                                        <p class="text-sm text-gray-500 mt-1">Mulai tambahkan laporan KTH dengan klik
                                            tombol "Buat Laporan Baru"</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($laporans->hasPages())
                <div
                    class="px-6 py-4 bg-[#f3f4f5] border-t border-[#c0c9c133] flex flex-wrap items-center justify-between gap-3">
                    <p class="text-xs font-medium text-[#404943]">
                        Menampilkan {{ $laporans->firstItem() ?? 0 }}-{{ $laporans->lastItem() ?? 0 }} dari
                        {{ $laporans->total() }} Laporan
                    </p>
                    <div class="flex items-center gap-2">
                        {{-- Previous --}}
                        @if ($laporans->onFirstPage())
                            <button
                                class="h-8 w-8 flex items-center justify-center rounded-lg border border-[#c0c9c133] text-[#404943] opacity-50 cursor-not-allowed"
                                disabled>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                        @else
                            <a href="{{ $laporans->previousPageUrl() }}"
                                class="h-8 w-8 flex items-center justify-center rounded-lg border border-[#c0c9c133] text-[#404943] hover:bg-gray-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($laporans->getUrlRange(1, $laporans->lastPage()) as $page => $url)
                            @if ($page == $laporans->currentPage())
                                <span
                                    class="h-8 w-8 flex items-center justify-center rounded-lg bg-[#0e4c34] text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="h-8 w-8 flex items-center justify-center rounded-lg border border-[#c0c9c133] text-[#404943] hover:bg-gray-200">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($laporans->hasMorePages())
                            <a href="{{ $laporans->nextPageUrl() }}"
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
                    Menampilkan <span class="font-semibold">{{ $laporans->firstItem() ?? 0 }}</span>
                    dari <span class="font-semibold">{{ $laporans->total() }}</span> Laporan
                </div>
                <div>
                    {{ $laporans->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
@endsection
