@extends('layouts.app')

@section('title', 'Monitoring KTH')

@section('content')
    <div class="w-full space-y-6">
        {{-- Header --}}
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-primary font-poppins">Daftar Kelompok Tani Hutan</h1>
                <p class="text-base text-neutral-700 font-inter mt-1">Monitoring seluruh Kelompok Tani Hutan secara
                    komprehensif.</p>
            </div>
            <button type="button" onclick="openModalExportKTHPimpinan()"
                class="flex items-center gap-2 px-6 py-3 bg-emerald-900 rounded-xl text-white hover:bg-emerald-800 transition shadow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                    </path>
                </svg>
                <span>Export Data</span>
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

        <!-- Filter Section -->
        <div class="bg-white rounded-3xl shadow-sm border border-stone-300/30 p-6">
            <form action="{{ route('pimpinan.kth.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <!-- Cari KTH -->
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-neutral-700 text-sm font-normal font-inter mb-2">
                        Cari KTH
                    </label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari KTH..."
                            class="w-full pl-12 pr-4 py-3 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] text-base focus:outline-none focus:ring-2 focus:ring-primary placeholder:text-gray-400">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Status Verifikasi -->
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-neutral-700 text-sm font-normal font-inter mb-2">
                        Status Verifikasi
                    </label>
                    <select name="status_verifikasi"
                        class="w-full px-4 py-3 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-base font-inter appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="verified" {{ request('status_verifikasi') == 'verified' ? 'selected' : '' }}>
                            Verified</option>
                        <option value="pending" {{ request('status_verifikasi') == 'pending' ? 'selected' : '' }}>
                            Menunggu</option>
                        <option value="rejected" {{ request('status_verifikasi') == 'rejected' ? 'selected' : '' }}>
                            Ditolak</option>
                    </select>
                </div>

                <!-- Status KTH -->
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-neutral-700 text-sm font-normal font-inter mb-2">
                        Status KTH
                    </label>
                    <select name="status_kth"
                        class="w-full px-4 py-3 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-base font-inter appearance-none cursor-pointer">
                        <option value="">Semua Kondisi</option>
                        <option value="Aktif" {{ request('status_kth') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ request('status_kth') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak
                            Aktif</option>
                    </select>
                </div>

                <!-- Kelas KTH -->
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-neutral-700 text-sm font-normal font-inter mb-2">
                        Kelas KTH
                    </label>
                    <select name="kelas_kth"
                        class="w-full px-4 py-3 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-base font-inter appearance-none cursor-pointer">
                        <option value="">Semua Kelas</option>
                        <option value="utama" {{ request('kelas_kth') == 'utama' ? 'selected' : '' }}>Utama</option>
                        <option value="madya" {{ request('kelas_kth') == 'madya' ? 'selected' : '' }}>Madya</option>
                        <option value="pemula" {{ request('kelas_kth') == 'pemula' ? 'selected' : '' }}>Pemula</option>
                    </select>
                </div>

                <!-- Kecamatan -->
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-neutral-700 text-sm font-normal font-inter mb-2">
                        Kecamatan
                    </label>
                    <select name="kecamatan"
                        class="w-full px-4 py-3 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-base font-inter appearance-none cursor-pointer">
                        <option value="">Semua Wilayah</option>
                        @foreach ($kecamatanList as $kec)
                            <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>
                                {{ $kec }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-end gap-3 min-w-[200px]">
                    <button type="submit"
                        class="px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-emerald-800 transition-colors whitespace-nowrap">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('pimpinan.kth.index') }}"
                        class="px-6 py-3 bg-gray-200 text-neutral-700 rounded-xl font-medium hover:bg-gray-300 transition-colors whitespace-nowrap">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-stone-300/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
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
                                <span
                                    class="text-primary text-sm font-bold font-inter uppercase tracking-wide">Detail</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kths as $kth)
                            <tr class="border-t border-stone-300/20 hover:bg-gray-50/50 transition-colors">
                                <!-- Nama KTH -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <div class="text-zinc-900 text-sm font-normal font-inter">
                                                {{ $kth->nama_kth }}
                                            </div>
                                            <div class="text-neutral-700 text-xs font-normal font-inter leading-4">
                                                Desa {{ $kth->desa }}, {{ $kth->kecamatan }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kelas -->
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
                                <td class="text-center text-centerpx-6 py-4">
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

                                <!-- Kecamatan -->
                                <td class="text-center px-6 py-4">
                                    <span
                                        class="text-neutral-700 text-sm font-normal font-inter">{{ $kth->kecamatan }}</span>
                                </td>

                                <!-- Detail -->
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center">
                                        <button type="button" onclick="openDetailKTHPimpinanModal({{ $kth->id }})"
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
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-base font-medium text-neutral-500">Tidak ada data KTH</span>
                                    </div>
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
                    Menampilkan <span class="font-semibold">{{ $kths->firstItem() ?? 0 }}</span>
                    dari <span class="font-semibold">{{ $kths->total() }}</span> KTH
                </div>
                <div>
                    {{ $kths->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    @include('components.modal.pimpinan.modal-detail-kth', ['kth' => $kth ?? null])

@endsection
