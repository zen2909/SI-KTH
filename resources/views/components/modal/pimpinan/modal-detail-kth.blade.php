@props(['kth' => null])

@if ($kth)
    <dialog id="modalDetailKTHPimpinan"
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
                            <span class="text-primary text-xl font-bold font-['Poppins']" id="pimpinanKTHNama">
                                {{ $kth->nama_kth ?? '-' }}
                            </span>

                        </div>
                    </div>
                    <div
                        class="flex justify-end items-center gap-3 bg-white py-4 px-8 border-t border-gray-100 sticky bottom-0 flex-shrink-0">
                        <button type="button" onclick="closeDetailKTHPimpinanModal()"
                            class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-600 hover:text-white font-semibold text-sm transition-all duration-200">
                            Tutup
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
                                    id="pimpinanKTHNamaCard">
                                    {{ $kth->nama_kth ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <div class="bg-white rounded-2xl shadow-sm p-5 flex flex-col h-full">
                                <div class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                    Kelas KTH
                                </div>
                                <div class="text-zinc-900 text-lg font-bold font-['Poppins'] mt-1"
                                    id="pimpinanKTHKelas">
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
                                    id="pimpinanKTHRegistrasi">
                                    {{ $kth->nomor_register ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <div class="bg-white rounded-2xl shadow-sm p-5 flex flex-col h-full">
                                <div class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                    Tanggal Terdaftar
                                </div>
                                <div class="text-zinc-900 text-lg font-bold font-['Poppins'] mt-1"
                                    id="pimpinanKTHTanggal">
                                    {{ isset($kth->tanggal_register) && $kth->tanggal_register ? \Carbon\Carbon::parse($kth->tanggal_register)->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-10 gap-4">
                        {{-- Kolom Kiri (7 dari 10) --}}
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
                                                        id="pimpinanKTHAlamat">
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
                                                            id="pimpinanKTHLatitude">
                                                            {{ $kth->latitude ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                                            Longitude
                                                        </div>
                                                        <div class="text-emerald-900 text-base font-bold font-inter mt-1"
                                                            id="pimpinanKTHLongitude">
                                                            {{ $kth->longitude ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Kolom Kanan: Map --}}
                                            <div class="relative rounded-xl overflow-hidden border border-gray-200"
                                                style="height: 180px; width: 100%;">
                                                <div id="detailKTHPimpinanMapContainer"
                                                    style="height: 100%; width: 100%;">
                                                </div>
                                                @if ($kth->latitude && $kth->longitude)
                                                    <div class="absolute inset-0 flex items-center justify-center">
                                                        <button onclick="openFullMapPimpinan()"
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
                                                        class="px-4 py-3 text-center text-neutral-600 text-xs font-semibold font-inter uppercase tracking-wider">
                                                        Status
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="pimpinanKTHLaporanBody">
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

                        {{-- Kolom Kanan (3 dari 10) --}}
                        <div class="col-span-3 rounded">
                            <div class="flex-col">
                                {{-- Informasi Ketua --}}
                                <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-emerald-900">
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
                                                id="pimpinanKTHKetua">
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
                                        <span class="text-base font-bold font-inter" id="pimpinanKTHNoHP">
                                            {{ $kth->no_hp_ketua ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Petugas Input --}}
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
                                                id="pimpinanKTHPenyuluh">
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
            // ============================================
            // MAP untuk Detail KTH Pimpinan
            // ============================================
            let detailKTHPimpinanMap = null;
            let detailKTHPimpinanMarker = null;

            function initDetailKTHPimpinanMap(lat, lng) {
                const container = document.getElementById('detailKTHPimpinanMapContainer');
                if (!container) {
                    console.warn('Map container not found');
                    return;
                }

                if (container.offsetParent === null) {
                    console.warn('Map container is hidden');
                    return;
                }

                const defaultLat = lat || -7.0;
                const defaultLng = lng || 113.0;

                try {
                    if (detailKTHPimpinanMap) {
                        detailKTHPimpinanMap.remove();
                        detailKTHPimpinanMap = null;
                        detailKTHPimpinanMarker = null;
                    }

                    detailKTHPimpinanMap = L.map(container, {
                        center: [defaultLat, defaultLng],
                        zoom: 13,
                        zoomControl: true
                    });

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(detailKTHPimpinanMap);

                    if (lat && lng) {
                        detailKTHPimpinanMarker = L.marker([lat, lng], {
                            draggable: false
                        }).addTo(detailKTHPimpinanMap);
                    }

                    setTimeout(() => {
                        if (detailKTHPimpinanMap) {
                            detailKTHPimpinanMap.invalidateSize();
                        }
                    }, 500);
                } catch (error) {
                    console.error('Error initializing map:', error);
                }
            }

            // ============================================
            // FUNGSI BUKA MODAL DENGAN LOAD LAPORAN
            // ============================================
            window.openDetailKTHPimpinanModal = function(kthId) {
                const modal = document.getElementById('modalDetailKTHPimpinan');
                if (modal) {
                    modal.showModal();
                    document.body.classList.add('overflow-hidden');

                    // 🔥 Fetch data KTH termasuk laporan
                    fetch(`/pimpinan/kth/${kthId}`)
                        .then(response => response.json())
                        .then(data => {
                            // Update data di modal dengan data terbaru
                            updateKTHPimpinanDetailModal(data);

                            // Inisialisasi map
                            setTimeout(() => {
                                if (data.latitude && data.longitude) {
                                    initDetailKTHPimpinanMap(parseFloat(data.latitude), parseFloat(data
                                        .longitude));
                                } else {
                                    initDetailKTHPimpinanMap(null, null);
                                }
                            }, 600);
                        })
                        .catch(error => {
                            console.error('Error fetching KTH data:', error);
                        });
                }
            };

            // ============================================
            // FUNGSI UPDATE MODAL PIMPINAN
            // ============================================
            function updateKTHPimpinanDetailModal(data) {
                // Update nama di header
                const namaHeader = document.getElementById('pimpinanKTHNama');
                if (namaHeader) {
                    namaHeader.textContent = data.nama_kth || '-';
                }

                // Update nama di card
                const namaCard = document.getElementById('pimpinanKTHNamaCard');
                if (namaCard) {
                    namaCard.textContent = data.nama_kth || '-';
                }

                // Update kelas
                const kelas = document.getElementById('pimpinanKTHKelas');
                if (kelas) {
                    kelas.textContent = data.kelas_kth || '-';
                }

                // Update registrasi
                const registrasi = document.getElementById('pimpinanKTHRegistrasi');
                if (registrasi) {
                    registrasi.textContent = data.nomor_register || '-';
                }

                // Update tanggal
                const tanggal = document.getElementById('pimpinanKTHTanggal');
                if (tanggal && data.tanggal_register) {
                    tanggal.textContent = new Date(data.tanggal_register).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                }

                // Update alamat
                const alamat = document.getElementById('pimpinanKTHAlamat');
                if (alamat) {
                    alamat.innerHTML =
                        `${data.alamat || data.desa || '-'},<br>Kec. ${data.kecamatan || '-'}, Kab. ${data.kabupaten || '-'}`;
                }

                // Update latitude
                const latitude = document.getElementById('pimpinanKTHLatitude');
                if (latitude) {
                    latitude.textContent = data.latitude || '-';
                }

                // Update longitude
                const longitude = document.getElementById('pimpinanKTHLongitude');
                if (longitude) {
                    longitude.textContent = data.longitude || '-';
                }

                // Update ketua
                const ketua = document.getElementById('pimpinanKTHKetua');
                if (ketua) {
                    ketua.textContent = data.nama_ketua || '-';
                }

                // Update no HP
                const noHP = document.getElementById('pimpinanKTHNoHP');
                if (noHP) {
                    noHP.textContent = data.no_hp_ketua || '-';
                }

                // Update penyuluh
                const penyuluh = document.getElementById('pimpinanKTHPenyuluh');
                if (penyuluh && data.penyuluh) {
                    penyuluh.textContent = data.penyuluh.nama_lengkap || '-';
                }

                // 🔥 Update tabel laporan
                const tableBody = document.getElementById('pimpinanKTHLaporanBody');
                if (tableBody && data.laporan_kth) {
                    if (data.laporan_kth.length > 0) {
                        let html = '';
                        data.laporan_kth.forEach(laporan => {
                            const statusColors = {
                                'verified': 'bg-green-100 text-green-800',
                                'pending': 'bg-yellow-100 text-yellow-800',
                                'rejected': 'bg-red-100 text-red-800',
                            };
                            const statusLabels = {
                                'verified': 'Verified',
                                'pending': 'Pending',
                                'rejected': 'Rejected',
                            };
                            const periode = laporan.periode_laporan ? new Date(laporan.periode_laporan)
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
            // FUNGSI TUTUP MODAL
            // ============================================
            function closeDetailKTHPimpinanModal() {
                const modal = document.getElementById('modalDetailKTHPimpinan');
                if (modal) {
                    modal.close();
                    document.body.classList.remove('overflow-hidden');
                    if (detailKTHPimpinanMap) {
                        detailKTHPimpinanMap.remove();
                        detailKTHPimpinanMap = null;
                        detailKTHPimpinanMarker = null;
                    }
                }
            }

            // ============================================
            // FUNGSI BUKA PETA FULLSCREEN
            // ============================================
            function openFullMapPimpinan() {
                const lat = {{ $kth->latitude ?? 'null' }};
                const lng = {{ $kth->longitude ?? 'null' }};
                if (lat && lng) {
                    window.open(`https://www.openstreetmap.org/?mlat=${lat}&mlon=${lng}&zoom=15`, '_blank');
                }
            }

            // ============================================
            // EVENT LISTENER MODAL
            // ============================================
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('modalDetailKTHPimpinan');
                if (modal) {
                    modal.addEventListener('close', function() {
                        document.body.classList.remove('overflow-hidden');
                        if (detailKTHPimpinanMap) {
                            detailKTHPimpinanMap.remove();
                            detailKTHPimpinanMap = null;
                            detailKTHPimpinanMarker = null;
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
    <dialog id="modalDetailKTHPimpinan" class="w-full max-w-md mx-auto rounded-lg shadow-lg p-6 backdrop:bg-black/50">
        <p class="text-red-500 font-semibold">Data KTH tidak ditemukan.</p>
        <button onclick="closeDetailKTHPimpinanModal()" class="mt-4 bg-gray-200 px-4 py-2 rounded">Tutup</button>
    </dialog>
@endif
