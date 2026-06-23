@extends('layouts.app')

@section('title', 'Verifikasi KTH')

@section('content')
    <div class="w-full space-y-6">
        {{-- Header --}}
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-emerald-900 font-poppins">Verifikasi Data Kelompok Tani Hutan</h1>
                <p class="text-base text-neutral-700 font-inter mt-1">Tinjau dan verifikasi data pengajuan KTH yang menunggu
                    persetujuan.</p>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-3xl shadow-sm border border-stone-300/30 p-6 mb-6">
            <form action="{{ route('kth.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <!-- Cari KTH -->
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-neutral-700 text-sm font-normal font-['Inter'] mb-2">
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

                <!-- Kelas KTH -->
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-neutral-700 text-sm font-normal font-['Inter'] mb-2">
                        Kelas KTH
                    </label>
                    <select name="kelas_kth"
                        class="w-full px-4 py-3 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-base font-['Inter'] appearance-none cursor-pointer">
                        <option value="">Semua Kelas</option>
                        <option value="utama" {{ request('kelas_kth') == 'utama' ? 'selected' : '' }}>Utama</option>
                        <option value="madya" {{ request('kelas_kth') == 'madya' ? 'selected' : '' }}>Madya</option>
                        <option value="pemula" {{ request('kelas_kth') == 'pemula' ? 'selected' : '' }}>Pemula</option>
                    </select>
                </div>

                <!-- Kecamatan -->
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-neutral-700 text-sm font-normal font-['Inter'] mb-2">
                        Kecamatan
                    </label>
                    <select name="kecamatan"
                        class="w-full px-4 py-3 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-base font-['Inter'] appearance-none cursor-pointer">
                        <option value="">Semua Wilayah</option>
                        @foreach ($kecamatanList as $kec)
                            <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>
                                {{ $kec }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Aksi (sejajar ke samping) -->
                <div class="flex items-end gap-3 min-w-[200px]">
                    <button type="submit"
                        class="px-6 py-3 bg-emerald-900 text-white rounded-xl font-medium hover:bg-emerald-800 transition-colors whitespace-nowrap">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('kth.index') }}"
                        class="px-6 py-3 bg-gray-200 text-neutral-700 rounded-xl font-medium hover:bg-gray-300 transition-colors whitespace-nowrap">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-100 border-b border-stone-300">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">Nama
                                KTH</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">Kelas
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">
                                Desa/Kecamatan</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">
                                Tanggal Input</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">Nama
                                Penyuluh</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-[#404943] tracking-wider">
                                Status</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-[#404943] tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-300">
                        @forelse($kths as $kth)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span class="text-base font-medium text-zinc-900">{{ $kth->nama_kth }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-base text-zinc-600">{{ $kth->kelas_kth ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-base text-neutral-700">{{ $kth->desa ?? '-' }},
                                        {{ $kth->kecamatan ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-base text-neutral-500">{{ $kth->created_at ? $kth->created_at->format('d M Y') : '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-base text-zinc-900">{{ $kth->penyuluh->nama_lengkap ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase bg-yellow-100 text-yellow-800">
                                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                        Pending
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        {{-- Tombol Setujui --}}
                                        <button type="button"
                                            onclick="openApproveKTHModal({{ $kth->id }}, '{{ addslashes($kth->nama_kth) }}')"
                                            class="text-neutral hover:outline-2 hover:outline-primary hover:text-primary hover:bg-neutral bg-primary rounded-lg p-2 transition-all duration-200"
                                            title="Setujui Verifikasi">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24">
                                                <path d="M0 0h24v24H0z" fill="none" />
                                                <path fill="currentColor"
                                                    d="M21 7L9 19l-5.5-5.5l1.41-1.41L9 16.17L19.59 5.59z" />
                                            </svg>
                                        </button>

                                        {{-- Tombol Tolak --}}
                                        <button type="button"
                                            onclick="openRejectKTHModal({{ $kth->id }}, '{{ addslashes($kth->nama_kth) }}')"
                                            class="text-neutral hover:outline-2 hover:outline-red-500 hover:text-red-500 hover:bg-neutral bg-red-500 rounded-lg p-2 transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24">
                                                <path d="M0 0h24v24H0z" fill="none" />
                                                <path fill="currentColor"
                                                    d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6z" />
                                            </svg>
                                        </button>

                                        {{-- Tombol Detail --}}
                                        <button type="button" onclick="openDetailVerifikasiModal({{ $kth->id }})"
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
                                <td colspan="7" class="px-6 py-12 text-center text-neutral-500">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-base font-medium">Tidak ada data KTH yang menunggu verifikasi</p>
                                    <p class="text-sm text-gray-400 mt-1">Semua data KTH sudah diproses.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($kths->hasPages())
                <div
                    class="px-6 py-4 bg-white border-t border-stone-300 flex flex-wrap items-center justify-between gap-3">
                    <p class="text-sm text-neutral-700">
                        Menampilkan {{ $kths->firstItem() ?? 0 }} dari {{ $kths->total() }} data KTH
                    </p>
                    <div class="flex items-center gap-2">
                        @if ($kths->onFirstPage())
                            <span
                                class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-300 text-neutral-400 opacity-50 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $kths->previousPageUrl() }}"
                                class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-300 hover:bg-gray-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </a>
                        @endif

                        @foreach ($kths->getUrlRange(1, $kths->lastPage()) as $page => $url)
                            @if ($page == $kths->currentPage())
                                <span
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-emerald-900 text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-300 hover:bg-gray-50 transition">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($kths->hasMorePages())
                            <a href="{{ $kths->nextPageUrl() }}"
                                class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-300 hover:bg-gray-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @else
                            <span
                                class="w-8 h-8 flex items-center justify-center rounded-lg border border-stone-300 text-neutral-400 opacity-50 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Tolak --}}
    <dialog id="rejectModal"
        class="w-full max-w-md mx-auto rounded-2xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">
        <div class="bg-white rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-zinc-900">Tolak Verifikasi</h3>
                <button type="button" onclick="document.getElementById('rejectModal').close()"
                    class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Catatan Revisi</label>
                    <textarea name="catatan_revisi" rows="4" required
                        class="w-full px-4 py-3 bg-gray-50 rounded-lg border border-stone-300 focus:ring-2 focus:ring-emerald-900 focus:outline-none resize-none"
                        placeholder="Tuliskan alasan penolakan dan catatan revisi..."></textarea>
                    <p class="text-xs text-gray-400 mt-1">Minimal 10 karakter</p>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('rejectModal').close()"
                        class="px-6 py-2.5 border border-stone-300 rounded-lg text-neutral-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-red-700 rounded-lg text-white hover:bg-red-800 transition">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        // ============================================
        // FUNGSI BUKA MODAL APPROVE KTH
        // ============================================
        function openApproveKTHModal(id, namaKth) {
            if (typeof window.openApproveModal === 'function') {
                window.openApproveModal(id, namaKth, function(kthId) {
                    approveKTH(kthId);
                });
            } else {
                if (confirm(`Apakah Anda yakin ingin menyetujui verifikasi KTH "${namaKth}"?`)) {
                    approveKTH(id);
                }
            }
        }

        // ============================================
        // APPROVE KTH
        // ============================================
        function approveKTH(id) {
            fetch(`/admin/kth/verifikasi/${id}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            }).then(response => {
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data KTH berhasil diverifikasi.',
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal menyetujui verifikasi KTH.',
                    });
                }
            }).catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server.',
                });
            });
        }

        // ============================================
        // OPEN REJECT MODAL
        // ============================================
        function openRejectModal(id) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/admin/kth/verifikasi/${id}/reject`;
            modal.showModal();
        }

        // ============================================
        // DETAIL KTH
        // ============================================
        function detailKTH(id) {
            window.location.href = `/admin/kth/verifikasi/${id}`;
        }

        // ============================================
        // RESET FILTERS
        // ============================================
        function resetFilters() {
            window.location.href = "{{ route('kth.verifikasi') }}";
        }

        // ============================================
        // TUTUP MODAL SAAT KLIK DI LUAR
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('rejectModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.close();
                    }
                });
            }
        });
    </script>
@endsection
