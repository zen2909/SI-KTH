@props(['laporan' => null])

@if ($laporan)
    <dialog id="modalDetailLaporan"
        class="w-full max-w-6xl mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

        <div class="bg-white rounded-3xl flex flex-col max-h-[90vh]">
            {{-- Header --}}
            <div class="bg-white border-b border-stone-300/20 sticky top-0 z-20 flex-shrink-0">
                <div class="flex items-center justify-between py-4 px-6">
                    <div>
                        <div class="flex items-center gap-2 text-sm">
                            <span class="text-neutral-700">Laporan KTH</span>
                            <svg class="w-3 h-3 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                            <span class="text-emerald-900 font-semibold">Detail Laporan</span>
                        </div>
                        <h2 class="text-2xl font-semibold text-zinc-900 font-poppins">
                            {{ $laporan->kth->nama_kth ?? 'KTH' }} -
                            {{ $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('F Y') : '-' }}
                        </h2>
                    </div>
                    <button type="button" onclick="closeDetailLaporanModal()"
                        class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <div class="overflow-y-auto flex-1 px-6 py-4 bg-gray-50">
                {{-- Status Revisi jika rejected --}}
                @if ($laporan->status_verifikasi == 'rejected')
                    <div class="bg-red-50/50 rounded-3xl p-4 mb-4 border border-red-700/10">
                        <div class="flex items-start gap-3">
                            <div>
                                <span
                                    class="inline-block px-3 py-1 bg-red-700 rounded-full text-white text-xs font-semibold uppercase">Ditolak
                                    / Perbaikan</span>
                                @if ($laporan->catatan_revisi)
                                    <div class="mt-2">
                                        <p class="text-red-700 text-sm font-semibold">Catatan Revisi dari Admin:</p>
                                        <p class="text-neutral-700 text-sm mt-1">{{ $laporan->catatan_revisi }}</p>
                                    </div>
                                @else
                                    <p class="text-neutral-500 text-sm mt-2 italic">Tidak ada catatan revisi dari Admin.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Status Verified --}}
                @if ($laporan->status_verifikasi == 'verified')
                    <div class="bg-green-50/50 rounded-3xl p-4 mb-4 border border-green-700/10">
                        <span
                            class="inline-block px-3 py-1 bg-green-700 rounded-full text-white text-xs font-semibold uppercase">Terverifikasi</span>
                    </div>
                @endif

                {{-- Status Pending --}}
                @if ($laporan->status_verifikasi == 'pending')
                    <div class="bg-yellow-50/50 rounded-3xl p-4 mb-4 border border-yellow-700/10">
                        <span
                            class="inline-block px-3 py-1 bg-yellow-600 rounded-full text-white text-xs font-semibold uppercase">Menunggu
                            Verifikasi</span>
                    </div>
                @endif

                {{-- Ringkasan Informasi --}}
                <div class="mb-4">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-1.5 h-6 bg-primary rounded-full"></div>
                        <h3 class="text-xl font-medium text-zinc-900 font-poppins">Ringkasan Informasi</h3>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-white rounded-3xl p-4 border border-stone-300/30 shadow-sm">
                            <p class="text-xs font-medium text-neutral-700 uppercase">Nama Penyuluh</p>
                            <p class="text-lg font-medium text-emerald-900 font-poppins">
                                {{ $laporan->penyuluh->nama_lengkap ?? '-' }}</p>
                        </div>
                        <div class="bg-white rounded-3xl p-4 border border-stone-300/30 shadow-sm">
                            <p class="text-xs font-medium text-neutral-700 uppercase">Periode Laporan</p>
                            <p class="text-lg font-medium text-zinc-900 font-poppins">
                                {{ $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('F Y') : '-' }}
                            </p>
                        </div>
                        <div class="bg-white rounded-3xl p-4 border border-stone-300/30 shadow-sm">
                            <p class="text-xs font-medium text-neutral-700 uppercase">Jenis Usaha</p>
                            <p class="text-lg font-medium text-zinc-900 font-poppins">{{ $laporan->jenis_usaha ?? '-' }}
                            </p>
                        </div>
                        <div class="bg-white rounded-3xl p-4 border border-stone-300/30 shadow-sm">
                            <p class="text-xs font-medium text-neutral-700 uppercase">NIB</p>
                            <p class="text-base font-medium text-zinc-900">{{ $laporan->nib ?? '-' }}</p>
                        </div>
                        <div class="bg-white rounded-3xl p-4 border border-stone-300/30 shadow-sm">
                            <p class="text-xs font-medium text-neutral-700 uppercase">PIRT</p>
                            <p class="text-base font-medium text-zinc-900">{{ $laporan->pirt ?? '-' }}</p>
                        </div>
                        <div class="bg-white rounded-3xl p-4 border border-stone-300/30 shadow-sm">
                            <p class="text-xs font-medium text-neutral-700 uppercase">Merek Dagang</p>
                            <p class="text-base font-medium text-emerald-900">{{ $laporan->merek_dagang ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Data Produksi & Ekonomi --}}
                <div class="mb-4">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-1.5 h-6 bg-emerald-900 rounded-full"></div>
                        <h3 class="text-xl font-medium text-zinc-900 font-poppins">Data Produksi & Ekonomi</h3>
                    </div>
                    <div class="bg-white rounded-3xl p-5 border border-stone-300/30 shadow-sm">
                        <div class="grid grid-cols-3 gap-4">
                            {{-- Potensi Produksi --}}
                            <div class="bg-emerald-50/50 rounded-xl p-4 border border-emerald-100">
                                <p class="text-xs font-medium text-neutral-600 uppercase tracking-wider">Potensi
                                    Produksi
                                </p>
                                @php
                                    $potensiValue = $laporan->potensi_produksi ?? '0';
                                    preg_match('/\d+/', $potensiValue, $matches);
                                    $potensiNumeric = (int) ($matches[0] ?? 0);

                                    $satuan = $laporan->satuan_produksi ?? 'Kg';

                                    // Tampilkan nilai lengkap dengan satuan
                                    $potensiDisplay =
                                        $potensiNumeric > 0 ? $potensiNumeric . ' ' . $satuan : '0 ' . $satuan;
                                @endphp
                                <div class="flex items-end gap-2 mt-1">
                                    <span
                                        class="text-3xl font-bold text-emerald-900 font-poppins">{{ $potensiDisplay }}</span>
                                    <span class="text-sm text-neutral-500 font-medium pb-1">/ Bulan</span>
                                </div>
                                <p class="text-xs text-neutral-500 mt-2">Jumlah produksi per bulan</p>
                            </div>

                            {{-- NTE per Bulan --}}
                            <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100">
                                <p class="text-xs font-medium text-neutral-600 uppercase tracking-wider">Nilai Tambah
                                    Ekonomi</p>
                                @php
                                    $nteValue = $laporan->nte_per_bulan ?? 0;
                                    $nteNumeric = is_numeric($nteValue) ? (float) $nteValue : 0;
                                @endphp
                                <div class="flex items-end gap-2 mt-1">
                                    <span class="text-3xl font-bold text-blue-700 font-poppins">Rp
                                        {{ number_format($nteNumeric, 0, ',', '.') }}</span>
                                    <span class="text-sm text-neutral-500 font-medium pb-1">/ Bulan</span>
                                </div>
                                <p class="text-xs text-neutral-500 mt-2">Nilai tambah ekonomi per bulan</p>
                            </div>

                            {{-- Jangkauan Pemasaran --}}
                            <div class="bg-purple-50/50 rounded-xl p-4 border border-purple-100">
                                <p class="text-xs font-medium text-neutral-600 uppercase tracking-wider">Jangkauan
                                    Pemasaran
                                </p>
                                <div class="mt-2">
                                    @php
                                        $jangkauanList = explode(',', $laporan->jangkauan_pemasaran ?? 'Lokal');
                                    @endphp
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach ($jangkauanList as $item)
                                            @php
                                                $item = trim($item);
                                                $colors = [
                                                    'Lokal' => 'bg-green-100 text-green-800 border-green-200',
                                                    'Regional' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                    'Nasional' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                    'Ekspor' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                ];
                                                $color = $colors[$item] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                            @endphp
                                            <span
                                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold border {{ $color }}">
                                                {{ $item }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                <p class="text-xs text-neutral-500 mt-2">Saluran distribusi produk</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kendala & Kebutuhan --}}
                <div class="mb-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-1.5 h-6 bg-red-700 rounded-full"></div>
                                <h3 class="text-xl font-medium text-zinc-900 font-poppins">Kendala Operasional</h3>
                            </div>
                            <div class="bg-white rounded-3xl p-4 border border-stone-300/30 shadow-sm">
                                @if ($laporan->kendala_usaha)
                                    @php
                                        $kendala = explode("\n", $laporan->kendala_usaha);
                                    @endphp
                                    @foreach ($kendala as $item)
                                        @if (trim($item))
                                            <div class="flex items-start gap-2 mb-2 last:mb-0">
                                                <svg class="w-5 h-5 text-red-700 flex-shrink-0 mt-0.5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                    </path>
                                                </svg>
                                                <span class="text-neutral-700 text-sm">{{ $item }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-neutral-500 text-sm italic">Tidak ada kendala yang dilaporkan</p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-1.5 h-6 bg-primary rounded-full"></div>
                                <h3 class="text-xl font-medium text-zinc-900 font-poppins">Kebutuhan Pengembangan</h3>
                            </div>
                            <div class="bg-white rounded-3xl p-4 border border-stone-300/30 shadow-sm">
                                @if ($laporan->kebutuhan_pengembangan)
                                    @php
                                        $kebutuhan = explode("\n", $laporan->kebutuhan_pengembangan);
                                    @endphp
                                    @foreach ($kebutuhan as $item)
                                        @if (trim($item))
                                            <div class="flex items-start gap-2 mb-2 last:mb-0">
                                                <svg class="w-5 h-5 text-neutral-700 flex-shrink-0 mt-0.5"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                                <span class="text-neutral-700 text-sm">{{ $item }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-neutral-500 text-sm italic">Tidak ada kebutuhan pengembangan</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 🔥 KETERANGAN TAMBAHAN --}}
                @if ($laporan->keterangan_tambahan)
                    <div class="mb-4">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-1.5 h-6 bg-primary rounded-full"></div>
                            <h3 class="text-xl font-medium text-zinc-900 font-poppins">Keterangan Tambahan</h3>
                        </div>
                        <div class="bg-white rounded-3xl p-4 border border-stone-300/30 shadow-sm">
                            <p class="text-neutral-700 text-sm leading-relaxed">{{ $laporan->keterangan_tambahan }}
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Dokumentasi & Sertifikat --}}
                <div>
                    <div class="grid grid-cols-2 gap-4">
                        {{-- Dokumentasi --}}
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-1.5 h-6 bg-primary rounded-full"></div>
                                <h3 class="text-xl font-medium text-zinc-900 font-poppins">Dokumentasi Kegiatan</h3>
                            </div>
                            <div class="bg-white rounded-3xl p-4 border border-stone-300/30 shadow-sm">
                                @php
                                    $dokumentasi = $laporan->dokumentasi ?? collect();
                                @endphp
                                @if ($dokumentasi->count() > 0)
                                    <div class="grid grid-cols-2 gap-3">
                                        @foreach ($dokumentasi as $doc)
                                            <div class="border border-stone-300/30 rounded-xl overflow-hidden">
                                                @php
                                                    $extension = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                                                    $isImage = in_array(strtolower($extension), [
                                                        'jpg',
                                                        'jpeg',
                                                        'png',
                                                        'gif',
                                                        'webp',
                                                    ]);
                                                @endphp
                                                @if ($isImage)
                                                    <div class="h-32 bg-zinc-100 overflow-hidden">
                                                        <img src="{{ asset('storage/' . $doc->file_path) }}"
                                                            alt="Dokumentasi" class="w-full h-full object-cover">
                                                    </div>
                                                @else
                                                    <div class="h-32 bg-zinc-100 flex items-center justify-center">
                                                        <svg class="w-12 h-16 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div class="p-2">
                                                    <p class="text-xs text-zinc-900 truncate">
                                                        {{ basename($doc->file_path) }}</p>
                                                    <a href="{{ asset('storage/' . $doc->file_path) }}" download
                                                        class="text-emerald-900 text-xs font-medium hover:underline flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                            </path>
                                                        </svg>
                                                        Unduh
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-neutral-500 text-sm italic text-center py-4">Tidak ada dokumentasi
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Sertifikat Halal --}}
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-1.5 h-6 bg-primary rounded-full"></div>
                                <h3 class="text-xl font-medium text-zinc-900 font-poppins">Sertifikat Halal</h3>
                            </div>
                            <div class="bg-white rounded-3xl p-4 border border-stone-300/30 shadow-sm">
                                @if ($laporan->sertifikat_halal_file)
                                    @php
                                        $sertifikatPath = $laporan->sertifikat_halal_file;
                                        $sertifikatExt = pathinfo($sertifikatPath, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($sertifikatExt), [
                                            'jpg',
                                            'jpeg',
                                            'png',
                                            'gif',
                                            'webp',
                                        ]);
                                    @endphp
                                    <div class="border border-stone-300/30 rounded-xl overflow-hidden">
                                        @if ($isImage)
                                            <div class="h-48 bg-zinc-100 overflow-hidden">
                                                <img src="{{ asset('storage/' . $sertifikatPath) }}"
                                                    alt="Sertifikat Halal" class="w-full h-full object-contain">
                                            </div>
                                        @else
                                            <div class="h-48 bg-zinc-100 flex flex-col items-center justify-center">
                                                <svg class="w-20 h-24 text-red-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <p class="text-sm text-gray-500 mt-2">File PDF</p>
                                            </div>
                                        @endif
                                        <div class="p-3 flex items-center justify-between">
                                            <p class="text-sm text-zinc-900 font-semibold truncate">
                                                {{ basename($sertifikatPath) }}</p>
                                            <a href="{{ asset('storage/' . $sertifikatPath) }}" download
                                                class="flex items-center gap-1 text-emerald-900 text-sm font-medium hover:underline">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                    </path>
                                                </svg>
                                                Unduh
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-neutral-500 text-sm italic text-center py-8">Belum ada sertifikat
                                        halal
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-white border-t border-stone-300/20 py-3 px-6 sticky bottom-0 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4 text-sm text-neutral-500">
                        <span>Terakhir diperbarui:
                            {{ $laporan->updated_at ? $laporan->updated_at->format('d M Y') : '-' }}</span>
                        <span class="text-xs">|</span>
                        <span>Status: <span
                                class="font-semibold capitalize">{{ $laporan->status_verifikasi ?? 'Pending' }}</span></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="closeDetailLaporanModal()"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl border border-neutral-500 text-neutral-700 text-sm font-semibold hover:bg-neutral-50 transition">
                            <svg class="w-4 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </button>
                        @if ($laporan->status_verifikasi == 'rejected')
                            <a href="{{ route('penyuluh.laporan.edit', $laporan->id) }}"
                                class="flex items-center gap-2 px-4 py-2 bg-primary rounded-xl text-white text-sm font-semibold hover:bg-emerald-800 transition shadow">
                                <svg class="w-4 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Edit Laporan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </dialog>

    <script>
        // ============================================
        // FUNGSI BUKA MODAL DETAIL LAPORAN
        // ============================================
        window.openDetailLaporanModal = function(laporanId) {
            console.log('Opening detail modal for laporan ID:', laporanId); // Debug
            const modal = document.getElementById('modalDetailLaporan');
            if (modal) {
                modal.showModal();
                document.body.classList.add('no-scroll');
            } else {
                console.error('Modal detail laporan tidak ditemukan!');
            }
        };

        // ============================================
        // FUNGSI TUTUP MODAL DETAIL LAPORAN
        // ============================================
        function closeDetailLaporanModal() {
            const modal = document.getElementById('modalDetailLaporan');
            if (modal) {
                modal.close();
                document.body.classList.remove('no-scroll');
            }
        }

        // ============================================
        // EVENT LISTENER MODAL
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalDetailLaporan');
            if (modal) {
                modal.addEventListener('close', function() {
                    document.body.classList.remove('no-scroll');
                });
                modal.addEventListener('cancel', function() {
                    document.body.classList.remove('no-scroll');
                });
            }
        });
    </script>
@else
    {{-- Fallback jika laporan null --}}
    <dialog id="modalDetailLaporan" class="w-full max-w-md mx-auto rounded-lg shadow-lg p-6 backdrop:bg-black/50">
        <p class="text-red-500 font-semibold">Data laporan tidak ditemukan.</p>
        <button onclick="closeDetailLaporanModal()" class="mt-4 bg-gray-200 px-4 py-2 rounded">Tutup</button>
    </dialog>
@endif
