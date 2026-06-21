@extends('layouts.app')

@section('title', 'Daftar KTH Saya')

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
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">NAMA KTH</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">KELAS</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">VERIFIKASI</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">STATUS</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">KECAMATAN</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-[#404943] tracking-wider">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#c0c9c1]">
                        @forelse($kths as $kth)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 flex items-center justify-center bg-[#2b644a1a] rounded-full">
                                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-base font-normal text-[#191c1d]">{{ $kth->nama_kth }}</p>
                                            <p class="text-sm text-[#707973]">No Registrasi:
                                                {{ $kth->nomor_register ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-base text-[#191c1d]">{{ $kth->kelas_kth ?? '-' }}</td>
                                <td class="px-6 py-5">
                                    @php
                                        $statusClass =
                                            [
                                                'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                'verified' => 'bg-green-100 text-green-800 border-green-200',
                                                'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                            ][$kth->status_verifikasi] ?? 'bg-gray-100 text-gray-800';
                                        $dotClass =
                                            [
                                                'pending' => 'bg-amber-500',
                                                'verified' => 'bg-green-500',
                                                'rejected' => 'bg-red-500',
                                            ][$kth->status_verifikasi] ?? 'bg-gray-500';
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium border {{ $statusClass }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                        {{ ucfirst($kth->status_verifikasi) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    @if ($kth->status_kth == 'Aktif')
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
                                <td class="px-6 py-5 text-[#404943]">{{ $kth->kecamatan ?? '-' }}</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">

                                        <button onclick="openDetailKTHModal({{ $kth->id }})"
                                            class="text-neutral hover:outline-2 hover:outline-primary hover:text-primary hover:bg-neutral bg-primary rounded-lg p-2 transition-all duration-200"
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
        </div>

        {{-- Info Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-3xl border border-[#e0e0e0] p-5 shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-8 h-8 text-[#4f6359]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-base font-normal text-[#4f6359]">Butuh Bantuan?</h4>
                        <p class="text-sm text-[#55695f] mt-1">Hubungi administrator teknis jika<br>Anda mengalami kendala
                            verifikasi<br>data KTH.</p>
                    </div>
                </div>
            </div>
            <div class="bg-[#0e4c340d] rounded-3xl border border-[#0e4c341a] p-5 shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-8 h-8 text-[#0e4c34]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-base font-normal text-[#0e4c34]">Data Terkini</h4>
                        <p class="text-sm text-[#404943] mt-1">Data KTH selalu diperbarui secara real-time<br>untuk
                            memastikan informasi yang akurat.</p>
                    </div>
                </div>
            </div>
            <div class="bg-[#e7e8e9] rounded-3xl border border-[#c0c9c14c] p-5 shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-8 h-8 text-[#404943]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                    <div>
                        <h4 class="text-base font-normal text-[#404943]">Keamanan Data</h4>
                        <p class="text-sm text-[#404943] mt-1">Seluruh data yang dimasukkan telah<br>dienkripsi dan sesuai
                            dengan standar<br>privasi kehutanan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk reset filter --}}
    <script>
        function resetFilters() {
            window.location.href = "{{ route('penyuluh.kth.index') }}";
        }
    </script>
@endsection
