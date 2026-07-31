@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="w-full space-y-6">

        {{-- Header --}}
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-primary font-poppins">Selamat Datang, {{ Auth::user()->name }}</h1>
                <p class="text-base text-neutral-700 font-inter mt-1">Berikut ringkasan operasional sistem SI-KTH hari ini.
                </p>
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

        {{-- Kartu Statistik --}}
        {{-- Baris 1: 3 Kartu (Total User, Total KTH, Total Laporan) --}}
        <div class="grid grid-cols-3 gap-4">
            {{-- Total User - BLUE --}}
            <div class="p-6 bg-white rounded-3xl shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)] border-l-4 border-l-blue-500">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-blue-600 text-sm font-inter bg-blue-50 rounded-full px-2 py-1 ml-2">Total
                        keseluruhan</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-tight">Total Pengguna</p>
                    <p class="text-3xl font-bold text-blue-600">{{ number_format($totalUser) }}</p>
                </div>
            </div>

            {{-- Total KTH - ROSE/RED --}}
            <div class="p-6 bg-white rounded-3xl shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)] border-l-4 border-l-rose-500">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-rose-100 rounded-xl">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <span class="text-rose-600 text-sm font-inter  bg-rose-50 rounded-full px-2 py-1">Total
                        keseluruhan</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-rose-600 uppercase tracking-tight">Total KTH</p>
                    <p class="text-3xl font-bold text-rose-600">{{ number_format($totalKTH) }}</p>
                </div>
            </div>

            {{-- Total Laporan - PURPLE --}}
            <div
                class="p-6 bg-white rounded-3xl shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)] border-l-4 border-l-purple-500">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-purple-600 text-sm font-inter  bg-purple-50 rounded-full px-2 py-1">Total
                        keseluruhan</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-purple-600 uppercase tracking-tight">Total Laporan</p>
                    <p class="text-3xl font-bold text-purple-600">{{ number_format($totalLaporan) }}</p>
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
                    <span class="text-amber-600 text-sm font-inter  bg-amber-50 rounded-full px-2 py-1">Menunggu
                        derifikasi</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-tight">KTH Pending</p>
                    <p class="text-3xl font-bold text-amber-600">{{ number_format($kthPending) }}</p>
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
                    <span class="text-emerald-600 text-sm font-inter  bg-emerald-50 rounded-full px-2 py-1">Sudah
                        diverifikasi</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-tight">KTH Verified</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ number_format($kthVerified) }}</p>
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
                    <span class="text-amber-600 text-sm font-inter  bg-amber-50 rounded-full px-2 py-1 ml-2">Menunggu
                        verifikasi</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-tight">Laporan Pending</p>
                    <p class="text-3xl font-bold text-amber-600">{{ number_format($laporanPending) }}</p>
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
                    <span class="text-emerald-600 text-sm font-inter  bg-emerald-50 rounded-full px-2 py-1 ml-2">Sudah
                        diverifikasi</span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-tight">Laporan Verified</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ number_format($laporanVerified) }}</p>
                </div>
            </div>
        </div>

        {{-- Grafik: Distribusi Status KTH & Grafik Laporan per Bulan --}}
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
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span
                                class="text-2xl font-bold text-zinc-900 leading-none">{{ number_format($totalKTH) }}</span>
                            <span
                                class="text-md font-inter font-semibold text-zinc-900 tracking-widest mt-0.5">TOTAL</span>
                        </div>
                        <svg viewBox="0 0 120 120" class="w-full h-full -rotate-90">
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#e5e7eb"
                                stroke-width="12" />
                            @if ($verifiedPercent > 0)
                                <circle cx="60" cy="60" r="54" fill="none" stroke="#2B644A"
                                    stroke-width="12"
                                    stroke-dasharray="{{ $verifiedPercent }} {{ 100 - $verifiedPercent }}"
                                    stroke-dashoffset="0" />
                            @endif
                            @if ($pendingPercent > 0)
                                <circle cx="60" cy="60" r="54" fill="none" stroke="#D97706"
                                    stroke-width="12"
                                    stroke-dasharray="{{ $pendingPercent }} {{ 100 - $pendingPercent }}"
                                    stroke-dashoffset="-{{ $verifiedPercent }}" />
                            @endif
                            @if ($rejectedPercent > 0)
                                <circle cx="60" cy="60" r="54" fill="none" stroke="#DC2626"
                                    stroke-width="12"
                                    stroke-dasharray="{{ $rejectedPercent }} {{ 100 - $rejectedPercent }}"
                                    stroke-dashoffset="-{{ $verifiedPercent + $pendingPercent }}" />
                            @endif
                        </svg>
                    </div>
                    {{-- Legend + progress --}}
                    <div class="flex-1 space-y-2">
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-[#2B644A]">Verified</span>
                                <span class="text-xs text-[#2B644A]">{{ $verifiedPercent }}%
                                    ({{ number_format($kthVerified) }} KTH)</span>
                            </div>
                            <div class="w-full h-3 bg-gray-200 rounded-full">
                                <div class="h-3 bg-primary rounded-full" style="width:{{ $verifiedPercent }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-[#D97706]">Pending</span>
                                <span class="text-xs text-[#D97706]">{{ $pendingPercent }}%
                                    ({{ number_format($kthPending) }} KTH)</span>
                            </div>
                            <div class="w-full h-3 bg-gray-200 rounded-full">
                                <div class="h-3 bg-yellow-500 rounded-full" style="width:{{ $pendingPercent }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-[#DC2626]">Rejected</span>
                                <span class="text-xs text-[#DC2626]">{{ $rejectedPercent }}%
                                    ({{ number_format($kthRejected) }} KTH)</span>
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
                            $chartLabels = [
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
                            $maxValue = max($chartData) > 0 ? max($chartData) : 1;
                            $maxHeight = 90;
                            // Label Y dengan interval
                            $yLabels = [
                                $maxValue,
                                round($maxValue * 0.75),
                                round($maxValue * 0.5),
                                round($maxValue * 0.25),
                                0,
                            ];
                        @endphp

                        {{-- Container untuk chart + label Y --}}
                        <div class="absolute inset-0 flex" style="padding-bottom: 20px;">
                            {{-- Label Y di kiri --}}
                            <div class="flex flex-col justify-between text-[10px] text-[#404943] pr-2"
                                style="height: 100%; padding-bottom: 0;">
                                @foreach ($yLabels as $label)
                                    <span>{{ $label }}</span>
                                @endforeach
                            </div>

                            {{-- Area Chart --}}
                            <div class="flex-1 flex items-end justify-around relative">
                                @foreach ($chartLabels as $index => $label)
                                    @php
                                        $value = $chartData[$index + 1] ?? 0;
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

        {{-- Aktivitas Terbaru --}}
        <div class="bg-white rounded-[32px] shadow border border-stone-300/20 overflow-hidden">
            <div class="px-8 py-6 border-b border-stone-300/30 flex items-center justify-between">
                <h3 class="text-base font-semibold text-zinc-900 font-poppins">Aktivitas Terbaru</h3>
                <a href="#" class="text-emerald-900 text-sm font-inter hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-100">
                        <tr>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-neutral-500 uppercase tracking-wide">
                                User/Kelompok</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-neutral-500 uppercase tracking-wide">
                                Aktivitas</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-neutral-500 uppercase tracking-wide">
                                Tanggal</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-neutral-500 uppercase tracking-wide">
                                Status</th>
                            <th
                                class="px-8 py-4 text-right text-sm font-semibold text-neutral-500 uppercase tracking-wide">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-300/20">
                        @forelse($activities as $activity)
                            <tr>
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-emerald-900/10 rounded-full flex items-center justify-center">
                                            <span
                                                class="text-emerald-900 font-bold text-sm">{{ $activity['initials'] }}</span>
                                        </div>
                                        <div>
                                            <p class="text-zinc-900 font-semibold text-sm">{{ $activity['name'] }}</p>
                                            <p class="text-neutral-500 text-xs">ID: {{ $activity['id'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-neutral-700">{{ $activity['activity'] }}</td>
                                <td class="px-8 py-4 text-neutral-500">{{ $activity['date'] }}</td>
                                <td class="px-8 py-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $activity['statusClass'] }}">{{ $activity['status'] }}</span>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <button class="p-1.5 rounded-lg hover:bg-gray-100">
                                        <svg class="w-5 h-5 text-emerald-900" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-8 text-center text-neutral-500">Belum ada aktivitas
                                    terbaru</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
