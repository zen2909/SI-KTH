@extends('layouts.app')

@section('title', 'Dashboard Penyuluh')

@section('content')
    <div class="w-full space-y-6">
        {{-- Judul --}}
        <div class="mb-2">
            <h1 class="text-2xl font-bold text-primary font-poppins">
                Selamat datang, {{ Auth::user()->penyuluh->nama_lengkap }}
            </h1>
            <p class="text-sm text-primary font-semibold font-normal mt-1">
                Pantau aktivitas KTH binaan Anda dan kelola laporan terbaru di sini.
            </p>
        </div>

        {{-- Kartu Statistik - Row 1: Total KTH & Total Laporan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Total KTH --}}
            <div class="bg-white rounded-lg shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center bg-[#0e4c341a] rounded px-2 py-1">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-normal text-primary bg-[#0e4c341a] rounded-full px-2 py-0.5">
                        {{ $totalKTH > 0 ? '+12%' : '0%' }}
                    </span>
                </div>
                <div class="mt-2 text-sm font-normal text-primary font-semibold">TOTAL KTH</div>
                <div class="text-2xl font-semibold text-primary">{{ $totalKTH }}</div>
            </div>

            {{-- Total Laporan --}}
            <div class="bg-white rounded-lg shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center bg-[#4b5e551a] rounded px-2 py-1">
                        <svg class="w-4 h-4 text-[#4b5e55]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-normal text-[#191c1d] bg-[#4b5e551a] rounded-full px-2 py-0.5">
                        {{ $totalLaporan > 0 ? '+8%' : '0%' }}
                    </span>
                </div>
                <div class="mt-2 text-sm font-normal text-primary font-semibold">TOTAL LAPORAN</div>
                <div class="text-2xl font-semibold text-[#191c1d]">{{ $totalLaporan }}</div>
            </div>
        </div>

        {{-- Kartu Statistik - Row 2: Pending, Verified, Rejected (UNTUK LAPORAN) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Pending Laporan --}}
            <div class="bg-white rounded-lg shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center bg-yellow-50 rounded px-2 py-1">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-normal text-yellow-700 bg-yellow-100 rounded-full px-2 py-0.5">Action
                        Required</span>
                </div>
                <div class="mt-2 text-sm font-normal text-primary font-semibold">PENDING LAPORAN</div>
                <div class="text-2xl font-semibold text-yellow-600">{{ $pendingLaporan }}</div>
            </div>

            {{-- Verified Laporan --}}
            <div class="bg-white rounded-lg shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center bg-[#0e4c341a] rounded px-2 py-1">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-normal text-primary bg-[#0e4c341a] rounded-full px-2 py-0.5">
                        {{ $totalLaporan > 0 ? round(($verifiedLaporan / $totalLaporan) * 100) . '% success' : '0%' }}
                    </span>
                </div>
                <div class="mt-2 text-sm font-normal text-primary font-semibold">VERIFIED LAPORAN</div>
                <div class="text-2xl font-semibold text-primary">{{ $verifiedLaporan }}</div>
            </div>

            {{-- Rejected Laporan --}}
            <div class="bg-white rounded-lg shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center bg-[#ffdad633] rounded px-2 py-1">
                        <svg class="w-4 h-4 text-[#ba1a1a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-normal text-[#ba1a1a] bg-[#ffdad633] rounded-full px-2 py-0.5">
                        {{ $totalLaporan > 0 ? '-' . round(($rejectedLaporan / $totalLaporan) * 100) . '%' : '0%' }}
                    </span>
                </div>
                <div class="mt-2 text-sm font-normal text-primary font-semibold">REJECTED LAPORAN</div>
                <div class="text-2xl font-semibold text-[#ba1a1a]">{{ $rejectedLaporan }}</div>
            </div>
        </div>

        {{-- Grafik: Distribusi Status KTH & Grafik Status Laporan --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            {{-- Distribusi Status KTH (kiri) --}}
            <div class="bg-white rounded-2xl shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-primary">Distribusi Status KTH</h2>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                        </path>
                    </svg>
                </div>
                <div class="flex flex-col md:flex-row items-center gap-4 mt-4">
                    {{-- Donut chart --}}
                    <div class="relative w-48 h-48">
                        {{-- Teks di tengah --}}
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl font-bold text-primary leading-none">{{ $totalKTH }}</span>
                            <span class="text-md font-inter text-primary font-semibold tracking-widest mt-0.5">TOTAL</span>
                        </div>
                        <svg viewBox="0 0 120 120" class="w-full h-full -rotate-90">
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#e5e7eb"
                                stroke-width="12" />
                            @php
                                $verifiedDash = $verifiedPercent . ' ' . (100 - $verifiedPercent);
                                $pendingDash = $pendingPercent . ' ' . (100 - $pendingPercent);
                                $rejectedDash = $rejectedPercent . ' ' . (100 - $rejectedPercent);
                            @endphp
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#0e4c34" stroke-width="12"
                                stroke-dasharray="{{ $verifiedDash }}" stroke-dashoffset="0" />
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#eab308"
                                stroke-width="12" stroke-dasharray="{{ $pendingDash }}"
                                stroke-dashoffset="-{{ $verifiedPercent }}" />
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#ba1a1a"
                                stroke-width="12" stroke-dasharray="{{ $rejectedDash }}"
                                stroke-dashoffset="-{{ $verifiedPercent + $pendingPercent }}" />
                        </svg>
                    </div>
                    {{-- Legend + progress --}}
                    <div class="flex-1 space-y-2">
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-[#191c1d]">Verified</span>
                                <span class="text-xs text-primary font-semibold">{{ $verifiedPercent }}%
                                    ({{ $verifiedKTH }}
                                    KTH)</span>
                            </div>
                            <div class="w-full h-3 bg-gray-200 rounded-full">
                                <div class="h-3 bg-primary rounded-full" style="width:{{ $verifiedPercent }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-[#191c1d]">Pending</span>
                                <span class="text-xs text-primary font-semibold">{{ $pendingPercent }}%
                                    ({{ $pendingKTH }}
                                    KTH)</span>
                            </div>
                            <div class="w-full h-3 bg-gray-200 rounded-full">
                                <div class="h-3 bg-yellow-500 rounded-full" style="width:{{ $pendingPercent }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-[#191c1d]">Rejected</span>
                                <span class="text-xs text-primary font-semibold">{{ $rejectedPercent }}%
                                    ({{ $rejectedKTH }}
                                    KTH)</span>
                            </div>
                            <div class="w-full h-3 bg-gray-200 rounded-full">
                                <div class="h-3 bg-[#ba1a1a] rounded-full" style="width:{{ $rejectedPercent }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grafik Status Laporan (kanan) --}}
            <div class="bg-white rounded-2xl shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-primary">Grafik Laporan per Bulan</h2>
                    <span
                        class="text-xs font-normal text-primary bg-[#0e4c341a] rounded-full border border-[#0e4c3433] px-3 py-1">{{ now()->year }}</span>
                </div>
                <div class="mt-4">
                    <div class="relative h-64">
                        <div class="absolute inset-0 flex items-end justify-around">
                            @foreach ($chartData['labels'] as $index => $label)
                                @php
                                    $value = $chartData['data'][$index] ?? 0;
                                    $maxValue = $chartData['maxValue'] > 0 ? $chartData['maxValue'] : 1;
                                    $height = max(5, ($value / $maxValue) * 100);
                                @endphp
                                <div class="flex flex-col items-center" style="width: 8.33%;">
                                    <div class="w-6 bg-primary rounded-t"
                                        style="height: {{ $height }}%; min-height: {{ $value > 0 ? '4px' : '0' }};">
                                    </div>
                                    <span class="text-[10px] text-[#404943] mt-1">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                        {{-- Garis bantu --}}
                        <div class="absolute inset-x-0 top-0 border-t border-[#e1e3e41a]"></div>
                        <div class="absolute inset-x-0 top-1/3 border-t border-[#e1e3e41a]"></div>
                        <div class="absolute inset-x-0 top-2/3 border-t border-[#e1e3e41a]"></div>
                        <div class="absolute left-0 top-0 flex flex-col justify-between h-full text-[10px] text-[#404943]">
                            <span>{{ $chartData['maxValue'] }}</span>
                            <span>{{ round($chartData['maxValue'] * 0.66) }}</span>
                            <span>{{ round($chartData['maxValue'] * 0.33) }}</span>
                            <span>0</span>
                        </div>
                    </div>
                    {{-- Legend --}}
                    <div class="flex items-center gap-4 mt-2 text-xs text-[#404943]">
                        <span class="flex items-center"><span
                                class="inline-block w-3 h-3 bg-primary rounded-sm mr-1"></span> Jumlah Laporan
                            Terverifikasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
