@extends('layouts.auth')

@section('title', 'Login Penyuluh | SI-KTH Sumenep')

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
                <blockquote class="text-lg italic text-white leading-relaxed">
                    "Pantau kinerja dan capaian KTH untuk pengambilan keputusan strategis yang berkelanjutan."
                </blockquote>
            </div>
        </div>

        {{-- Right Side --}}
        <div class="w-full md:w-7/12 p-6 md:p-12 flex flex-col justify-center">
            <div class="mb-6">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 bg-red-50 text-red-600 rounded-lg border border-red-600">
                    <span class="icon-[fluent-mdl2--party-leader] w-4 h-4 text-red-600"></span>
                    <span class="text-xs font-semibold">AKSES PIMPINAN</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">Selamat Datang Pimpinan</h2>
                <p class="text-gray-600">Pantau kinerja dan lihat laporan strategis KTH</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="role" value="pimpinan">

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1" for="email">Alamat Email</label>
                    <input
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        id="email" name="email" type="email" value="{{ old('email') }}"
                        placeholder="pimpinan@kth.go.id" required autofocus>
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

                <button class="w-full py-4 bg-primary text-white font-semibold rounded-lg hover:bg-primary transition"
                    type="submit">
                    Masuk sebagai Pimpinan
                </button>
            </form>
        </div>
    </div>


@endsection
