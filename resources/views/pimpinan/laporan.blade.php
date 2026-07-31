@extends('layouts.app')

@section('title', 'Monitoring Laporan KTH')

@section('content')
    <div class="w-full space-y-6">
        {{-- Header --}}
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-emerald-900 font-poppins">Daftar Laporan KTH</h1>
                <p class="text-base text-neutral-700 font-inter mt-1">Kelola dan verifikasi seluruh laporan berkala dari
                    Kelompok Tani Hutan di wilayah administratif Anda secara digital.</p>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="openModalExportLaporanPimpinan()"
                    class="flex items-center gap-2 px-6 py-3 bg-emerald-900 rounded-xl text-white hover:bg-emerald-800 transition shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                        </path>
                    </svg>
                    <span>Export Data</span>
                </button>
            </div>
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
            <form action="{{ route('pimpinan.laporan.index') }}" method="GET"
                class="flex flex-wrap items-center gap-3 w-full">
                {{-- Search --}}
                <div class="relative flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama KTH atau Jenis Usaha..."
                        class="w-full h-12 pl-12 pr-4 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] text-base focus:outline-none focus:ring-2 focus:ring-primary">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
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

        {{-- Tabel --}}
        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-100 border-b border-stone-300">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-primary uppercase tracking-wide">Nama
                                KTH</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-primary uppercase tracking-wide">
                                Periode</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-primary uppercase tracking-wide">
                                Jenis
                                Usaha</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-primary uppercase tracking-wide">
                                Status KTH</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-primary uppercase tracking-wide">
                                Status Laporan</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-primary uppercase tracking-wide">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-300">
                        @forelse($laporans as $laporan)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span
                                        class="text-base font-medium text-zinc-900">{{ $laporan->kth->nama_kth ?? '-' }}</span>
                                </td>
                                <td class="text-center px-6 py-4">
                                    <span
                                        class="text-base text-zinc-600">{{ $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('d M Y') : '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-base text-neutral-700">{{ $laporan->jenis_usaha ?? '-' }}</span>
                                </td>
                                <td class="text-center px-6 py-4">
                                    @if ($laporan->kth->status_verifikasi == 'verified')
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
                                    @elseif($laporan->kth->status_verifikasi == 'pending')
                                        <span class="px-2 py-1 bg-amber-100 rounded-lg inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-amber-800" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span
                                                class="text-amber-800 text-xs font-semibold font-inter leading-4">Pending</span>
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
                                                class="text-red-800 text-xs font-semibold font-inter leading-4">Rejected</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center px-6 py-4">
                                    @if ($laporan->status_verifikasi == 'verified')
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
                                    @elseif($laporan->status_verifikasi == 'pending')
                                        <span class="px-2 py-1 bg-amber-100 rounded-lg inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-amber-800" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span
                                                class="text-amber-800 text-xs font-semibold font-inter leading-4">Pending</span>
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
                                                class="text-red-800 text-xs font-semibold font-inter leading-4">Rejected</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">

                                        <button type="button"
                                            onclick="openDetailLaporanPimpinanView({{ $laporan->id }})"
                                            class="text-neutral hover:outline-2 hover:outline-yellow-500 hover:text-yellow-500 hover:bg-neutral bg-yellow-500 rounded-lg p-2 transition-all duration-200"
                                            title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24">
                                                <path d="M0 0h24v24H0z" fill="none" />
                                                <path fill="currentColor"
                                                    d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-neutral-500">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-base font-medium">Tidak ada laporan</p>
                                    <p class="text-sm text-gray-400 mt-1">Harap menunggu laporan KTH oleh penyuluh</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

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

    @push('scripts')
        <script>
            // ============================================
            // FUNGSI RESET FILTER
            // ============================================
            function resetFilters() {
                window.location.href = window.location.pathname;
            }

            // ============================================
            // FUNGSI BUKA MODAL EXPORT LAPORAN PIMPINAN
            // ============================================
            window.openModalExportLaporanPimpinan = function() {
                var modal = document.getElementById('modalExportLaporanPimpinan');
                if (modal) {
                    modal.showModal();
                    document.body.classList.add('no-scroll');
                    setTimeout(function() {
                        if (typeof updateTotalLaporanPimpinan === 'function') {
                            updateTotalLaporanPimpinan();
                        }
                    }, 300);
                }
            };
        </script>
    @endpush
@endsection
