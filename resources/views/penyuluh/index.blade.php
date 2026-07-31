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

        {{-- Baris 1: 2 Kartu (Total KTH, Total Laporan) --}}
        <div class="grid grid-cols-2 gap-4">
            {{-- Total KTH - ROSE/RED --}}
            <div class="p-6 bg-white rounded-3xl shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)] border-l-4 border-l-blue-600">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <span class="text-blue-600 text-sm font-inter bg-blue-100 rounded-full px-2 py-1">Total
                        keseluruhan</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-tight">Total KTH</p>
                    <p class="text-3xl font-bold text-blue-600">{{ number_format($totalKTH) }}</p>
                </div>
            </div>

            {{-- Total Laporan - PURPLE --}}
            <div class="p-6 bg-white rounded-3xl shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)] border-l-4 border-l-blue-600">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-blue-600 text-sm font-inter bg-blue-100 rounded-full px-2 py-1">Total
                        keseluruhan</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-tight">Total Laporan</p>
                    <p class="text-3xl font-bold text-blue-600">{{ number_format($totalLaporan) }}</p>
                </div>
            </div>
        </div>

        {{-- Baris 2: 4 Kartu (KTH Pending, KTH Verified, Laporan Pending, Laporan Verified) --}}
        <div class="grid grid-cols-4 gap-4 mt-4">
            {{-- KTH Pending - AMBER --}}
            <div class="p-6 bg-white rounded-3xl shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)] border-l-4 border-l-amber-500">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-amber-100 rounded-xl">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-amber-600 text-sm font-inter bg-amber-100 rounded-full px-2 py-1">Menunggu
                        verifikasi</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-tight">KTH Pending</p>
                    <p class="text-3xl font-bold text-amber-600">{{ number_format($pendingKTH) }}</p>
                </div>
            </div>

            {{-- KTH Verified - EMERALD --}}
            <div
                class="p-6 bg-white rounded-3xl shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)] border-l-4 border-l-emerald-500">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-emerald-100 rounded-xl">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-emerald-600 text-sm font-inter bg-emerald-100 rounded-full px-2 py-1">Sudah
                        diverifikasi</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-tight">KTH Verified</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ number_format($verifiedKTH) }}</p>
                </div>
            </div>

            {{-- Laporan Pending - AMBER --}}
            <div class="p-6 bg-white rounded-3xl shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)] border-l-4 border-l-amber-500">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-amber-100 rounded-xl">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-amber-600 text-sm font-inter bg-amber-100 rounded-full px-2 py-1">Menunggu
                        verifikasi</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-tight">Laporan Pending</p>
                    <p class="text-3xl font-bold text-amber-600">{{ number_format($pendingLaporan) }}</p>
                </div>
            </div>

            {{-- Laporan Verified - EMERALD --}}
            <div
                class="p-6 bg-white rounded-3xl shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)] border-l-4 border-l-emerald-500">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-emerald-100 rounded-xl">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-emerald-600 text-sm font-inter bg-emerald-100 rounded-full px-2 py-1">Sudah
                        diverifikasi</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-tight">Laporan Verified</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ number_format($verifiedLaporan) }}</p>
                </div>
            </div>
        </div>

        {{-- Grafik: Distribusi Status KTH & Grafik Status Laporan --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            {{-- Distribusi Status KTH (kiri) --}}
            <div class="bg-white rounded-2xl shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-zinc-900">Distribusi Status KTH</h2>
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
                            <span class="text-2xl font-bold text-zinc-900 leading-none">{{ $totalKTH }}</span>
                            <span
                                class="text-md font-inter text-zinc-900 font-semibold tracking-widest mt-0.5">TOTAL</span>
                        </div>
                        <svg viewBox="0 0 120 120" class="w-full h-full -rotate-90">
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#e5e7eb"
                                stroke-width="12" />
                            @php
                                $verifiedDash = $verifiedPercent . ' ' . (100 - $verifiedPercent);
                                $pendingDash = $pendingPercent . ' ' . (100 - $pendingPercent);
                                $rejectedDash = $rejectedPercent . ' ' . (100 - $rejectedPercent);
                            @endphp
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#2B644A"
                                stroke-width="12" stroke-dasharray="{{ $verifiedDash }}" stroke-dashoffset="0" />
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#D97706"
                                stroke-width="12" stroke-dasharray="{{ $pendingDash }}"
                                stroke-dashoffset="-{{ $verifiedPercent }}" />
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#DC2626"
                                stroke-width="12" stroke-dasharray="{{ $rejectedDash }}"
                                stroke-dashoffset="-{{ $verifiedPercent + $pendingPercent }}" />
                        </svg>
                    </div>
                    {{-- Legend + progress --}}
                    <div class="flex-1 space-y-2">
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-[#2B644A]">Verified</span>
                                <span class="text-xs text-[#2B644A] font-semibold">{{ $verifiedPercent }}%
                                    ({{ $verifiedKTH }}
                                    KTH)</span>
                            </div>
                            <div class="w-full h-3 bg-gray-200 rounded-full">
                                <div class="h-3 bg-primary rounded-full" style="width:{{ $verifiedPercent }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-[#D97706]">Pending</span>
                                <span class="text-xs text-[#D97706] font-semibold">{{ $pendingPercent }}%
                                    ({{ $pendingKTH }}
                                    KTH)</span>
                            </div>
                            <div class="w-full h-3 bg-gray-200 rounded-full">
                                <div class="h-3 bg-yellow-500 rounded-full" style="width:{{ $pendingPercent }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-[#DC2626]">Rejected</span>
                                <span class="text-xs text-[#DC2626] font-semibold">{{ $rejectedPercent }}%
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

            <div class="bg-white rounded-2xl shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-zinc-900">Grafik Laporan per Bulan</h2>
                    <span
                        class="text-xs font-normal text-primary bg-[#0e4c341a] rounded-full border border-[#0e4c3433] px-3 py-1">{{ now()->year }}</span>
                </div>
                <div class="mt-4">
                    <div class="relative h-64">
                        @php
                            $labels = $chartData['labels'] ?? [
                                'Jan',
                                'Feb',
                                'Mar',
                                'Apr',
                                'Mei',
                                'Jun',
                                'Jul',
                                'Agu',
                                'Sep',
                                'Okt',
                                'Nov',
                                'Des',
                            ];
                            $data = $chartData['data'] ?? array_fill(0, 12, 0);
                            $maxValue = $chartData['maxValue'] ?? 1;
                            $maxValue = is_numeric($maxValue) ? $maxValue : 1;
                            $maxHeight = 85;

                            // Label Y dengan interval yang lebih halus
                            $yLabels = [
                                $maxValue,
                                round($maxValue * 0.75),
                                round($maxValue * 0.5),
                                round($maxValue * 0.25),
                                0,
                            ];
                        @endphp

                        <div class="absolute inset-0 flex" style="padding-bottom: 20px; padding-left: 35px;">
                            {{-- Label Y di kiri --}}
                            <div class="flex flex-col justify-between text-[10px] text-[#404943] pr-2"
                                style="height: 100%;">
                                @foreach ($yLabels as $label)
                                    <span>{{ $label }}</span>
                                @endforeach
                            </div>

                            {{-- Area Chart --}}
                            <div class="flex-1 flex items-end justify-around relative">
                                @foreach ($labels as $index => $label)
                                    @php
                                        $value = $data[$index] ?? 0;
                                        $height = $maxValue > 0 ? ($value / $maxValue) * $maxHeight : 0;
                                        $height = max(2, $height);
                                    @endphp
                                    <div class="flex flex-col items-center"
                                        style="width: 8.33%; height: 100%; justify-content: flex-end;">
                                        @if ($value > 0)
                                            <span
                                                class="text-[10px] text-primary font-bold text-center mb-1">{{ $value }}</span>
                                        @endif
                                        <div class="w-6 bg-primary rounded-t transition-all duration-500"
                                            style="height: {{ $height }}%; min-height: {{ $value > 0 ? '4px' : '0' }};">
                                        </div>
                                        <span class="text-[10px] text-[#404943] mt-1">{{ $label }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Garis bantu horizontal --}}
                        <div class="absolute left-0 right-0 bottom-0 border-t border-gray-200" style="left: 35px;"></div>
                        <div class="absolute left-0 right-0 bottom-1/4 border-t border-gray-100" style="left: 35px;">
                        </div>
                        <div class="absolute left-0 right-0 bottom-1/2 border-t border-gray-100" style="left: 35px;">
                        </div>
                        <div class="absolute left-0 right-0 bottom-3/4 border-t border-gray-100" style="left: 35px;">
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-2 text-xs text-[#404943]">
                        <span class="flex items-center">
                            <span class="inline-block w-3 h-3 bg-primary rounded-sm mr-1"></span>
                            Jumlah Laporan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
