@props(['kth' => null])

@if ($kth)
    <dialog id="modalDetailKTHAdmin"
        class="w-full max-w-5xl mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

        <div class="bg-white rounded-3xl flex flex-col max-h-[90vh]">
            {{-- Header --}}
            <div class="bg-white py-5 px-8 border-b border-gray-100 sticky top-0 z-20 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-primary text-2xl font-bold font-['Poppins']">
                            Detail Kelompok Tani Hutan
                        </h2>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-primary text-xl font-bold font-['Poppins']">
                                {{ $kth->nama_kth ?? '-' }}
                            </span>

                        </div>
                    </div>
                    <div
                        class="flex justify-end items-center gap-3 bg-white py-4 px-8 border-t border-gray-100 sticky bottom-0 flex-shrink-0">
                        <button type="button" onclick="closeDetailKTHAdminModal()"
                            class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-600 hover:text-white font-semibold text-sm transition-all duration-200">
                            Tutup
                        </button>
                        <button type="button"
                            onclick="openHapusKTHAdminModal({{ $kth->id }}, '{{ addslashes($kth->nama_kth) }}')"
                            class="px-6 py-2.5 rounded-xl bg-red-600 text-white hover:bg-red-700 font-semibold text-sm transition-all duration-200 flex items-center gap-2"
                            title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus KTH
                        </button>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="overflow-y-auto px-8 py-6 bg-gray-50">
                <div class="flex flex-col gap-6">
                    <div class="flex flex-wrap -mx-2 gap-3">
                        <div class="flex-1 min-w-[150px]">
                            <div class="bg-white rounded-2xl shadow-sm p-5 flex flex-col h-full">
                                <div class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                    Nama Kelompok
                                </div>
                                <div class="text-primary text-lg font-bold font-['Poppins'] mt-1 break-words">
                                    {{ $kth->nama_kth ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <div class="bg-white rounded-2xl shadow-sm p-5 flex flex-col h-full">
                                <div class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                    Kelas KTH
                                </div>
                                <div class="text-zinc-900 text-lg font-bold font-['Poppins'] mt-1">
                                    {{ $kth->kelas_kth ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <div class="bg-white rounded-2xl shadow-sm p-5 flex flex-col h-full">
                                <div class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                    Nomor Registrasi
                                </div>
                                <div class="text-zinc-900 text-lg font-bold font-['Poppins'] mt-1 break-words">
                                    {{ $kth->nomor_register ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <div class="bg-white rounded-2xl shadow-sm p-5 flex flex-col h-full">
                                <div class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                    Tanggal Terdaftar
                                </div>
                                <div class="text-zinc-900 text-lg font-bold font-['Poppins'] mt-1">
                                    {{ isset($kth->tanggal_register) && $kth->tanggal_register ? \Carbon\Carbon::parse($kth->tanggal_register)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-10 gap-4">
                        {{-- Kolom Kiri (30% = 3 dari 10) --}}
                        <div class="col-span-7 rounded">
                            <div class="flex-col">
                                <div class="flex-2 bg-white rounded-2xl shadow-sm p-6">
                                    {{-- Header dengan judul dan status --}}
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-emerald-900 text-lg font-bold font-['Poppins']">
                                            Sekretariat & Administrasi
                                        </h3>
                                        <div class="flex items-center gap-2">
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
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-bold {{ $statusBadge }}">
                                                <span class="w-2 h-2 rounded-full {{ $dotColor }}"></span>
                                                {{ ucfirst($statusVerifikasi) }}
                                            </span>
                                            @if (($kth->status_kth ?? '') == 'Aktif')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-200 text-primary">
                                                    Active
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-200 text-red-600">
                                                    Non-Active
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Konten --}}
                                    <div class="border-t border-gray-100 pt-4">
                                        <div class="grid grid-cols-2 gap-6">
                                            {{-- Kolom Kiri --}}
                                            <div>
                                                <div class="mb-6">
                                                    <div
                                                        class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                                        Alamat Sekretariat
                                                    </div>
                                                    <div
                                                        class="text-zinc-900 text-base font-normal font-inter mt-1 leading-relaxed">
                                                        {{ $kth->alamat ?? ($kth->desa ?? '-') }},<br>
                                                        Kec. {{ $kth->kecamatan ?? '-' }},
                                                        Kab. {{ $kth->kabupaten ?? '-' }}
                                                    </div>
                                                </div>

                                                <div class="flex gap-8">
                                                    <div>
                                                        <div
                                                            class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                                            Latitude
                                                        </div>
                                                        <div
                                                            class="text-emerald-900 text-base font-bold font-inter mt-1">
                                                            {{ $kth->latitude ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                                            Longitude
                                                        </div>
                                                        <div
                                                            class="text-emerald-900 text-base font-bold font-inter mt-1">
                                                            {{ $kth->longitude ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Kolom Kanan: Map --}}

                                            <div class="relative rounded-xl overflow-hidden border border-gray-200"
                                                style="height: 180px; width: 100%;">
                                                <div id="detailKTHAdminMapContainer" style="height: 100%; width: 100%;">
                                                </div>
                                                @if ($kth->latitude && $kth->longitude)
                                                    <div class="absolute inset-0 flex items-center justify-center">
                                                        <button onclick="openFullMapAdmin()"
                                                            class="px-3 py-1.5 bg-white/90 hover:bg-white rounded-full shadow-lg flex items-center gap-1.5 text-emerald-900 text-[10px] font-bold font-inter transition-all duration-200">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                                            </svg>
                                                            Lihat Peta Lengkap
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- Laporan Terkait --}}
                                <div class="bg-white rounded-2xl shadow-sm p-6 mt-5">
                                    <h3 class="text-primary text-lg font-bold font-['Poppins'] mb-4">
                                        Laporan Terkait
                                    </h3>
                                    <div class="border-t border-gray-100 pt-4 overflow-x-auto">
                                        <table class="w-full min-w-[700px]">
                                            <thead>
                                                <tr class="border-b border-gray-200">
                                                    <th
                                                        class="px-4 py-3 text-left text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                                        Periode
                                                    </th>
                                                    <th
                                                        class="px-4 py-3 text-left text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                                        Jenis Usaha
                                                    </th>
                                                    <th
                                                        class="px-4 py-3 text-left text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                                        Produksi
                                                    </th>
                                                    <th
                                                        class="px-4 py-3 text-left text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                                        Tanggal
                                                    </th>
                                                    <th
                                                        class="px-4 py-3 text-left text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                                        Status
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse(($kth->laporan ?? []) as $laporan)
                                                    <tr class="border-b border-gray-100 hover:bg-gray-50/50">
                                                        <td
                                                            class="px-4 py-3 text-zinc-900 text-sm font-normal font-inter">
                                                            {{ $laporan['periode'] ?? '-' }}
                                                        </td>
                                                        <td
                                                            class="px-4 py-3 text-zinc-900 text-sm font-normal font-inter">
                                                            {{ $laporan['jenis_usaha'] ?? '-' }}
                                                        </td>
                                                        <td
                                                            class="px-4 py-3 text-zinc-900 text-sm font-normal font-inter">
                                                            {{ $laporan['produksi'] ?? '-' }}
                                                        </td>
                                                        <td
                                                            class="px-4 py-3 text-zinc-900 text-sm font-normal font-inter">
                                                            {{ $laporan['tanggal'] ?? '-' }}
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            <span
                                                                class="px-3 py-1 bg-gray-100 rounded-full text-gray-600 text-xs font-bold font-inter">
                                                                {{ $laporan['status'] ?? 'DITERIMA' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5"
                                                            class="px-4 py-8 text-center text-gray-500 text-sm">
                                                            Belum ada laporan terkait
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan (70% = 7 dari 10) --}}
                        <div class="col-span-3 rounded">
                            <div class="flex-col">
                                {{-- Informasi Ketua (1/3) --}}
                                <div
                                    class="flex-none] bg-white rounded-2xl shadow-sm p-6 border-l-4 border-emerald-900">
                                    <h4
                                        class="text-neutral-600 text-xs font-bold font-inter uppercase tracking-wider mb-4">
                                        Informasi Ketua
                                    </h4>
                                    <div class="flex items-center gap-4 mb-3">
                                        <div
                                            class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                                            <span class="text-emerald-900 text-2xl font-bold font-inter">
                                                {{ Str::upper(substr($kth->nama_ketua ?? 'K', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="text-zinc-900 text-lg font-bold font-['Poppins']">
                                                {{ $kth->nama_ketua ?? '-' }}
                                            </div>
                                            <div class="text-neutral-500 text-sm font-normal font-inter">
                                                Ketua Kelompok
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 text-emerald-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-base font-bold font-inter">
                                            {{ $kth->no_hp_ketua ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="bg-white rounded-2xl shadow-sm p-6 mt-5">
                                    <h4
                                        class="text-neutral-600 text-xs font-bold font-inter uppercase tracking-wider mb-4">
                                        Petugas Input (Penyuluh)
                                    </h4>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                            <span class="text-neutral-500 text-sm font-normal font-inter">Nama
                                                Lengkap</span>
                                            <span class="text-zinc-900 text-sm font-bold font-inter">
                                                {{ $kth->penyuluh->nama_lengkap ?? '-' }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                            <span class="text-neutral-500 text-sm font-normal font-inter">NIP</span>
                                            <span class="text-zinc-900 text-sm font-bold font-inter">
                                                {{ $kth->penyuluh->nip ?? '-' }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                            <span class="text-neutral-500 text-sm font-normal font-inter">Golongan /
                                                Pangkat</span>
                                            <span class="text-zinc-900 text-sm font-bold font-inter">
                                                {{ $kth->penyuluh->golongan_pangkat ?? '-' }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                            <span
                                                class="text-neutral-500 text-sm font-normal font-inter">Jabatan</span>
                                            <span class="text-zinc-900 text-sm font-bold font-inter">
                                                {{ $kth->penyuluh->jabatan ?? '-' }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                            <span class="text-neutral-500 text-sm font-normal font-inter">No
                                                Telepon</span></span>
                                            <span class="text-zinc-900 text-sm font-bold font-inter">
                                                {{ $kth->penyuluh->no_telepon ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </dialog>

    @push('scripts')
        <script>
            // ============================================
            // MAP untuk Detail KTH Admin
            // ============================================
            let detailKTHAdminMap = null;
            let detailKTHAdminMarker = null;

            function initDetailKTHAdminMap(lat, lng) {
                const container = document.getElementById('detailKTHAdminMapContainer');
                if (!container) {
                    console.warn('Map container not found');
                    return;
                }

                // Cek apakah container terlihat
                if (container.offsetParent === null) {
                    console.warn('Map container is hidden');
                    return;
                }

                const defaultLat = lat || -7.0;
                const defaultLng = lng || 113.0;

                try {
                    if (detailKTHAdminMap) {
                        detailKTHAdminMap.remove();
                        detailKTHAdminMap = null;
                        detailKTHAdminMarker = null;
                    }

                    detailKTHAdminMap = L.map(container, {
                        center: [defaultLat, defaultLng],
                        zoom: 13,
                        zoomControl: true
                    });

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(detailKTHAdminMap);

                    if (lat && lng) {
                        detailKTHAdminMarker = L.marker([lat, lng], {
                            draggable: false
                        }).addTo(detailKTHAdminMap);
                    }

                    // Force invalidate size after map is rendered
                    setTimeout(() => {
                        if (detailKTHAdminMap) {
                            detailKTHAdminMap.invalidateSize();
                        }
                    }, 500);
                } catch (error) {
                    console.error('Error initializing map:', error);
                }
            }

            // ============================================
            // FUNGSI BUKA MODAL
            // ============================================
            window.openDetailKTHAdminModal = function(kthId) {
                const modal = document.getElementById('modalDetailKTHAdmin');
                if (modal) {
                    modal.showModal();
                    document.body.classList.add('overflow-hidden');

                    // Inisialisasi map setelah modal terbuka
                    setTimeout(() => {
                        @if ($kth && $kth->latitude && $kth->longitude)
                            initDetailKTHAdminMap({{ $kth->latitude }}, {{ $kth->longitude }});
                        @else
                            initDetailKTHAdminMap(null, null);
                        @endif
                    }, 800);
                }
            };

            // ============================================
            // FUNGSI TUTUP MODAL
            // ============================================
            function closeDetailKTHAdminModal() {
                const modal = document.getElementById('modalDetailKTHAdmin');
                if (modal) {
                    modal.close();
                    document.body.classList.remove('overflow-hidden');
                    if (detailKTHAdminMap) {
                        detailKTHAdminMap.remove();
                        detailKTHAdminMap = null;
                        detailKTHAdminMarker = null;
                    }
                }
            }

            // ============================================
            // FUNGSI BUKA PETA FULLSCREEN
            // ============================================
            function openFullMapAdmin() {
                const lat = {{ $kth->latitude ?? 'null' }};
                const lng = {{ $kth->longitude ?? 'null' }};
                if (lat && lng) {
                    window.open(`https://www.openstreetmap.org/?mlat=${lat}&mlon=${lng}&zoom=15`, '_blank');
                }
            }

            // ============================================
            // FUNGSI KONFIRMASI HAPUS
            // ============================================
            function confirmDeleteKTHAdmin(id, namaKth) {
                if (confirm(`Apakah Anda yakin ingin menghapus KTH "${namaKth}"?`)) {
                    document.getElementById('delete-form-admin-' + id).submit();
                }
            }

            // ============================================
            // EVENT LISTENER MODAL
            // ============================================
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('modalDetailKTHAdmin');
                if (modal) {
                    modal.addEventListener('close', function() {
                        document.body.classList.remove('overflow-hidden');
                        if (detailKTHAdminMap) {
                            detailKTHAdminMap.remove();
                            detailKTHAdminMap = null;
                            detailKTHAdminMarker = null;
                        }
                    });
                    modal.addEventListener('cancel', function() {
                        document.body.classList.remove('overflow-hidden');
                    });
                }
            });
        </script>
    @endpush
@else
    <dialog id="modalDetailKTHAdmin" class="w-full max-w-md mx-auto rounded-lg shadow-lg p-6 backdrop:bg-black/50">
        <p class="text-red-500 font-semibold">Data KTH tidak ditemukan.</p>
        <button onclick="closeDetailKTHAdminModal()" class="mt-4 bg-gray-200 px-4 py-2 rounded">Tutup</button>
    </dialog>
@endif
