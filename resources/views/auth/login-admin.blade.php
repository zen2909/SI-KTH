@extends('layouts.auth')

@section('title', 'Login Admin | SI-KTH Sumenep')

@section('content')
    <div class="w-full max-w-[1100px] flex flex-col md:flex-row bg-white rounded-xl shadow-xl overflow-hidden">

        {{-- Left Side --}}
        <div class="hidden md:flex w-5/12 bg-primary flex-col justify-between p-8 text-white">
            <div>
                <div class="w-20 h-20 bg-white rounded-lg flex items-center justify-center p-2 mb-4">
                    <img src="{{ asset('images/logo-jatim.png') }}" class="w-full h-full object-contain" alt="Logo">
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">SI-KTH Sumenep</h1>
                <p class="text-base text-white/80">Sistem Informasi Kelompok Tani Hutan</p>
            </div>
            <div>
                <blockquote class="text-lg italic text-white/90 leading-relaxed">
                    "Kelola dan verifikasi data KTH dengan teliti untuk mendukung program kehutanan yang terencana."
                </blockquote>
            </div>
        </div>

        {{-- Right Side --}}
        <div class="w-full md:w-7/12 p-6 md:p-12 flex flex-col justify-center">
            <div class="mb-6">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-lg border border-blue-600">
                    <span class="icon-[ri--admin-line] w-4 h-4 bg-blue-600"></span>
                    <span class="text-xs font-semibold">AKSES ADMIN</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">Selamat Datang Admin</h2>
                <p class="text-gray-600">Kelola data KTH, laporan, dan verifikasi</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="role" value="admin">

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1" for="email">Alamat Email</label>
                    <input
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        id="email" name="email" type="email" value="{{ old('email') }}"
                        placeholder="admin@sumenepkab.go.id" required autofocus>
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-sm font-semibold text-gray-900" for="password">Kata Sandi</label>
                        <a class="text-sm text-primary hover:underline" href="{{ route('password.request') }}">Lupa Kata
                            Sandi?</a>
                    </div>
                    <input
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        id="password" name="password" type="password" placeholder="••••••••••••" required>
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary" id="remember"
                        name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                    <label class="ml-2 text-sm text-gray-600" for="remember">Tetap masuk</label>
                </div>

                <button class="w-full py-4 bg-primary text-white font-semibold rounded-lg hover:bg-primary/90 transition"
                    type="submit">
                    Masuk sebagai Admin
                </button>
            </form>
        </div>
    </div>


@endsection
