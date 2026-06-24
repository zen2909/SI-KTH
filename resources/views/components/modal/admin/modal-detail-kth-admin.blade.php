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
                            <span class="text-primary text-xl font-bold font-['Poppins']" id="adminKTHNamaHeader">
                                {{ $kth->nama_kth ?? '-' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-end items-center gap-3">
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
                                <div class="text-primary text-lg font-bold font-['Poppins'] mt-1 break-words"
                                    id="adminKTHNamaCard">
                                    {{ $kth->nama_kth ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <div class="bg-white rounded-2xl shadow-sm p-5 flex flex-col h-full">
                                <div class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                    Kelas KTH
                                </div>
                                <div class="text-zinc-900 text-lg font-bold font-['Poppins'] mt-1" id="adminKTHKelas">
                                    {{ $kth->kelas_kth ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <div class="bg-white rounded-2xl shadow-sm p-5 flex flex-col h-full">
                                <div class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                    Nomor Registrasi
                                </div>
                                <div class="text-zinc-900 text-lg font-bold font-['Poppins'] mt-1 break-words"
                                    id="adminKTHRegistrasi">
                                    {{ $kth->nomor_register ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <div class="bg-white rounded-2xl shadow-sm p-5 flex flex-col h-full">
                                <div class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                    Tanggal Terdaftar
                                </div>
                                <div class="text-zinc-900 text-lg font-bold font-['Poppins'] mt-1" id="adminKTHTanggal">
                                    {{ isset($kth->tanggal_register) && $kth->tanggal_register ? \Carbon\Carbon::parse($kth->tanggal_register)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-10 gap-4">
                        {{-- Kolom Kiri --}}
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
                                                    <div class="text-zinc-900 text-base font-normal font-inter mt-1 leading-relaxed"
                                                        id="adminKTHAlamat">
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
                                                        <div class="text-emerald-900 text-base font-bold font-inter mt-1"
                                                            id="adminKTHLatitude">
                                                            {{ $kth->latitude ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                                            Longitude
                                                        </div>
                                                        <div class="text-emerald-900 text-base font-bold font-inter mt-1"
                                                            id="adminKTHLongitude">
                                                            {{ $kth->longitude ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Kolom Kanan: Map --}}
                                            <div class="relative rounded-xl overflow-hidden border border-gray-200"
                                                style="height: 180px; width: 100%;">
                                                <div id="adminDetailMapContainer" style="height: 100%; width: 100%;">
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
                                                        NTE / Bulan
                                                    </th>
                                                    <th
                                                        class="px-4 py-3 text-left text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                                        Status
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="adminKTHLaporanBody">
                                                @php
                                                    $laporans = $kth->laporanKth ?? collect();
                                                @endphp
                                                @forelse($laporans as $laporan)
                                                    <tr class="border-b border-gray-100 hover:bg-gray-50/50">
                                                        <td
                                                            class="px-4 py-3 text-zinc-900 text-sm font-normal font-inter">
                                                            {{ $laporan->periode_laporan ? $laporan->periode_laporan->format('M Y') : '-' }}
                                                        </td>
                                                        <td
                                                            class="px-4 py-3 text-zinc-900 text-sm font-normal font-inter">
                                                            {{ $laporan->jenis_usaha ?? '-' }}
                                                        </td>
                                                        <td
                                                            class="px-4 py-3 text-zinc-900 text-sm font-normal font-inter">
                                                            {{ $laporan->potensi_produksi ?? '-' }}
                                                            {{ $laporan->satuan_produksi ?? '' }}
                                                        </td>
                                                        <td
                                                            class="px-4 py-3 text-zinc-900 text-sm font-normal font-inter">
                                                            Rp
                                                            {{ number_format($laporan->nte_per_bulan ?? 0, 0, ',', '.') }}
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            @php
                                                                $statusColors = [
                                                                    'verified' => 'bg-green-100 text-green-800',
                                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                                    'rejected' => 'bg-red-100 text-red-800',
                                                                ];
                                                                $statusLabels = [
                                                                    'verified' => 'Verified',
                                                                    'pending' => 'Pending',
                                                                    'rejected' => 'Rejected',
                                                                ];
                                                            @endphp
                                                            <span
                                                                class="px-3 py-1 rounded-full text-xs font-bold font-inter {{ $statusColors[$laporan->status_verifikasi] ?? 'bg-gray-100 text-gray-600' }}">
                                                                {{ $statusLabels[$laporan->status_verifikasi] ?? $laporan->status_verifikasi }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5"
                                                            class="px-4 py-8 text-center text-gray-500 text-sm">
                                                            <div class="flex flex-col items-center gap-2">
                                                                <svg class="w-8 h-8 text-gray-400" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                <span class="text-sm">Belum ada laporan terkait</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-span-3 rounded">
                            <div class="flex-col">
                                {{-- Informasi Ketua --}}
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
                                            <div class="text-zinc-900 text-lg font-bold font-['Poppins']"
                                                id="adminKTHKetua">
                                                {{ $kth->nama_ketua ?? '-' }}
                                            </div>
                                            <div class="text-neutral-500 text-sm font-normal font-inter">
                                                Ketua KTH
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 text-emerald-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-base font-bold font-inter" id="adminKTHNoHP">
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
                                            <span class="text-zinc-900 text-sm font-bold font-inter"
                                                id="adminKTHPenyuluh">
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
                                                Telepon</span>
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
            (function() {
                'use strict';

                // ============================================
                // MAP untuk Detail KTH ADMIN
                // ============================================
                let adminDetailMap = null;
                let adminDetailMarker = null;

                window.initAdminDetailMap = function(lat, lng) {
                    console.log('📌 initAdminDetailMap called with:', lat, lng);

                    // PERUBAHAN: Gunakan ID baru
                    const container = document.getElementById('adminDetailMapContainer');
                    console.log('📦 Container found:', container);

                    if (!container) {
                        console.warn('❌ Map container not found');
                        return;
                    }

                    // Cek ukuran container
                    const rect = container.getBoundingClientRect();
                    console.log('📐 Container rect:', rect);

                    if (rect.width === 0 || rect.height === 0) {
                        console.warn('❌ Map container has zero size, retrying in 500ms...');
                        setTimeout(function() {
                            window.initAdminDetailMap(lat, lng);
                        }, 500);
                        return;
                    }

                    if (container.offsetParent === null) {
                        console.warn('❌ Map container is hidden, retrying in 500ms...');
                        setTimeout(function() {
                            window.initAdminDetailMap(lat, lng);
                        }, 500);
                        return;
                    }

                    const defaultLat = lat || -7.0;
                    const defaultLng = lng || 113.0;

                    try {
                        if (adminDetailMap) {
                            adminDetailMap.remove();
                            adminDetailMap = null;
                            adminDetailMarker = null;
                        }

                        console.log('🗺️ Creating map with center:', [defaultLat, defaultLng]);

                        adminDetailMap = L.map(container, {
                            center: [defaultLat, defaultLng],
                            zoom: 13,
                            zoomControl: true
                        });

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }).addTo(adminDetailMap);

                        if (lat && lng) {
                            console.log('📍 Adding marker at:', [lat, lng]);
                            adminDetailMarker = L.marker([lat, lng], {
                                draggable: false
                            }).addTo(adminDetailMap);
                        }

                        // Force invalidate size multiple times
                        setTimeout(function() {
                            if (adminDetailMap) {
                                console.log('🔄 Invalidating map size (1)');
                                adminDetailMap.invalidateSize();
                            }
                        }, 500);

                        setTimeout(function() {
                            if (adminDetailMap) {
                                console.log('🔄 Invalidating map size (2)');
                                adminDetailMap.invalidateSize();
                            }
                        }, 1000);

                        console.log('✅ Map initialized successfully');
                    } catch (error) {
                        console.error('❌ Error initializing map:', error);
                    }
                };

                // ============================================
                // FUNGSI BUKA MODAL ADMIN
                // ============================================
                window.openDetailKTHAdminModal = function(kthId) {
                    console.log('🚀 Opening admin modal for ID:', kthId);

                    const modal = document.getElementById('modalDetailKTHAdmin');
                    if (!modal) {
                        console.error('❌ Modal not found!');
                        return;
                    }

                    modal.showModal();
                    document.body.classList.add('overflow-hidden');

                    // Tunggu modal benar-benar terbuka
                    setTimeout(function() {
                        // Ambil data terbaru
                        fetch('/admin/kth/' + kthId)
                            .then(function(response) {
                                return response.json();
                            })
                            .then(function(data) {
                                console.log('📊 Data received:', data);

                                // Update data di modal
                                updateKTHAdminDetailModal(data);

                                // Inisialisasi map setelah data diupdate
                                setTimeout(function() {
                                    if (data.latitude && data.longitude) {
                                        window.initAdminDetailMap(
                                            parseFloat(data.latitude),
                                            parseFloat(data.longitude)
                                        );
                                    } else {
                                        window.initAdminDetailMap(null, null);
                                    }
                                }, 500);
                            })
                            .catch(function(error) {
                                console.error('❌ Error fetching KTH data:', error);
                            });
                    }, 300);
                };

                // ============================================
                // FUNGSI TUTUP MODAL ADMIN
                // ============================================
                window.closeDetailKTHAdminModal = function() {
                    const modal = document.getElementById('modalDetailKTHAdmin');
                    if (modal) {
                        modal.close();
                        document.body.classList.remove('overflow-hidden');

                        // Cleanup map
                        if (adminDetailMap) {
                            adminDetailMap.remove();
                            adminDetailMap = null;
                            adminDetailMarker = null;
                            console.log('🗑️ Map cleaned up');
                        }
                    }
                };

                // ============================================
                // FUNGSI UPDATE DATA MODAL ADMIN
                // ============================================
                function updateKTHAdminDetailModal(data) {
                    console.log('📝 Updating modal with data:', data);

                    // Update nama di header
                    var namaHeader = document.getElementById('adminKTHNamaHeader');
                    if (namaHeader) {
                        namaHeader.textContent = data.nama_kth || '-';
                    }

                    // Update nama di card
                    var namaCard = document.getElementById('adminKTHNamaCard');
                    if (namaCard) {
                        namaCard.textContent = data.nama_kth || '-';
                    }

                    // Update kelas
                    var kelas = document.getElementById('adminKTHKelas');
                    if (kelas) {
                        kelas.textContent = data.kelas_kth || '-';
                    }

                    // Update registrasi
                    var registrasi = document.getElementById('adminKTHRegistrasi');
                    if (registrasi) {
                        registrasi.textContent = data.nomor_register || '-';
                    }

                    // Update tanggal
                    var tanggal = document.getElementById('adminKTHTanggal');
                    if (tanggal && data.tanggal_register) {
                        tanggal.textContent = new Date(data.tanggal_register).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric'
                        });
                    }

                    // Update alamat
                    var alamat = document.getElementById('adminKTHAlamat');
                    if (alamat) {
                        alamat.innerHTML = (data.alamat || data.desa || '-') + ',<br>Kec. ' + (data.kecamatan || '-') +
                            ', Kab. ' + (data.kabupaten || '-');
                    }

                    // Update latitude
                    var latitude = document.getElementById('adminKTHLatitude');
                    if (latitude) {
                        latitude.textContent = data.latitude || '-';
                    }

                    // Update longitude
                    var longitude = document.getElementById('adminKTHLongitude');
                    if (longitude) {
                        longitude.textContent = data.longitude || '-';
                    }

                    // Update ketua
                    var ketua = document.getElementById('adminKTHKetua');
                    if (ketua) {
                        ketua.textContent = data.nama_ketua || '-';
                    }

                    // Update no HP
                    var noHP = document.getElementById('adminKTHNoHP');
                    if (noHP) {
                        noHP.textContent = data.no_hp_ketua || '-';
                    }

                    // Update penyuluh
                    var penyuluh = document.getElementById('adminKTHPenyuluh');
                    if (penyuluh && data.penyuluh) {
                        penyuluh.textContent = data.penyuluh.nama_lengkap || '-';
                    }

                    // Update tabel laporan
                    var tableBody = document.getElementById('adminKTHLaporanBody');
                    if (tableBody && data.laporan_kth) {
                        if (data.laporan_kth.length > 0) {
                            var html = '';
                            data.laporan_kth.forEach(function(laporan) {
                                var statusColors = {
                                    'verified': 'bg-green-100 text-green-800',
                                    'pending': 'bg-yellow-100 text-yellow-800',
                                    'rejected': 'bg-red-100 text-red-800',
                                };
                                var statusLabels = {
                                    'verified': 'Verified',
                                    'pending': 'Pending',
                                    'rejected': 'Rejected',
                                };
                                var periode = laporan.periode_laporan ? new Date(laporan.periode_laporan)
                                    .toLocaleDateString('id-ID', {
                                        month: 'short',
                                        year: 'numeric'
                                    }) : '-';

                                html += `
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50">
                                <td class="px-4 py-3 text-zinc-900 text-sm font-normal font-inter">${periode}</td>
                                <td class="px-4 py-3 text-zinc-900 text-sm font-normal font-inter">${laporan.jenis_usaha || '-'}</td>
                                <td class="px-4 py-3 text-zinc-900 text-sm font-normal font-inter">${laporan.potensi_produksi || '-'} ${laporan.satuan_produksi || ''}</td>
                                <td class="px-4 py-3 text-zinc-900 text-sm font-normal font-inter">Rp ${Number(laporan.nte_per_bulan || 0).toLocaleString('id-ID')}</td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold font-inter ${statusColors[laporan.status_verifikasi] || 'bg-gray-100 text-gray-600'}">
                                        ${statusLabels[laporan.status_verifikasi] || laporan.status_verifikasi}
                                    </span>
                                </td>
                            </tr>
                        `;
                            });
                            tableBody.innerHTML = html;
                        } else {
                            tableBody.innerHTML = `
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500 text-sm">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-sm">Belum ada laporan terkait</span>
                                </div>
                            </td>
                        </tr>
                    `;
                        }
                    }
                }

                // ============================================
                // FUNGSI BUKA PETA FULLSCREEN ADMIN
                // ============================================
                window.openFullMapAdmin = function() {
                    var lat = {{ $kth->latitude ?? 'null' }};
                    var lng = {{ $kth->longitude ?? 'null' }};
                    if (lat && lng) {
                        window.open('https://www.openstreetmap.org/?mlat=' + lat + '&mlon=' + lng + '&zoom=15',
                            '_blank');
                    }
                };

                // ============================================
                // FUNGSI HAPUS KTH ADMIN
                // ============================================
                window.openHapusKTHAdminModal = function(id, namaKth) {
                    if (confirm('Apakah Anda yakin ingin menghapus KTH "' + namaKth + '"?')) {
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/admin/kth/' + id;
                        form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                };

                // ============================================
                // EVENT LISTENER MODAL ADMIN
                // ============================================
                document.addEventListener('DOMContentLoaded', function() {
                    var modal = document.getElementById('modalDetailKTHAdmin');
                    if (modal) {
                        modal.addEventListener('close', function() {
                            document.body.classList.remove('overflow-hidden');
                            if (adminDetailMap) {
                                adminDetailMap.remove();
                                adminDetailMap = null;
                                adminDetailMarker = null;
                            }
                        });
                        modal.addEventListener('cancel', function() {
                            document.body.classList.remove('overflow-hidden');
                        });
                    }
                });

            })();
        </script>
    @endpush
@else
    <dialog id="modalDetailKTHAdmin" class="w-full max-w-md mx-auto rounded-lg shadow-lg p-6 backdrop:bg-black/50">
        <p class="text-red-500 font-semibold">Data KTH tidak ditemukan.</p>
        <button onclick="closeDetailKTHAdminModal()" class="mt-4 bg-gray-200 px-4 py-2 rounded">Tutup</button>
    </dialog>
@endif
