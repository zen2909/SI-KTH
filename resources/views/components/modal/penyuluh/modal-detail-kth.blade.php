@props(['kth' => null])

@if ($kth)
    <dialog id="modalDetailKTH"
        class="w-full max-w-6xl mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

        <div class="bg-white rounded-3xl flex flex-col max-h-[90vh]">
            {{-- Header --}}
            <div
                class="flex items-start bg-[#F8F9FA] py-6 px-8 border-b border-gray-100 sticky top-0 z-20 flex-shrink-0">
                <div class="flex flex-col shrink-0 items-center mr-4 gap-2">
                    <span class="text-[#0E4C34] text-[28px] font-bold">
                        {{ $kth->nama_kth ?? 'Detail KTH' }}
                    </span>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#404943]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="text-[#404943] text-base">Pengelolaan Hutan Berkelanjutan</span>
                    </div>
                </div>

                {{-- Tombol aksi --}}
                <div class="flex items-center gap-2 ml-auto">
                    {{-- Status Verifikasi --}}
                    @php
                        $statusVerifikasi = $kth->status_verifikasi ?? 'pending';
                        $statusBadge =
                            [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'verified' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                            ][$statusVerifikasi] ?? 'bg-gray-100 text-gray-800';

                        $dotColor =
                            [
                                'pending' => 'bg-yellow-500',
                                'verified' => 'bg-green-500',
                                'rejected' => 'bg-red-500',
                            ][$statusVerifikasi] ?? 'bg-gray-500';
                    @endphp
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-bold {{ $statusBadge }}">
                        <span class="w-2 h-2 rounded-full {{ $dotColor }}"></span>
                        {{ ucfirst($statusVerifikasi) }}
                    </span>

                    {{-- Status KTH --}}
                    @if (($kth->status_kth ?? '') == 'Aktif')
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-[#D2E8DC] text-[#4F6359]">
                            Aktif
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gray-200 text-gray-600">
                            Tidak Aktif
                        </span>
                    @endif

                    {{-- Tombol Close --}}
                    <button type="button" onclick="closeDetailModal()"
                        class="ml-2 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <div class="overflow-y-auto flex-1 px-8 py-6 bg-[#F8F9FA]">
                <div class="flex flex-col gap-6">
                    {{-- 2 Kolom: Identitas & Lokasi --}}
                    <div class="flex gap-6">
                        {{-- Kolom Kiri: Identitas Kelompok --}}
                        <div class="flex-1 bg-white rounded-3xl shadow p-6">
                            <div class="flex items-center mb-4 gap-3">
                                <div
                                    class="w-8 h-8 bg-[#0E4C34] rounded-lg flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <span class="text-[#191C1D] text-lg font-semibold">Identitas Kelompok</span>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <span class="text-[#404943] text-sm font-bold">Nama KTH</span>
                                    <p class="text-[#191C1D] text-base">{{ $kth->nama_kth ?? '-' }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-[#404943] text-sm font-bold">Nomor Register</span>
                                        <p class="text-[#191C1D] text-base">{{ $kth->nomor_register ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-[#404943] text-sm font-bold">Tanggal Register</span>
                                        <p class="text-[#191C1D] text-base">
                                            {{ isset($kth->tanggal_register) && $kth->tanggal_register ? \Carbon\Carbon::parse($kth->tanggal_register)->format('d F Y') : '-' }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-[#404943] text-sm font-bold">Kelas KTH</span>
                                    <p class="text-[#191C1D] text-base">{{ $kth->kelas_kth ?? '-' }}</p>
                                </div>
                                @if (($kth->status_kth ?? '') == 'Tidak Aktif' && ($kth->tahun_tidak_aktif ?? ''))
                                    <div>
                                        <span class="text-[#404943] text-sm font-bold">Tahun Tidak Aktif</span>
                                        <p class="text-[#BA1A1A] text-base font-semibold">{{ $kth->tahun_tidak_aktif }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Kolom Kanan: Lokasi & Kontak --}}
                        <div class="flex-1 bg-white rounded-3xl shadow p-6">
                            <div class="flex items-center mb-4 gap-3">
                                <div
                                    class="w-8 h-8 bg-[#0E4C34] rounded-lg flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-[#191C1D] text-lg font-semibold">Lokasi & Kontak</span>
                            </div>

                            <div class="space-y-3">
                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <span class="text-[#404943] text-sm font-bold">Kabupaten</span>
                                        <p class="text-[#191C1D] text-base">{{ $kth->kabupaten ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-[#404943] text-sm font-bold">Kecamatan</span>
                                        <p class="text-[#191C1D] text-base">{{ $kth->kecamatan ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-[#404943] text-sm font-bold">Desa</span>
                                        <p class="text-[#191C1D] text-base">{{ $kth->desa ?? '-' }}</p>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-[#404943] text-sm font-bold">Nama Ketua</span>
                                    <p class="text-[#191C1D] text-base">{{ $kth->nama_ketua ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-[#404943] text-sm font-bold">Nomor HP Ketua</span>
                                    <div class="flex items-center gap-2">
                                        <p class="text-[#191C1D] text-base">{{ $kth->no_hp_ketua ?? '-' }}</p>
                                        @if ($kth->no_hp_ketua ?? false)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kth->no_hp_ketua) }}"
                                                target="_blank"
                                                class="text-[#0E4C34] text-sm font-medium hover:underline flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                                </svg>
                                                Hubungi WhatsApp
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Peta & Histori Laporan --}}
                    <div class="flex gap-6">
                        {{-- Peta Leaflet --}}
                        <div class="flex-1 bg-white rounded-3xl shadow overflow-hidden">
                            <div class="flex items-center bg-[#F8F9FA] py-3 px-4 border-b border-gray-100">
                                <svg class="w-5 h-5 mr-2 text-[#0E4C34]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                    </path>
                                </svg>
                                <span class="text-[#191C1D] font-semibold">Lokasi Geografis</span>
                                @if (($kth->latitude ?? '') && ($kth->longitude ?? ''))
                                    <span class="ml-auto text-xs text-[#404943]">
                                        {{ $kth->latitude }}, {{ $kth->longitude }}
                                    </span>
                                @endif
                            </div>
                            <div id="detailMapContainer" style="height: 300px; width: 100%;"></div>
                        </div>

                        {{-- Histori Laporan --}}
                        <div class="flex-1 bg-white rounded-3xl shadow p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#0E4C34]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <span class="text-[#191C1D] text-lg font-semibold">Histori Laporan</span>
                                    <span class="text-xs text-[#404943] bg-gray-100 px-2 py-0.5 rounded-full">
                                        {{ $kth->laporanKth->where('status_verifikasi', 'verified')->count() }}
                                    </span>
                                </div>
                                @if ($kth->laporanKth->where('status_verifikasi', 'verified')->count() > 0)
                                    <a href="{{ route('penyuluh.laporan.index', ['search' => $kth->nama_kth, 'status_verifikasi' => 'verified']) }}"
                                        class="text-[#0E4C34] text-sm font-medium hover:underline flex items-center gap-1">
                                        Lihat Semua
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>

                            @php
                                // Ambil laporan dengan status verified dan urutkan dari yang terbaru
                                $verifiedLaporans = $kth->laporanKth
                                    ->where('status_verifikasi', 'verified')
                                    ->sortByDesc('periode_laporan')
                                    ->take(5);
                            @endphp

                            @if ($verifiedLaporans->count() > 0)
                                <div class="space-y-2">
                                    {{-- Header Tabel --}}
                                    <div
                                        class="grid grid-cols-3 gap-2 text-xs font-bold text-[#404943] pb-1 border-b border-gray-100">
                                        <span>Periode</span>
                                        <span>Jenis Usaha</span>
                                        <span class="text-right">Status</span>
                                    </div>

                                    {{-- Data Laporan --}}
                                    @foreach ($verifiedLaporans as $laporan)
                                        <div
                                            class="grid grid-cols-3 gap-2 items-center py-1.5 border-b border-gray-50 text-sm hover:bg-gray-50 rounded-lg px-1 transition">
                                            <span class="text-[#191C1D]">
                                                {{ $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('F Y') : '-' }}
                                            </span>
                                            <span class="text-[#191C1D] truncate flex items-center gap-1">
                                                <svg class="w-3 h-3 text-[#404943] flex-shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z">
                                                    </path>
                                                </svg>
                                                <span class="truncate">{{ $laporan->jenis_usaha ?? '-' }}</span>
                                            </span>
                                            <span class="text-right">
                                                <span
                                                    class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                    ✓ Terverifikasi
                                                </span>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Jika ada lebih dari 5, tampilkan info --}}
                                @if ($kth->laporanKth->where('status_verifikasi', 'verified')->count() > 5)
                                    <div class="text-center text-xs text-[#404943] mt-2">
                                        + {{ $kth->laporanKth->where('status_verifikasi', 'verified')->count() - 5 }}
                                        laporan lainnya
                                    </div>
                                @endif
                            @else
                                {{-- Empty State --}}
                                <div class="flex flex-col items-center justify-center py-8 text-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-[#404943] text-sm font-medium">Belum ada laporan terverifikasi</p>
                                    <p class="text-[#404943] text-xs mt-1">Laporan yang sudah diverifikasi akan muncul
                                        di sini</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex justify-between items-center bg-[#F8F9FA] py-3 px-8 border-t border-gray-100">
                <div class="text-xs text-[#404943]">
                    <span class="font-medium">ID KTH:</span> {{ $kth->id ?? '-' }}
                </div>
                <div class="flex items-center gap-4 text-xs text-[#404943]">
                    <span>Dibuat:
                        {{ isset($kth->created_at) && $kth->created_at ? $kth->created_at->format('d/m/Y H:i') : '-' }}</span>
                    <span>|</span>
                    <span>Diperbarui:
                        {{ isset($kth->updated_at) && $kth->updated_at ? $kth->updated_at->format('d/m/Y H:i') : '-' }}</span>
                </div>
            </div>
        </div>
    </dialog>

    <script>
        // ============================================
        // LEAFLET MAP untuk Detail
        // ============================================
        let detailMap = null;
        let detailMarker = null;

        function initDetailMap(lat, lng) {
            const container = document.getElementById('detailMapContainer');
            if (!container) return;

            const defaultLat = lat || -7.0;
            const defaultLng = lng || 113.0;

            if (detailMap) {
                detailMap.remove();
                detailMap = null;
                detailMarker = null;
            }

            detailMap = L.map(container).setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(detailMap);

            if (lat && lng) {
                detailMarker = L.marker([lat, lng], {
                    draggable: false
                }).addTo(detailMap);
            }

            setTimeout(() => {
                if (detailMap) {
                    detailMap.invalidateSize();
                }
            }, 300);
        }

        // ============================================
        // FUNGSI BUKA DETAIL MODAL
        // ============================================
        window.openDetailKTHModal = function(kthId) {
            const modal = document.getElementById('modalDetailKTH');
            if (modal) {
                modal.showModal();
                document.body.classList.add('no-scroll');

                setTimeout(() => {
                    @if ($kth && $kth->latitude && $kth->longitude)
                        initDetailMap({{ $kth->latitude }}, {{ $kth->longitude }});
                    @else
                        initDetailMap(null, null);
                    @endif
                }, 400);
            }
        };

        // ============================================
        // FUNGSI TUTUP DETAIL MODAL
        // ============================================
        function closeDetailModal() {
            const modal = document.getElementById('modalDetailKTH');
            if (modal) {
                modal.close();
                document.body.classList.remove('no-scroll');
                if (detailMap) {
                    detailMap.remove();
                    detailMap = null;
                    detailMarker = null;
                }
            }
        }

        // ============================================
        // EVENT LISTENER MODAL
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalDetailKTH');
            if (modal) {
                modal.addEventListener('close', function() {
                    document.body.classList.remove('no-scroll');
                    if (detailMap) {
                        detailMap.remove();
                        detailMap = null;
                        detailMarker = null;
                    }
                });
                modal.addEventListener('cancel', function() {
                    document.body.classList.remove('no-scroll');
                });
            }
        });
    </script>
@else
    {{-- Fallback jika kth null --}}
    <dialog id="modalDetailKTH" class="w-full max-w-md mx-auto rounded-lg shadow-lg p-6 backdrop:bg-black/50">
        <p class="text-red-500 font-semibold">Data KTH tidak ditemukan.</p>
        <button onclick="closeDetailModal()" class="mt-4 bg-gray-200 px-4 py-2 rounded">Tutup</button>
    </dialog>
@endif
