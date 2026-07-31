@extends('layouts.app')

@section('title', 'Dashboard Pimpinan')

@section('content')
    <div class="w-full space-y-6">
        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-semibold text-primary font-poppins">Selamat Datang, {{ Auth::user()->name }}</h1>
                <p class="text-base text-neutral-700 font-inter">Berikut ringkasan operasional sistem SI-KTH hari ini.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-4 py-2.5 bg-white rounded-xl shadow border border-stone-300">
                    <svg class="w-5 h-5 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="text-base text-zinc-900 font-inter">{{ now()->format('d M, Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Statistik Cards --}}
        <div class="grid grid-cols-4 gap-4">
            {{-- Total KTH --}}
            <div class="p-6 bg-white rounded-3xl border-l-4 border-blue-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <span class="icon-[material-symbols--forest-outline-rounded] w-6 h-6 bg-blue-600"></span>
                    </div>
                    <span class="text-blue-600 text-sm font-bold font-inter">Total KTH</span>
                </div>
                <div class="mt-4">
                    <p class="text-blue-600 text-sm font-semibold font-inter uppercase tracking-wide">Kelompok Tani Hutan
                    </p>
                    <p class="text-blue-600 text-3xl font-bold font-poppins">{{ number_format($totalKTH) }}</p>
                </div>
            </div>

            {{-- Laporan Verified --}}
            <div class="p-6 bg-white rounded-3xl border-l-4 border-green-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <span class="icon-[ix--success] w-6 h-6 bg-green-600"></span>
                    </div>
                    <span class="text-green-600 text-sm font-bold font-inter">Verified</span>
                </div>
                <div class="mt-4">
                    <p class="text-green-600 text-sm font-semibold font-inter uppercase tracking-wide">Laporan KTH</p>
                    <p class="text-green-600 text-3xl font-bold font-poppins">{{ number_format($laporanVerified) }}</p>
                </div>
            </div>

            {{-- Penyuluh --}}
            <div class="p-6 bg-white rounded-3xl border-l-4 border-amber-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <span class="icon-[mdi--people-outline] w-6 h-6 bg-amber-600"></span>
                    </div>
                    <span class="text-amber-600 text-sm font-bold font-inter">Total Penyuluh</span>
                </div>
                <div class="mt-4">
                    <p class="text-amber-600 text-sm font-semibold font-inter uppercase tracking-wide">Penyuluh</p>
                    <p class="text-amber-600 text-3xl font-bold font-poppins">{{ number_format($totalPenyuluh) }}</p>
                </div>
            </div>

            {{-- Average NTE --}}
            <div class="p-6 bg-white rounded-3xl border-l-4 border-purple-600 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)]">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <span class="icon-[f7--money-dollar-circle] w-6 h-6 bg-purple-600"></span>
                    </div>
                    <span class="text-purple-700 text-sm font-bold font-inter">Rata-rata NTE</span>
                </div>
                <div class="mt-4">
                    <p class="text-purple-600 text-sm font-semibold font-inter uppercase tracking-wide">Nilai Tambah
                        Ekonomi</p>
                    <p class="text-purple-600 text-3xl font-bold font-poppins">Rp {{ number_format($avgNTE, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Row 2: Map & Verification Status --}}
        <div class="grid grid-cols-3 gap-4">
            {{-- KTH Geographic Distribution --}}
            <div class="col-span-2 bg-white rounded-3xl shadow border border-stone-300/20 overflow-hidden">
                <div class="pt-6 pl-6 pr-6 pb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-zinc-900 text-xl font-bold font-poppins">Distribusi Geografis KTH</h2>
                            <p class="text-neutral-700 text-sm font-normal font-inter">Persebaran Kelompok Tani Hutan
                                berdasarkan wilayah</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="zoomInMap()"
                                class="w-10 h-10 rounded-lg border border-stone-300 flex items-center justify-center hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4">
                                    </path>
                                </svg>
                            </button>
                            <button onclick="zoomOutMap()"
                                class="w-10 h-10 pt-1.5 rounded-lg border border-stone-300 flex items-center justify-center hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16">
                                    </path>
                                </svg>
                            </button>
                            <button onclick="resetMapView()"
                                class="px-4 py-2 bg-emerald-900 rounded-lg text-white text-sm font-semibold font-inter hover:bg-emerald-800 transition">
                                Reset Peta
                            </button>
                        </div>
                    </div>
                    <div class="mt-4 rounded-xl overflow-hidden border border-stone-300">
                        <div id="pimpinanMapContainer" style="height: 250px; width: 100%;"></div>
                    </div>
                    <div class="mt-3 flex items-center gap-4 text-xs text-neutral-500">
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 bg-emerald-900 rounded-full"></span>
                            Verified
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                            Pending
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 bg-red-600 rounded-full"></span>
                            Rejected
                        </span>
                    </div>
                </div>
            </div>

            {{-- Status Verifikasi KTH --}}
            <div class="bg-white rounded-3xl shadow border border-stone-300/20 p-6">
                <h2 class="text-zinc-900 text-xl font-bold font-poppins">Status Verifikasi KTH</h2>
                <p class="text-neutral-700 text-sm font-normal font-inter mt-1">Ringkasan status verifikasi Kelompok
                    Tani
                    Hutan</p>

                <div class="mt-3 space-y-2">
                    {{-- Verified --}}
                    <div>
                        <div class="flex justify-between items-center">
                            <span class="text-emerald-900 text-sm font-bold font-inter">Verified</span>
                            <span class="text-emerald-900 text-sm font-bold font-inter">{{ $verifiedPercent }}%</span>
                        </div>
                        <div class="w-full h-3 bg-zinc-200 rounded-full overflow-hidden mt-1.5">
                            @if ($verifiedPercent > 0)
                                <div class="h-full bg-emerald-900 rounded-full transition-all duration-500"
                                    style="width: {{ $verifiedPercent }}%;"></div>
                            @else
                                <div class="h-full bg-emerald-900 rounded-full transition-all duration-500"
                                    style="width: 0%;"></div>
                            @endif
                        </div>
                        <div class="text-right text-[10px] text-neutral-400 mt-0.5">
                            {{ number_format($kthVerified) }} KTH
                        </div>
                    </div>

                    {{-- Pending --}}
                    <div>
                        <div class="flex justify-between items-center">
                            <span class="text-yellow-600 text-sm font-bold font-inter">Pending</span>
                            <span class="text-yellow-600 text-sm font-bold font-inter">{{ $pendingPercent }}%</span>
                        </div>
                        <div class="w-full h-3 bg-zinc-200 rounded-full overflow-hidden mt-1.5">
                            @if ($pendingPercent > 0)
                                <div class="h-full bg-yellow-600 rounded-full transition-all duration-500"
                                    style="width: {{ $pendingPercent }}%;"></div>
                            @else
                                <div class="h-full bg-yellow-600 rounded-full transition-all duration-500"
                                    style="width: 0%;">
                                </div>
                            @endif
                        </div>
                        <div class="text-right text-[10px] text-neutral-400 mt-0.5">
                            {{ number_format($kthPending) }} KTH
                        </div>
                    </div>

                    {{-- Rejected --}}
                    <div>
                        <div class="flex justify-between items-center">
                            <span class="text-red-700 text-sm font-bold font-inter">Rejected</span>
                            <span class="text-red-700 text-sm font-bold font-inter">{{ $rejectedPercent }}%</span>
                        </div>
                        <div class="w-full h-3 bg-zinc-200 rounded-full overflow-hidden mt-1.5">
                            @if ($rejectedPercent > 0)
                                <div class="h-full bg-red-700 rounded-full transition-all duration-500"
                                    style="width: {{ $rejectedPercent }}%;"></div>
                            @else
                                <div class="h-full bg-red-700 rounded-full transition-all duration-500"
                                    style="width: 0%;">
                                </div>
                            @endif
                        </div>
                        <div class="text-right text-[10px] text-neutral-400 mt-0.5">
                            {{ number_format($kthRejected) }} KTH
                        </div>
                    </div>
                </div>

                <div class="mt-2 pt-4 border-t border-stone-300">
                    <a href="{{ route('pimpinan.kth.index') }}"
                        class="w-full py-3 rounded-xl border-2 border-emerald-900 text-emerald-900 font-bold font-inter hover:bg-emerald-900 hover:text-white transition block text-center">
                        Lihat Semua KTH
                    </a>
                </div>
            </div>
        </div>

        {{-- Row 3: NTE Value Trend & KTH Class Distribution --}}
        <div class="grid grid-cols-3 gap-4">
            {{-- NTE Value Trend - Bar Chart --}}
            <div class="col-span-2 bg-white rounded-3xl shadow border border-stone-300/20 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-zinc-900 text-xl font-bold font-poppins">Total NTE per Bulan</h2>
                        <p class="text-neutral-700 text-sm font-normal font-inter">Total nilai tambah ekonomi per bulan</p>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- Dropdown Pilihan Tahun --}}
                        <div
                            class="flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-lg border border-stone-300 hover:bg-gray-100 transition min-w-[100px]">
                            <select id="yearSelect"
                                class="w-full bg-transparent text-zinc-900 text-sm font-semibold font-inter focus:outline-none cursor-pointer">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        {{-- Loading spinner --}}
                        <div id="loadingSpinner" class="hidden">
                            <svg class="w-5 h-5 text-emerald-900 animate-spin" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>


                <div class="mt-4 h-64 relative" id="chartContainer">
                    {{-- Chart akan di-render di sini oleh JavaScript --}}
                    <div id="chartContent" class="absolute inset-0">
                        @include('pimpinan.chart-content')
                    </div>
                </div>

                {{-- Legend --}}
                <div class="grid grid-cols-2 mt-2 text-xs text-neutral-500">
                    <span class="flex gap-1.5">
                        <span class="w-4 h-4 rounded bg-emerald-900"></span>
                        Total NTE
                    </span>
                    <span class="flex justify-end gap-1.5 text-neutral-400">
                        <span class="text-[10px] text-end">* Hover pada batang untuk melihat detail</span>
                    </span>
                    <span class="flex items-center gap-1.5 text-emerald-700" id="yearInfo">
                        @if ($selectedYear != now()->year)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                            <span class="text-[10px] font-medium">Menampilkan data tahun {{ $selectedYear }}</span>
                        @endif
                    </span>
                </div>
            </div>

            {{-- Status Verifikasi Laporan --}}
            <div class="bg-white rounded-3xl shadow border border-stone-300/20 p-6">
                <h2 class="text-zinc-900 text-xl font-bold font-poppins">Status Verifikasi Laporan</h2>
                <p class="text-neutral-700 text-sm font-normal font-inter mt-1">Ringkasan status verifikasi laporan KTH
                </p>

                <div class="mt-3 space-y-2">
                    {{-- Verified --}}
                    <div>
                        <div class="flex justify-between items-center">
                            <span class="text-emerald-900 text-sm font-bold font-inter">Verified</span>
                            <span
                                class="text-emerald-900 text-sm font-bold font-inter">{{ $laporanVerifiedPercent }}%</span>
                        </div>
                        <div class="w-full h-3 bg-zinc-200 rounded-full overflow-hidden mt-1.5">
                            @if ($laporanVerifiedPercent > 0)
                                <div class="h-full bg-emerald-900 rounded-full transition-all duration-500"
                                    style="width: {{ $laporanVerifiedPercent }}%;"></div>
                            @else
                                <div class="h-full bg-emerald-900 rounded-full transition-all duration-500"
                                    style="width: 0%;"></div>
                            @endif
                        </div>
                        <div class="text-right text-[10px] text-neutral-400 mt-0.5">
                            {{ number_format($laporanVerified) }} laporan
                        </div>
                    </div>

                    {{-- Pending --}}
                    <div>
                        <div class="flex justify-between items-center">
                            <span class="text-yellow-600 text-sm font-bold font-inter">Pending</span>
                            <span
                                class="text-yellow-600 text-sm font-bold font-inter">{{ $laporanPendingPercent }}%</span>
                        </div>
                        <div class="w-full h-3 bg-zinc-200 rounded-full overflow-hidden mt-1.5">
                            @if ($laporanPendingPercent > 0)
                                <div class="h-full bg-yellow-600 rounded-full transition-all duration-500"
                                    style="width: {{ $laporanPendingPercent }}%;"></div>
                            @else
                                <div class="h-full bg-yellow-600 rounded-full transition-all duration-500"
                                    style="width: 0%;">
                                </div>
                            @endif
                        </div>
                        <div class="text-right text-[10px] text-neutral-400 mt-0.5">
                            {{ number_format($laporanPending) }} laporan
                        </div>
                    </div>

                    {{-- Rejected --}}
                    <div>
                        <div class="flex justify-between items-center">
                            <span class="text-red-700 text-sm font-bold font-inter">Rejected</span>
                            <span class="text-red-700 text-sm font-bold font-inter">{{ $laporanRejectedPercent }}%</span>
                        </div>
                        <div class="w-full h-3 bg-zinc-200 rounded-full overflow-hidden mt-1.5">
                            @if ($laporanRejectedPercent > 0)
                                <div class="h-full bg-red-700 rounded-full transition-all duration-500"
                                    style="width: {{ $laporanRejectedPercent }}%;"></div>
                            @else
                                <div class="h-full bg-red-700 rounded-full transition-all duration-500"
                                    style="width: 0%;">
                                </div>
                            @endif
                        </div>
                        <div class="text-right text-[10px] text-neutral-400 mt-0.5">
                            {{ number_format($laporanRejected) }} laporan
                        </div>
                    </div>
                </div>

                <div class="mt-2 pt-4 border-t border-stone-300">
                    <a href="{{ route('pimpinan.laporan.index') }}"
                        class="w-full py-3 rounded-xl border-2 border-emerald-900 text-emerald-900 font-bold font-inter hover:bg-emerald-900 hover:text-white transition block text-center">
                        Lihat Semua Laporan
                    </a>
                </div>
            </div>


        </div>

        {{-- Row 3: KTH Class Distribution & KTH Paling Aktif --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-3xl shadow border border-stone-300/20 p-6 flex flex-col">
                {{-- Header --}}
                <div class="text-center">
                    <h2 class="text-zinc-900 text-xl font-bold font-poppins">Distribusi Kelas KTH</h2>
                    <p class="text-neutral-700 text-sm font-normal font-inter">Klasifikasi kelompok tani hutan</p>
                </div>

                {{-- Donut Chart --}}
                <div class="flex flex-col items-center mt-4">
                    <div class="relative w-48 h-48">
                        <svg viewBox="0 0 120 120" class="w-full h-full -rotate-90">
                            {{-- Background circle (total) --}}
                            <circle cx="60" cy="60" r="48" fill="none" stroke="#f3f4f6"
                                stroke-width="16" />

                            {{-- Pemula --}}
                            @if ($kelasPemulaPercent > 0)
                                <circle cx="60" cy="60" r="48" fill="none" stroke="#2B644A"
                                    stroke-width="16"
                                    stroke-dasharray="{{ $kelasPemulaPercent }} {{ 100 - $kelasPemulaPercent }}"
                                    stroke-dashoffset="0" class="transition-all duration-1000 ease-out" />
                            @endif

                            {{-- Madya --}}
                            @if ($kelasMadyaPercent > 0)
                                <circle cx="60" cy="60" r="48" fill="none" stroke="#2563EB"
                                    stroke-width="16"
                                    stroke-dasharray="{{ $kelasMadyaPercent }} {{ 100 - $kelasMadyaPercent }}"
                                    stroke-dashoffset="-{{ $kelasPemulaPercent }}"
                                    class="transition-all duration-1000 ease-out" />
                            @endif

                            {{-- Utama --}}
                            @if ($kelasUtamaPercent > 0)
                                <circle cx="60" cy="60" r="48" fill="none" stroke="#DC2626"
                                    stroke-width="16"
                                    stroke-dasharray="{{ $kelasUtamaPercent }} {{ 100 - $kelasUtamaPercent }}"
                                    stroke-dashoffset="-{{ $kelasPemulaPercent + $kelasMadyaPercent }}"
                                    class="transition-all duration-1000 ease-out" />
                            @endif
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span
                                class="text-zinc-900 text-2xl font-bold font-inter">{{ number_format($totalKTH) }}</span>
                            <span
                                class="text-neutral-400 text-[10px] font-semibold font-inter uppercase tracking-wider">Total
                                KTH</span>
                        </div>
                    </div>
                </div>

                {{-- Legend dengan Progress Bar --}}
                <div class="w-full mt-5 space-y-3">
                    {{-- Pemula --}}
                    <div class="group">
                        <div class="flex justify-between items-center mb-1">
                            <div class="flex items-center gap-2.5">
                                <span class="w-3 h-3 bg-primary rounded-full flex-shrink-0"></span>
                                <span class="text-zinc-700 text-sm font-medium font-inter">Pemula</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-zinc-900 text-sm font-bold font-inter">{{ $kelasPemulaPercent }}%</span>
                                <span class="text-neutral-400 text-[10px] font-medium">({{ number_format($kelasPemula) }}
                                    KTH)</span>
                            </div>
                        </div>
                        <div class="w-full h-2.5 bg-zinc-100 rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full transition-all duration-1000 ease-out"
                                style="width: {{ $kelasPemulaPercent }}%;"></div>
                        </div>
                    </div>

                    {{-- Madya --}}
                    <div class="group">
                        <div class="flex justify-between items-center mb-1">
                            <div class="flex items-center gap-2.5">
                                <span class="w-3 h-3 bg-blue-600 rounded-full flex-shrink-0"></span>
                                <span class="text-zinc-700 text-sm font-medium font-inter">Madya</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-zinc-900 text-sm font-bold font-inter">{{ $kelasMadyaPercent }}%</span>
                                <span class="text-neutral-400 text-[10px] font-medium">({{ number_format($kelasMadya) }}
                                    KTH)</span>
                            </div>
                        </div>
                        <div class="w-full h-2.5 bg-zinc-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full transition-all duration-1000 ease-out"
                                style="width: {{ $kelasMadyaPercent }}%;"></div>
                        </div>
                    </div>

                    {{-- Utama --}}
                    <div class="group">
                        <div class="flex justify-between items-center mb-1">
                            <div class="flex items-center gap-2.5">
                                <span class="w-3 h-3 bg-red-600 rounded-full flex-shrink-0"></span>
                                <span class="text-zinc-700 text-sm font-medium font-inter">Utama</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-zinc-900 text-sm font-bold font-inter">{{ $kelasUtamaPercent }}%</span>
                                <span class="text-neutral-400 text-[10px] font-medium">({{ number_format($kelasUtama) }}
                                    KTH)</span>
                            </div>
                        </div>
                        <div class="w-full h-2.5 bg-zinc-100 rounded-full overflow-hidden">
                            <div class="h-full bg-red-600 rounded-full transition-all duration-1000 ease-out"
                                style="width: {{ $kelasUtamaPercent }}%;"></div>
                        </div>
                    </div>
                </div>

                {{-- Footer / Tombol --}}
                <div class="mt-5 pt-4 border-t border-stone-300">
                    <a href="{{ route('pimpinan.kth.index') }}"
                        class="w-full py-2.5 rounded-xl border-2 border-emerald-900 text-emerald-900 font-bold font-inter hover:bg-emerald-900 hover:text-white transition block text-center text-sm">
                        Lihat Semua KTH
                    </a>
                </div>
            </div>

            {{-- KTH Paling Aktif Melaporkan --}}
            <div class="bg-white rounded-3xl shadow border border-stone-300/20 p-6 flex flex-col h-full">
                <div>
                    <h2 class="text-center text-zinc-900 text-xl font-bold font-poppins">KTH Paling Aktif</h2>
                    <p class="text-center text-neutral-700 text-sm font-normal font-inter">KTH dengan laporan terbanyak</p>
                </div>

                <div class="mt-4 space-y-3 flex-1">
                    @php
                        $rankings = [];
                        for ($i = 0; $i < 5; $i++) {
                            $rankings[$i] = $kthPalingAktif[$i] ?? null;
                        }
                    @endphp

                    @foreach ($rankings as $index => $item)
                        <div
                            class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-stone-200 hover:bg-gray-100 transition">
                            {{-- Peringkat --}}
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center text-center text-sm font-bold flex-shrink-0
                    {{ $index == 0 ? 'bg-yellow-400 text-yellow-900' : '' }}
                    {{ $index == 1 ? 'bg-gray-300 text-gray-700' : '' }}
                    {{ $index == 2 ? 'bg-amber-600 text-white' : '' }}
                    {{ $index >= 3 ? 'bg-emerald-100 text-emerald-700' : '' }}">
                                {{ $index + 1 }}
                            </div>

                            {{-- Nama KTH --}}
                            <div class="flex-1 min-w-0">
                                @if ($item)
                                    <p class="text-zinc-900 text-base font-semibold font-inter truncate">
                                        {{ $item->nama_kth }}
                                    </p>
                                @else
                                    <p class="text-neutral-400 text-base font-medium font-inter">-</p>
                                @endif
                            </div>

                            {{-- Jumlah Laporan --}}
                            <div class="flex items-center gap-1 flex-shrink-0">
                                @if ($item)
                                    <span
                                        class="text-emerald-900 text-base font-bold font-inter">{{ $item->jumlah_laporan }}</span>
                                    <span class="text-neutral-400 text-xs font-medium">laporan</span>
                                @else
                                    <span class="text-neutral-400 text-base font-medium">-</span>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    @if ($kthPalingAktif->isEmpty())
                        <div class="text-center text-neutral-500 py-2">
                            <p class="text-sm font-medium">Belum ada laporan</p>
                        </div>
                    @endif
                </div>

                {{-- Tombol --}}
                <div class="pt-3 border-t border-stone-300 mt-auto">
                    <a href="{{ route('pimpinan.laporan.index') }}"
                        class="w-full py-3 rounded-xl border-2 border-emerald-900 text-emerald-900 font-bold font-inter hover:bg-emerald-900 hover:text-white transition block text-center text-sm">
                        Lihat Semua Laporan
                    </a>
                </div>
            </div>
        </div>

        {{-- Critical Regional Updates --}}
        <div class="bg-white rounded-3xl shadow border border-stone-300/20 overflow-hidden">
            <div class="px-6 py-4 border-b border-stone-300">
                <h2 class="text-zinc-900 text-xl font-bold font-poppins">Update Terbaru</h2>
            </div>

            <div class="p-6 space-y-4">
                @php
                    $limitedUpdates = array_slice($updates, 0, 10);
                @endphp
                @forelse($limitedUpdates as $update)
                    <div class="flex items-start gap-4 pb-4 border-b border-stone-300 last:border-0">
                        {{-- Icon --}}
                        <div
                            class="w-10 h-10 {{ $update['icon_class'] }} rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 {{ $update['icon_color'] }}" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                {!! $update['icon_svg'] !!}
                            </svg>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1">
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <span class="text-zinc-900 text-base font-bold font-inter">{{ $update['title'] }}</span>
                                <span
                                    class="text-neutral-700 text-xs font-medium font-inter whitespace-nowrap">{{ $update['time'] }}</span>
                            </div>
                            <p class="text-neutral-700 text-sm font-normal font-inter mt-1">
                                {{ $update['description'] }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-neutral-500 py-6">
                        <p class="text-sm font-medium">Belum ada update terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // ============================================
            // MAP UNTUK PIMPINAN DASHBOARD
            // ============================================
            let pimpinanMap = null;
            let pimpinanMarkers = [];

            function initPimpinanMap() {
                const container = document.getElementById('pimpinanMapContainer');
                if (!container) {
                    console.error('Map container not found');
                    return;
                }

                if (pimpinanMap) {
                    pimpinanMap.remove();
                    pimpinanMap = null;
                    pimpinanMarkers = [];
                }

                const defaultLat = -2.5;
                const defaultLng = 118.0;
                const defaultZoom = 5;

                pimpinanMap = L.map(container, {
                    center: [defaultLat, defaultLng],
                    zoom: defaultZoom,
                    zoomControl: false,
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    maxZoom: 19,
                }).addTo(pimpinanMap);

                const url = '/pimpinan/kth/map-data';
                console.log('Fetching map data from:', url);

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('HTTP error! status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Map data loaded:', data.length, 'KTH locations');

                        if (!data || data.length === 0) {
                            const message = L.control({
                                position: 'bottomleft'
                            });
                            message.onAdd = function() {
                                const div = L.DomUtil.create('div',
                                    'bg-white px-4 py-2 rounded-lg shadow text-sm text-neutral-500');
                                div.innerHTML = 'Belum ada data lokasi KTH';
                                return div;
                            };
                            message.addTo(pimpinanMap);
                            return;
                        }

                        // 🏠 Buat custom icon untuk setiap status
                        function createCustomIcon(color, status) {
                            const svgTemplate = `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32">
                        <path fill="${color}" stroke="#FFFFFF" stroke-width="1.5" 
                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        ${status === 'verified' ? '<circle cx="17" cy="7" r="5" fill="#0E4C34" stroke="white" stroke-width="1.5"/>' : ''}
                        ${status === 'verified' ? '<path d="M15 7l2 2 4-4" stroke="white" stroke-width="2" fill="none"/>' : ''}
                        ${status === 'pending' ? '<circle cx="17" cy="7" r="5" fill="#EAB308" stroke="white" stroke-width="1.5"/>' : ''}
                        ${status === 'pending' ? '<path d="M17 5v4M15 7h4" stroke="white" stroke-width="2" fill="none"/>' : ''}
                        ${status === 'rejected' ? '<circle cx="17" cy="7" r="5" fill="#DC2626" stroke="white" stroke-width="1.5"/>' : ''}
                        ${status === 'rejected' ? '<path d="M14 4l6 6M20 4l-6 6" stroke="white" stroke-width="2" fill="none"/>' : ''}
                    </svg>
                `;

                            return L.icon({
                                iconUrl: 'data:image/svg+xml;base64,' + btoa(svgTemplate),
                                iconSize: [32, 32],
                                iconAnchor: [16, 32],
                                popupAnchor: [0, -32],
                            });
                        }

                        // Tambahkan marker untuk setiap KTH
                        data.forEach(location => {
                            if (location.latitude && location.longitude) {
                                let icon;
                                if (location.status_verifikasi === 'verified') {
                                    icon = createCustomIcon('#0E4C34', 'verified');
                                } else if (location.status_verifikasi === 'rejected') {
                                    icon = createCustomIcon('#DC2626', 'rejected');
                                } else {
                                    icon = createCustomIcon('#EAB308', 'pending');
                                }

                                const marker = L.marker([parseFloat(location.latitude), parseFloat(location
                                    .longitude)], {
                                    icon: icon,
                                    riseOnHover: true,
                                }).addTo(pimpinanMap);

                                pimpinanMarkers.push(marker);

                                // Popup
                                const statusBadge = location.status_verifikasi === 'verified' ?
                                    'bg-green-100 text-green-800' :
                                    location.status_verifikasi === 'rejected' ? 'bg-red-100 text-red-800' :
                                    'bg-yellow-100 text-yellow-800';

                                const statusText = location.status_verifikasi === 'verified' ? 'Verified' :
                                    location.status_verifikasi === 'rejected' ? 'Rejected' :
                                    'Pending';

                                marker.bindPopup(`
                        <div class="min-w-[220px] p-2">
                            <p class="font-bold text-zinc-900 text-base">${location.nama_kth || 'KTH'}</p>
                            <p class="text-xs text-neutral-500 mt-0.5">📍 ${location.desa || ''}, ${location.kecamatan || ''}</p>
                            <div class="mt-2 space-y-1">
                                <p class="text-xs text-neutral-500">
                                    <span class="font-semibold">Kelas:</span> ${location.kelas_kth || '-'}
                                </p>
                                <p class="text-xs text-neutral-500">
                                    <span class="font-semibold">Status:</span> 
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${statusBadge}">
                                        ${statusText}
                                    </span>
                                </p>
                            </div>
                            <hr class="my-2">
                            <a href="#" class="text-emerald-900 text-xs font-medium hover:underline block text-center">
                                🔍 Lihat Detail KTH
                            </a>
                        </div>
                    `);
                            }
                        });

                        // Fit bounds
                        if (pimpinanMarkers.length > 0) {
                            const group = L.featureGroup(pimpinanMarkers);
                            pimpinanMap.fitBounds(group.getBounds(), {
                                padding: [50, 50]
                            });
                        }

                        // Legend
                        const legend = L.control({
                            position: 'bottomright'
                        });
                        legend.onAdd = function() {
                            const div = L.DomUtil.create('div',
                                'bg-white rounded-lg shadow-lg p-3 border border-stone-200');
                            div.innerHTML = `
                    <p class="text-xs font-bold text-zinc-900 mb-2">Status Verifikasi</p>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="w-4 h-4 bg-[#0E4C34] rounded-full"></span>
                        <span class="text-xs text-neutral-600">Verified</span>
                    </div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="w-4 h-4 bg-yellow-500 rounded-full"></span>
                        <span class="text-xs text-neutral-600">Pending</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 bg-red-600 rounded-full"></span>
                        <span class="text-xs text-neutral-600">Rejected</span>
                    </div>
                `;
                            return div;
                        };
                        legend.addTo(pimpinanMap);

                        setTimeout(() => {
                            if (pimpinanMap) {
                                pimpinanMap.invalidateSize();
                            }
                        }, 500);
                    })
                    .catch(error => {
                        console.error('Error loading map data:', error);
                        const errorMessage = L.control({
                            position: 'bottomleft'
                        });
                        errorMessage.onAdd = function() {
                            const div = L.DomUtil.create('div',
                                'bg-red-50 px-4 py-2 rounded-lg shadow text-sm text-red-600 border border-red-200');
                            div.innerHTML = 'Gagal memuat data lokasi KTH';
                            return div;
                        };
                        errorMessage.addTo(pimpinanMap);
                    });
            }

            function zoomInMap() {
                if (pimpinanMap) {
                    pimpinanMap.zoomIn();
                }
            }

            function zoomOutMap() {
                if (pimpinanMap) {
                    pimpinanMap.zoomOut();
                }
            }

            function resetMapView() {
                if (pimpinanMap) {
                    pimpinanMap.setView([-2.5, 118.0], 5);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    initPimpinanMap();
                }, 500);

                window.addEventListener('resize', function() {
                    if (pimpinanMap) {
                        setTimeout(function() {
                            pimpinanMap.invalidateSize();
                        }, 300);
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                const yearSelect = document.getElementById('yearSelect');
                const chartContent = document.getElementById('chartContent');
                const loadingSpinner = document.getElementById('loadingSpinner');
                const yearInfo = document.getElementById('yearInfo');
                const chartSatuan = document.getElementById('chartSatuan');
                const legendSatuan = document.getElementById('legendSatuan');

                const currentYearNow = {{ now()->year }};

                // Event listener untuk change dropdown
                yearSelect.addEventListener('change', function() {
                    const selectedYear = this.value;

                    // Tampilkan loading
                    loadingSpinner.classList.remove('hidden');
                    chartContent.style.opacity = '0.5';

                    // Kirim request AJAX
                    fetch(`/pimpinan/chart-data?year=${selectedYear}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update chart
                                renderChart(data.data);

                                // Update info tahun
                                if (selectedYear != currentYearNow) {
                                    yearInfo.innerHTML = `
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                        </svg>
                        <span class="text-[10px] font-medium">Menampilkan data tahun ${selectedYear}</span>
                    `;
                                } else {
                                    yearInfo.innerHTML = '';
                                }

                                // Update satuan
                                const satuanText = data.data.satuan ? data.data.satuan + ' ' : '';
                                if (chartSatuan) chartSatuan.textContent = satuanText;
                                if (legendSatuan) legendSatuan.textContent = satuanText;
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching chart data:', error);
                            // Tampilkan pesan error
                            chartContent.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full">
                    <svg class="w-16 h-16 text-red-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-red-500 text-sm font-medium">Gagal memuat data</p>
                    <p class="text-neutral-400 text-xs mt-1">Silakan coba lagi</p>
                </div>
            `;
                        })
                        .finally(() => {
                            // Sembunyikan loading
                            loadingSpinner.classList.add('hidden');
                            chartContent.style.opacity = '1';
                        });
                });

                function renderChart(data) {
                    const {
                        trend,
                        max,
                        months,
                        satuan,
                        hasData,
                        year
                    } = data;

                    // Buat HTML untuk chart
                    let html = '';

                    if (hasData) {
                        const roundedMax = Math.ceil(max / 10) * 10 || 10;

                        // Chart bars
                        html += `<div class="flex items-end justify-between px-2 pb-6 h-full">`;

                        months.forEach((month, index) => {
                            const value = trend[index] || 0;
                            const height = max > 0 ? Math.max(8, (value / max) * 85) : 0;
                            const isZero = value == 0;

                            let displayValue = value;
                            if (satuan === 'Jt') {
                                displayValue = Number(value).toFixed(1) + 'Jt';
                            } else if (satuan === 'K') {
                                displayValue = Number(value).toFixed(1) + 'K';
                            } else {
                                displayValue = Number(value).toLocaleString('id-ID');
                            }

                            html += `
                    <div class="flex flex-col items-center" style="width: 8.33%;">
                        ${value > 0 ? 
                            `<span class="text-[9px] font-bold text-emerald-900 mb-1">${displayValue}</span>` : 
                            `<span class="text-[9px] text-gray-300 mb-1">-</span>`
                        }
                        <div class="w-8 rounded-t-lg transition-all duration-500 hover:opacity-80 cursor-pointer relative group"
                            style="height: ${height}%; min-height: ${value > 0 ? '6px' : '4px'}; 
                            background: ${isZero ? '#f3f4f6' : 'linear-gradient(180deg, #0E4C34 0%, #1a7a4a 100%)'};">
                            ${value > 0 ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-1.5 bg-zinc-800 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap pointer-events-none z-10 shadow-lg">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <span class="font-bold">${month} ${year}</span><br>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            Rp ${Number(value * (satuan === 'Jt' ? 1000000 : (satuan === 'K' ? 1000 : 1))).toLocaleString('id-ID')}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ` : ''}
                        </div>
                        <span class="text-neutral-500 text-[10px] font-medium mt-1.5">${month}</span>
                    </div>
                `;
                        });

                        html += `</div>`;

                        // Y-axis labels
                        html +=
                            `<div class="absolute left-0 top-0 flex flex-col justify-between h-full text-[10px] text-neutral-400 pb-6 pointer-events-none">`;

                        const labels = [roundedMax, roundedMax * 0.75, roundedMax * 0.5, roundedMax * 0.25, 0];
                        labels.forEach(label => {
                            let displayLabel = label;
                            if (satuan === 'Jt') {
                                displayLabel = Number(label).toFixed(1) + 'Jt';
                            } else if (satuan === 'K') {
                                displayLabel = Number(label).toFixed(1) + 'K';
                            } else {
                                displayLabel = Number(label).toLocaleString('id-ID');
                            }
                            html += `<span>${displayLabel}</span>`;
                        });

                        html += `</div>`;
                    } else {
                        // No data
                        html = `
                <div class="flex flex-col items-center justify-center h-full">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-neutral-500 text-sm font-medium">Belum ada data NTE untuk tahun ${year}</p>
                    <p class="text-neutral-400 text-xs mt-1">Pilih tahun lain untuk melihat data</p>
                </div>
            `;
                    }

                    chartContent.innerHTML = html;
                }
            });
        </script>
    @endpush
@endsection
