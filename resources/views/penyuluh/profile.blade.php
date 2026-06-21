@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="space-y-6">
        {{-- Bagian atas: foto, nama, jabatan, status, tombol --}}
        <div class="flex flex-wrap items-start gap-6 bg-white rounded-3xl shadow p-6 relative">
            {{-- Foto profil --}}
            <div class="flex-row gap-2">
                <div
                    class="w-40 h-40 bg-[#edeeef] rounded-full overflow-hidden border-4 border-white shadow flex items-center justify-center">
                    @if ($user->foto_profil)
                        <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil"
                            class="w-full h-full object-cover">
                    @else
                        <span class="text-6xl text-gray-400 font-bold">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                        </span>
                    @endif
                </div>
                {{-- Tombol ubah foto --}}



            </div>

            {{-- Informasi utama --}}
            <div class="flex-col gap-2 mt-10">
                <h2 class="text-3xl font-semibold font-poppins text-primary">{{ $user->penyuluh->nama_lengkap }}</h2>
                <div class="flex items-center gap-2">
                    <span class="icon-[material-symbols--forest-outline-rounded] w-5 h-5 text-primary"></span>
                    <p class="text-xl font-medium font-poppins text-tertiary">{{ $user->penyuluh->jabatan }}</p>
                </div>

                <button type="button" onclick="window.openUbahFotoModal()"
                    class="mt-4 px-3 py-3 bg-primary text-white rounded-lg text-xs font-semibold flex items-center justify-center gap-1 hover:bg-white hover:outline-2 hover:outline-primary hover:scale-95 hover:text-primary transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-center">Ubah Foto</span>
                </button>
            </div>

            {{-- Tombol Edit Profil --}}
            <div class="ml-auto items-start">
                <button type="button" onclick="window.openEditProfilModal()"
                    class="inline-flex items-center gap-2 px-4 py-3 bg-primary text-white rounded-xl shadow hover:bg-[#1f4d36] hover:scale-105 transition-colors">
                    <span class="icon-[material-symbols--edit-note-outline] w-5 h-5 text-white"></span>
                    <span>Edit Profil</span>
                </button>
            </div>
        </div>

        {{-- Grid 2 kolom untuk data --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Kolom kiri: Informasi Akun & Data Kepegawaian --}}
            <div class="space-y-6">
                {{-- Informasi Akun --}}
                <div class="bg-white rounded-3xl shadow p-6 border-l-4 border-primary">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h3 class="text-xl font-medium text-primary">Informasi Akun</h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-semibold text-[#404943]">Username</p>
                            <p class="text-base font-semibold text-[#191c1d]">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#404943]">Email Akun</p>
                            <p class="text-base font-semibold text-[#191c1d]">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#404943]">Status Akun</p>
                            @if ($user->email_verified_at)
                                <span
                                    class="inline-block px-3 py-1 bg-green-100 rounded-full text-xs font-medium text-green-800">Terverifikasi</span>
                            @else
                                <span
                                    class="inline-block px-3 py-1 bg-red-100 rounded-full text-xs font-medium text-red-800">Tidak
                                    Terverifikasi</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Data Kepegawaian --}}
                <div class="bg-white rounded-3xl shadow p-6 border-l-4 border-primary">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <h3 class="text-xl font-medium text-primary">Data Kepegawaian</h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-semibold text-[#404943]">Golongan</p>
                            <p class="text-base font-semibold text-[#191c1d]">{{ $user->penyuluh->golongan_pangkat }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#404943]">NIP</p>
                            <p class="text-base font-semibold text-[#191c1d]">{{ $user->penyuluh->nip }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#404943]">Wilayah Kerja</p>
                            <p class="text-base font-semibold text-[#191c1d]">{{ $user->penyuluh->wilayah_kerja }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom kanan: Data Pribadi & Kontak --}}
            <div class="space-y-6">
                {{-- Data Pribadi --}}
                <div class="bg-white rounded-3xl shadow p-6 border-l-4 border-primary">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h3 class="text-xl font-medium text-primary">Data Pribadi</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-semibold text-[#404943]">Nama Lengkap</p>
                            <div class="mt-1 px-3 py-2 bg-[#f8f9fa] rounded-lg border border-[#e1e3e4] text-[#404943]">
                                {{ $user->penyuluh->nama_lengkap }}</div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#404943]">NIK</p>
                            <div class="mt-1 px-3 py-2 bg-[#f8f9fa] rounded-lg border border-[#e1e3e4] text-[#404943]">
                                {{ $user->penyuluh->nik }}</div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#404943]">Tempat Lahir</p>
                            <div class="mt-1 px-3 py-2 bg-[#f8f9fa] rounded-lg border border-[#e1e3e4] text-[#404943]">
                                {{ $user->penyuluh->tempat_lahir }}</div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#404943]">Tanggal Lahir</p>
                            <div class="mt-1 px-3 py-2 bg-[#f8f9fa] rounded-lg border border-[#e1e3e4] text-[#404943]">
                                {{ $user->penyuluh->tanggal_lahir->format('d F Y') }}</div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#404943]">Jenis Kelamin</p>
                            @if ($user->penyuluh->jenis_kelamin == 'L')
                                <div class="mt-1 px-3 py-2 bg-[#f8f9fa] rounded-lg border border-[#e1e3e4] text-[#404943]">
                                    Laki-Laki</div>
                            @else
                                <div class="mt-1 px-3 py-2 bg-[#f8f9fa] rounded-lg border border-[#e1e3e4] text-[#404943]">
                                    Perempuan</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Kontak & Alamat --}}
                <div class="bg-white rounded-3xl shadow p-6 border-l-4 border-primary">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <h3 class="text-xl font-medium text-primary">Kontak &amp; Alamat</h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-semibold text-[#404943]">Alamat Lengkap</p>
                            <div
                                class="mt-1 px-3 py-2 bg-[#f3f4f5] rounded-xl border border-[#c0c9c1] text-[#191c1d] opacity-75">
                                {{ $user->penyuluh->alamat }}
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-semibold text-[#404943]">Nomor Telepon / WhatsApp</p>
                                <div
                                    class="mt-1 px-3 py-2 bg-[#f3f4f5] rounded-xl border border-[#c0c9c1] text-[#191c1d] opacity-75">
                                    {{ $user->penyuluh->no_telepon }}</div>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[#404943]">Email Pribadi</p>
                                <div
                                    class="mt-1 px-3 py-2 bg-[#f3f4f5] rounded-xl border border-[#c0c9c1] text-[#191c1d] opacity-75">
                                    {{ $user->penyuluh->email_pribadi }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
