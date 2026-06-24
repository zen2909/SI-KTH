@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="w-full space-y-6">

        {{-- Header --}}
        <div class="self-stretch flex flex-wrap justify-between items-end gap-4">
            <div class="flex-1 min-w-[280px]">
                <h1 class="text-emerald-900 text-2xl md:text-3xl font-semibold font-poppins leading-10">Profil Saya
                </h1>
                <p class="text-neutral-700 text-base font-normal font-inter leading-6 max-w-[672px]">
                    Kelola informasi pribadi dan keamanan akun administratif Anda.
                </p>
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-4 gap-6">

            {{-- Sidebar Profile - 1/4 --}}
            <div class="col-span-1">
                <div
                    class="bg-white rounded-3xl border border-stone-300/30 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)] p-6 flex flex-col items-center sticky top-6">

                    {{-- Avatar --}}
                    <div class="relative mb-4">
                        <div
                            class="w-32 h-32 rounded-full border-4 border-primary shadow-[0px_0px_0px_8px_rgba(14,76,52,0.05)] flex items-center justify-center bg-gray-100 overflow-hidden">
                            @if ($user->foto_profil)
                                <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl font-bold text-emerald-900">
                                    {{ Str::upper(substr($user->name, 0, 2)) }}
                                </span>
                            @endif
                        </div>

                    </div>

                    {{-- Name --}}
                    <h3 class="text-zinc-900 text-xl font-medium font-poppins leading-7 text-center">
                        {{ $user->name }}</h3>

                    {{-- Email --}}
                    <p class="text-neutral-700 text-sm font-normal font-inter leading-6 text-center">
                        {{ $user->email }}</p>

                    {{-- Role Badge --}}
                    <div class="mt-3 px-4 py-1.5 bg-red-100 rounded-full">
                        <span class="text-red-800 text-sm font-medium font-inter">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="w-full mt-6 flex flex-col gap-2">
                        <button type="button" onclick="openUbahFotoAdminModal()"
                            class="w-full h-10 bg-emerald-900 rounded-xl text-white text-sm font-medium font-inter hover:bg-emerald-800 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Ubah Foto
                        </button>
                    </div>
                </div>
            </div>

            {{-- Main Content - 3/4 --}}
            <div class="col-span-3 gap-6">

                {{-- Informasi Dasar --}}
                <div
                    class="bg-white rounded-3xl border border-stone-300/30 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)] p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <svg class="w-6 h-6 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <h2 class="text-zinc-900 text-lg font-medium font-poppins leading-7">Informasi Dasar</h2>
                    </div>

                    <form action="{{ route('pimpinan.profile.update') }}" method="POST" class="flex flex-col gap-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nama --}}
                            <div class="flex flex-col gap-2">
                                <label class="text-neutral-700 text-sm font-medium font-inter leading-6">Nama
                                    Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full h-12 px-4 py-3 bg-gray-50 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-zinc-900 text-base font-inter">
                                @error('name')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="flex flex-col gap-2">
                                <label class="text-neutral-700 text-sm font-medium font-inter leading-6">Alamat
                                    Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full h-12 px-4 py-3 bg-gray-50 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-zinc-900 text-base font-inter">
                                @error('email')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2.5 bg-emerald-900 rounded-xl text-white text-sm font-medium font-inter hover:bg-emerald-800 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Keamanan & Password --}}
                <div
                    class="bg-white rounded-3xl border border-stone-300/30 shadow-[0px_4px_20px_-2px_rgba(0,0,0,0.05)] p-6 mt-5">
                    <div class="flex items-center gap-3 mb-6">
                        <svg class="w-6 h-6 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <h2 class="text-zinc-900 text-lg font-medium font-poppins leading-7">Keamanan & Password
                        </h2>
                    </div>

                    <form action="{{ route('pimpinan.profile.password') }}" method="POST" class="flex flex-col gap-6">
                        @csrf
                        @method('PUT')

                        {{-- Password Saat Ini --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-neutral-700 text-sm font-medium font-inter leading-6">Password Saat
                                Ini</label>
                            <input type="password" name="current_password" placeholder="Masukkan password saat ini"
                                class="w-full h-12 px-4 py-3 bg-gray-50 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-base font-inter placeholder:text-gray-500">
                            @error('current_password')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Password Baru --}}
                            <div class="flex flex-col gap-2">
                                <label class="text-neutral-700 text-sm font-medium font-inter leading-6">Password
                                    Baru (kosongkan jika tidak diubah)</label>
                                <input type="password" name="password" placeholder="Min. 8 karakter"
                                    class="w-full h-12 px-4 py-3 bg-gray-50 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-base font-inter placeholder:text-gray-500">
                                @error('password')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="flex flex-col gap-2">
                                <label class="text-neutral-700 text-sm font-medium font-inter leading-6">Konfirmasi
                                    Password Baru</label>
                                <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                    class="w-full h-12 px-4 py-3 bg-gray-50 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-base font-inter placeholder:text-gray-500">
                            </div>
                        </div>

                        <div class="flex flex-wrap justify-end gap-4 pt-2">
                            <button type="reset"
                                class="px-6 py-2.5 rounded-full text-zinc-600 text-sm font-medium font-inter hover:bg-gray-50 transition">
                                Batalkan
                            </button>
                            <button type="submit"
                                class="px-6 py-2.5 bg-emerald-900 rounded-xl text-white text-sm font-medium font-inter hover:bg-emerald-800 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- SweetAlert untuk Notifikasi --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Tutup'
                });
            });
        </script>
    @endif

    @if (session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Informasi',
                    text: '{{ session('info') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const uploadInput = document.getElementById('uploadFoto');
                if (uploadInput) {
                    uploadInput.addEventListener('change', function() {
                        if (this.files && this.files.length > 0) {
                            document.getElementById('formUploadFoto').submit();
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
