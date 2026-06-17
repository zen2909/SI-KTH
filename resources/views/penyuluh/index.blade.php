@extends('layouts.app')

@section('title', 'Dashboard Penyuluh')

@section('content')
    <div class="w-full space-y-6">
        {{-- Judul --}}
        <div class="mb-2">
            <h1 class="text-2xl font-bold text-primary font-poppins">
                Selamat datang, {{ Auth::user()->name }}
            </h1>
            <p class="text-sm text-[#404943] font-normal mt-1">
                Pantau aktivitas KTH binaan Anda dan kelola laporan terbaru di sini.
            </p>
        </div>

        {{-- Kartu Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            {{-- Total KTH --}}
            <div class="bg-white rounded-lg shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center bg-[#0e4c341a] rounded px-2 py-1">
                        <img src="{{ asset('img/vector-15.svg') }}" alt="icon" class="h-4 w-4" />
                    </div>
                    <span class="text-xs font-normal text-primary bg-[#0e4c341a] rounded-full px-2 py-0.5">+12%</span>
                </div>
                <div class="mt-2 text-sm font-normal text-[#404943]">TOTAL KTH</div>
                <div class="text-2xl font-semibold text-primary">{{ $totalKTH ?? 128 }}</div>
            </div>

            {{-- Pending --}}
            <div class="bg-white rounded-lg shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center bg-yellow-50 rounded px-2 py-1">
                        <img src="{{ asset('img/vector-9.svg') }}" alt="icon" class="h-4 w-4" />
                    </div>
                    <span class="text-xs font-normal text-yellow-700 bg-yellow-100 rounded-full px-2 py-0.5">Action
                        Required</span>
                </div>
                <div class="mt-2 text-sm font-normal text-[#404943]">PENDING</div>
                <div class="text-2xl font-semibold text-yellow-600">{{ $pendingKTH ?? 14 }}</div>
            </div>

            {{-- Verified --}}
            <div class="bg-white rounded-lg shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center bg-[#0e4c341a] rounded px-2 py-1">
                        <img src="{{ asset('img/vector-7.svg') }}" alt="icon" class="h-4 w-4" />
                    </div>
                    <span class="text-xs font-normal text-primary bg-[#0e4c341a] rounded-full px-2 py-0.5">92%
                        success</span>
                </div>
                <div class="mt-2 text-sm font-normal text-[#404943]">VERIFIED</div>
                <div class="text-2xl font-semibold text-primary">{{ $verifiedKTH ?? 104 }}</div>
            </div>

            {{-- Rejected --}}
            <div class="bg-white rounded-lg shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center bg-[#ffdad633] rounded px-2 py-1">
                        <img src="{{ asset('img/vector-2.svg') }}" alt="icon" class="h-4 w-4" />
                    </div>
                    <span class="text-xs font-normal text-[#ba1a1a] bg-[#ffdad633] rounded-full px-2 py-0.5">-2%</span>
                </div>
                <div class="mt-2 text-sm font-normal text-[#404943]">REJECTED</div>
                <div class="text-2xl font-semibold text-[#ba1a1a]">{{ $rejectedKTH ?? 10 }}</div>
            </div>

            {{-- Total Laporan --}}
            <div class="bg-white rounded-lg shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center">
                    <div class="flex items-center bg-[#4b5e551a] rounded px-2 py-1">
                        <img src="{{ asset('img/vector-17.svg') }}" alt="icon" class="h-4 w-4" />
                    </div>
                </div>
                <div class="mt-2 text-sm font-normal text-[#404943]">TOTAL LAPORAN</div>
                <div class="text-2xl font-semibold text-[#191c1d]">{{ $totalLaporan ?? 452 }}</div>
            </div>
        </div>

        {{-- Grafik: Distribusi Status KTH & Grafik Status Laporan --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            {{-- Distribusi Status KTH (kiri) --}}
            <div class="bg-white rounded-2xl shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-primary">Distribusi Status KTH</h2>
                    <img src="{{ asset('img/vector-16.svg') }}" alt="menu" class="h-5 w-5" />
                </div>
                <div class="flex flex-col md:flex-row items-center gap-4 mt-4">
                    {{-- Donut chart (sederhana) --}}
                    <div class="relative w-48 h-48">
                        {{-- Di sini bisa pakai chart.js nanti --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-2xl font-bold text-primary">{{ $totalKTH ?? 128 }}</span>
                            <span
                                class="absolute bottom-4 text-[10px] font-normal text-[#404943] tracking-widest">TOTAL</span>
                        </div>
                        {{-- Placeholder untuk donut --}}
                        <svg viewBox="0 0 120 120" class="w-full h-full -rotate-90">
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#e5e7eb"
                                stroke-width="12" />
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#0e4c34" stroke-width="12"
                                stroke-dasharray="81 339" stroke-dashoffset="0" />
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#eab308" stroke-width="12"
                                stroke-dasharray="11 339" stroke-dashoffset="-81" />
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#ba1a1a" stroke-width="12"
                                stroke-dasharray="8 339" stroke-dashoffset="-92" />
                        </svg>
                    </div>
                    {{-- Legend + progress --}}
                    <div class="flex-1 space-y-2">
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-[#191c1d]">Verified</span>
                                <span class="text-xs text-[#404943]">81% (104 KTH)</span>
                            </div>
                            <div class="w-full h-3 bg-gray-200 rounded-full">
                                <div class="h-3 bg-primary rounded-full" style="width:81%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-[#191c1d]">Pending</span>
                                <span class="text-xs text-[#404943]">11% (14 KTH)</span>
                            </div>
                            <div class="w-full h-3 bg-gray-200 rounded-full">
                                <div class="h-3 bg-yellow-500 rounded-full" style="width:11%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-semibold text-[#191c1d]">Rejected</span>
                                <span class="text-xs text-[#404943]">8% (10 KTH)</span>
                            </div>
                            <div class="w-full h-3 bg-gray-200 rounded-full">
                                <div class="h-3 bg-[#ba1a1a] rounded-full" style="width:8%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grafik Status Laporan (kanan) --}}
            <div class="bg-white rounded-2xl shadow p-4 border border-[#e1e3e433]">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-primary">Grafik Status Laporan</h2>
                    <span
                        class="text-xs font-normal text-primary bg-[#0e4c341a] rounded-full border border-[#0e4c3433] px-3 py-1">Bulanan</span>
                </div>
                <div class="mt-4">
                    {{-- Placeholder chart batang sederhana --}}
                    <div class="relative h-64">
                        <div class="absolute inset-0 flex items-end justify-around">
                            <div class="flex flex-col items-center">
                                <div class="w-8 bg-primary rounded-t" style="height:70%"></div>
                                <span class="text-xs text-[#404943] mt-1">JAN</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-8 bg-primary rounded-t" style="height:75%"></div>
                                <span class="text-xs text-[#404943] mt-1">FEB</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-8 bg-primary rounded-t" style="height:60%"></div>
                                <span class="text-xs text-[#404943] mt-1">MAR</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-8 bg-primary rounded-t" style="height:85%"></div>
                                <span class="text-xs text-[#404943] mt-1">APR</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-8 bg-primary rounded-t" style="height:90%"></div>
                                <span class="text-xs text-[#404943] mt-1">MEI</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-8 bg-primary rounded-t" style="height:80%"></div>
                                <span class="text-xs text-[#404943] mt-1">JUN</span>
                            </div>
                        </div>
                        {{-- Garis bantu --}}
                        <div class="absolute inset-x-0 top-0 border-t border-[#e1e3e41a]"></div>
                        <div class="absolute inset-x-0 top-1/3 border-t border-[#e1e3e41a]"></div>
                        <div class="absolute inset-x-0 top-2/3 border-t border-[#e1e3e41a]"></div>
                        <div class="absolute left-0 top-0 flex flex-col justify-between h-full text-[10px] text-[#404943]">
                            <span>150</span>
                            <span>100</span>
                            <span>50</span>
                            <span>0</span>
                        </div>
                    </div>
                    {{-- Legend --}}
                    <div class="flex items-center gap-4 mt-2 text-xs text-[#404943]">
                        <span class="flex items-center"><span
                                class="inline-block w-3 h-3 bg-primary rounded-sm mr-1"></span> Verified</span>
                        <span class="flex items-center"><span
                                class="inline-block w-3 h-3 bg-[#0e4c3433] rounded-sm mr-1"></span> Total
                            Laporan</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Aktivitas Terbaru --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden border border-[#e1e3e433]">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#e1e3e433]">
                <h2 class="text-lg font-medium text-primary">Aktivitas Terbaru</h2>
                <a href="#" class="text-sm font-normal text-primary hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#e1e3e41a]">
                    <thead class="bg-[#f3f4f54c]">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-[#404943]">Nama KTH</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-[#404943]">Tipe Aktivitas</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-[#404943]">Tanggal</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-[#404943]">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-[#404943]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e1e3e41a]">
                        {{-- Baris 1 --}}
                        <tr>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="h-8 w-8 flex items-center justify-center bg-[#2b644a1a] rounded-full">
                                    <img src="{{ asset('img/vector-6.svg') }}" alt="icon" class="h-4 w-4" />
                                </div>
                                <span class="font-semibold text-[#191c1d]">KTH Rimba Lestari</span>
                            </td>
                            <td class="px-6 py-4 text-[#404943]">Laporan Penanaman</td>
                            <td class="px-6 py-4 text-[#404943]">24 Mei 2024</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-3 py-1 text-xs font-normal text-primary bg-[#0e4c341a] rounded-full">Verified</span>
                            </td>
                            <td class="px-6 py-4">
                                <img src="{{ asset('img/vector-8.svg') }}" alt="aksi"
                                    class="h-5 w-5 cursor-pointer" />
                            </td>
                        </tr>
                        {{-- Baris 2 --}}
                        <tr>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="h-8 w-8 flex items-center justify-center bg-[#2b644a1a] rounded-full">
                                    <img src="{{ asset('img/vector-14.svg') }}" alt="icon" class="h-4 w-4" />
                                </div>
                                <span class="font-semibold text-[#191c1d]">KTH Maju Bersama</span>
                            </td>
                            <td class="px-6 py-4 text-[#404943]">Pendaftaran Baru</td>
                            <td class="px-6 py-4 text-[#404943]">23 Mei 2024</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-3 py-1 text-xs font-normal text-yellow-700 bg-yellow-100 rounded-full">Pending</span>
                            </td>
                            <td class="px-6 py-4">
                                <img src="{{ asset('img/vector-5.svg') }}" alt="aksi"
                                    class="h-5 w-5 cursor-pointer" />
                            </td>
                        </tr>
                        {{-- Baris 3 --}}
                        <tr>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="h-8 w-8 flex items-center justify-center bg-[#2b644a1a] rounded-full">
                                    <img src="{{ asset('img/vector-4.svg') }}" alt="icon" class="h-4 w-4" />
                                </div>
                                <span class="font-semibold text-[#191c1d]">KTH Tunas Harapan</span>
                            </td>
                            <td class="px-6 py-4 text-[#404943]">Laporan Inventarisasi</td>
                            <td class="px-6 py-4 text-[#404943]">22 Mei 2024</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-3 py-1 text-xs font-normal text-primary bg-[#0e4c341a] rounded-full">Verified</span>
                            </td>
                            <td class="px-6 py-4">
                                <img src="{{ asset('img/vector-11.svg') }}" alt="aksi"
                                    class="h-5 w-5 cursor-pointer" />
                            </td>
                        </tr>
                        {{-- Baris 4 --}}
                        <tr>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="h-8 w-8 flex items-center justify-center bg-[#2b644a1a] rounded-full">
                                    <img src="{{ asset('img/vector-12.svg') }}" alt="icon" class="h-4 w-4" />
                                </div>
                                <span class="font-semibold text-[#191c1d]">KTH Hijau Makmur</span>
                            </td>
                            <td class="px-6 py-4 text-[#404943]">Update Keanggotaan</td>
                            <td class="px-6 py-4 text-[#404943]">21 Mei 2024</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-3 py-1 text-xs font-normal text-[#ba1a1a] bg-[#ffdad633] rounded-full">Rejected</span>
                            </td>
                            <td class="px-6 py-4">
                                <img src="{{ asset('img/vector.svg') }}" alt="aksi"
                                    class="h-5 w-5 cursor-pointer" />
                            </td>
                        </tr>
                        {{-- Baris 5 --}}
                        <tr>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="h-8 w-8 flex items-center justify-center bg-[#2b644a1a] rounded-full">
                                    <img src="{{ asset('img/vector-19.svg') }}" alt="icon" class="h-4 w-4" />
                                </div>
                                <span class="font-semibold text-[#191c1d]">KTH Sejahtera</span>
                            </td>
                            <td class="px-6 py-4 text-[#404943]">Laporan Tahunan</td>
                            <td class="px-6 py-4 text-[#404943]">20 Mei 2024</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-3 py-1 text-xs font-normal text-primary bg-[#0e4c341a] rounded-full">Verified</span>
                            </td>
                            <td class="px-6 py-4">
                                <img src="{{ asset('img/vector-13.svg') }}" alt="aksi"
                                    class="h-5 w-5 cursor-pointer" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs opacity-40 text-[#191c1d] font-medium">
            © 2024 Forestry Connect - Digital Management for Better Forests
        </p>
    </div>
@endsection
