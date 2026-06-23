@extends('layouts.app')

@section('title', 'Verifikasi Laporan')

@section('content')
    <div class="w-full space-y-6">
        {{-- Header --}}
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-emerald-900 font-poppins">Verifikasi Laporan KTH</h1>
                <p class="text-base text-neutral-700 font-inter mt-1">Tinjau dan verifikasi laporan KTH yang menunggu
                    persetujuan.</p>
            </div>
        </div>

        {{-- Filter & Pencarian --}}
        <div class="bg-white rounded-3xl shadow p-4 flex flex-wrap items-center gap-3">
            <form action="{{ route('penyuluh.kth.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full">
                {{-- Search --}}
                <div class="relative flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama KTH atau Periode Laporan..."
                        class="w-full h-12 pl-12 pr-4 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] text-base focus:outline-none focus:ring-2 focus:ring-primary">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <div class="relative w-48">
                    <select name="periode" onchange="this.form.submit()"
                        class="w-full h-12 px-4 pr-10 bg-[#f8f9fa] rounded-xl border border-[#c0c9c1] text-base appearance-none focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">Periode Laporan</option>
                        <option value="Semester I" {{ request('periode') == 'Semester I' ? 'selected' : '' }}>Semester I
                        </option>
                        <option value="Semester II" {{ request('periode') == 'Semester II' ? 'selected' : '' }}>Semester II
                        </option>
                        <option value="Tahunan" {{ request('periode') == 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500 pointer-events-none"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>

                <button type="button" onclick="resetFilters()"
                    class="h-12 px-6 border border-[#c0c9c1] rounded-xl text-[#404943] flex items-center gap-2 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Reset Filter
                </button>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-100 border-b border-stone-300">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-neutral-700 uppercase tracking-wide">Nama
                                KTH</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-neutral-700 uppercase tracking-wide">
                                Periode</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-neutral-700 uppercase tracking-wide">Jenis
                                Usaha</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-neutral-700 uppercase tracking-wide">
                                Status KTH</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-neutral-700 uppercase tracking-wide">
                                Status Laporan</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-neutral-700 uppercase tracking-wide">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-300">
                        @forelse($laporans as $laporan)
                            @php
                                $kthVerified = $laporan->kth && $laporan->kth->status_verifikasi == 'verified';
                                $kthStatus = $laporan->kth ? $laporan->kth->status_verifikasi : 'Tidak Diketahui';
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span
                                        class="text-base font-medium text-zinc-900">{{ $laporan->kth->nama_kth ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-base text-zinc-600">{{ $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('d M Y') : '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-base text-neutral-700">{{ $laporan->jenis_usaha ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($kthVerified)
                                        <span
                                            class="inline-flex items-center gap-1.5 p-4 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Verified
                                        </span>
                                    @elseif($kthStatus == 'rejected')
                                        <span
                                            class="inline-flex items-center gap-1.5 p-4 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 p-4 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 p-4 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                        Pending
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Tombol Setujui & Tolak (hanya jika KTH verified) --}}
                                        @if ($kthVerified)
                                            <button type="button"
                                                onclick="openApproveLaporanModal({{ $laporan->id }}, '{{ $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('F Y') : '-' }}', '{{ addslashes($laporan->kth->nama_kth ?? '') }}', function(id) { approveLaporan(id); })"
                                                class="text-neutral hover:outline-2 hover:outline-primary hover:text-primary hover:bg-neutral bg-primary rounded-lg p-2 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24">
                                                    <path d="M0 0h24v24H0z" fill="none" />
                                                    <path fill="currentColor"
                                                        d="M21 7L9 19l-5.5-5.5l1.41-1.41L9 16.17L19.59 5.59z" />
                                                </svg>
                                            </button>

                                            <button type="button"
                                                onclick="openRejectLaporanModal({{ $laporan->id }}, '{{ $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('F Y') : '-' }}', '{{ addslashes($laporan->kth->nama_kth ?? '') }}')"
                                                class="text-neutral hover:outline-2 hover:outline-red-500 hover:text-red-500 hover:bg-neutral bg-red-500 rounded-lg p-2 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24">
                                                    <path d="M0 0h24v24H0z" fill="none" />
                                                    <path fill="currentColor"
                                                        d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6z" />
                                                </svg>
                                            </button>

                                            {{-- Tombol Detail --}}
                                            <button type="button" onclick="openDetailLaporanAdmin({{ $laporan->id }})"
                                                class="text-neutral hover:outline-2 hover:outline-yellow-500 hover:text-yellow-500 hover:bg-neutral bg-yellow-500 rounded-lg p-2 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24">
                                                    <path d="M0 0h24v24H0z" fill="none" />
                                                    <path fill="currentColor"
                                                        d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0" />
                                                </svg>
                                            </button>
                                        @else
                                            {{-- Keterangan jika KTH belum verified --}}
                                            <span class="text-xs text-gray-400 italic">
                                                KTH {{ $kthStatus == 'rejected' ? 'Rejected' : 'Pending' }}
                                            </span>
                                        @endif



                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-neutral-500">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-base font-medium">Tidak ada laporan yang menunggu verifikasi</p>
                                    <p class="text-sm text-gray-400 mt-1">Semua laporan sudah diproses.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($laporans->hasPages())
                <div
                    class="px-6 py-4 bg-white border-t border-stone-300 flex flex-wrap items-center justify-between gap-3">
                    <p class="text-sm text-neutral-700">
                        Menampilkan {{ $laporans->firstItem() ?? 0 }} dari {{ $laporans->total() }} data laporan
                    </p>
                    <div class="flex items-center gap-2">
                        {{ $laporans->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // ============================================
        // FUNGSI APPROVE LAPORAN
        // ============================================
        function approveLaporan(id) {

            fetch(`/admin/laporan/verifikasi/${id}/approve`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.redirected) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Laporan berhasil diverifikasi.',
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.reload();
                        });
                        return;
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.success === false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Gagal menyetujui laporan.',
                            confirmButtonColor: '#dc2626',
                        });
                    } else if (data && data.success === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Laporan berhasil diverifikasi.',
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan pada server. Silakan refresh halaman.',
                        confirmButtonColor: '#dc2626',
                    });
                });
        }


        // ============================================
        // OPEN REJECT LAPORAN MODAL
        // ============================================
        function openRejectLaporanModal(id) {
            alert('Fungsi tolak laporan akan diimplementasikan.');
        }

        // ============================================
        // RESET FILTERS
        // ============================================
        function resetFilters() {
            window.location.href = "{{ route('laporan.verifikasi') }}";
        }
    </script>
@endsection
