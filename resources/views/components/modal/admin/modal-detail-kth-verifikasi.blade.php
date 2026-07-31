@props(['kth' => null])

@if ($kth)
    <dialog id="modalDetailVerifikasiKTH"
        class="w-full max-w-6xl mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

        <div class="bg-white rounded-3xl flex flex-col max-h-[90vh]">
            {{-- Header --}}
            <div class="flex items-start bg-white py-6 px-8 border-b border-gray-100 sticky top-0 z-20 flex-shrink-0">
                <div class="flex flex-col shrink-0 items-center mr-4 gap-2">
                    <div class="flex items-center gap-3">
                        <span class="text-[#0E4C34] text-[28px] font-bold">
                            {{ $kth->nama_kth ?? 'Detail KTH' }}
                        </span>

                    </div>
                </div>

                {{-- Tombol Close --}}
                <button type="button" onclick="closeDetailVerifikasiModal()"
                    class="ml-auto text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
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
                                            @if ($kth->status_verifikasi == 'verified')
                                                <span
                                                    class="px-2 py-1 bg-primary/10 rounded-lg inline-flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5 text-primary" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span
                                                        class="text-primary text-xs font-semibold font-inter leading-4">Verified</span>
                                                </span>
                                            @elseif($kth->status_verifikasi == 'pending')
                                                <span
                                                    class="px-2 py-1 bg-amber-100 rounded-lg inline-flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5 text-amber-800" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span
                                                        class="text-amber-800 text-xs font-semibold font-inter leading-4">Pending</span>
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-1 bg-red-100 rounded-lg inline-flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5 text-red-800" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span
                                                        class="text-red-800 text-xs font-semibold font-inter leading-4">Rejected</span>
                                                </span>
                                            @endif

                                            @if ($kth->status_kth == 'Aktif')
                                                <span
                                                    class="px-2.5 py-0.5 bg-green-100 rounded-full inline-flex items-center gap-1.5">
                                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                                    <span
                                                        class="text-green-800 text-xs font-medium font-inter leading-4">Aktif</span>
                                                </span>
                                            @else
                                                <span
                                                    class="px-2.5 py-0.5 bg-slate-100 rounded-full inline-flex items-center gap-1.5">
                                                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>
                                                    <span
                                                        class="text-slate-600 text-xs font-medium font-inter leading-4">Tidak
                                                        Aktif</span>
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

            {{-- Footer --}}
            <div
                class="flex justify-end items-center gap-3 bg-[#F8F9FA] py-4 px-8 border-t border-gray-100 sticky bottom-0 flex-shrink-0">
                <button type="button" onclick="closeDetailVerifikasiModal()"
                    class="w-28 py-2 rounded-xl border border-gray-600 text-gray-600 hover:bg-gray-600 hover:text-white font-semibold text-xs transition-all duration-200">
                    Tutup
                </button>
                @if ($kth && $kth->status_verifikasi == 'pending')
                    <button type="button"
                        onclick="openApproveFromDetail({{ $kth->id }}, '{{ addslashes($kth->nama_kth) }}')"
                        class="w-28 py-2 rounded-xl border border-primary text-primary hover:bg-primary hover:text-white font-semibold text-xs transition-all duration-200">
                        <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Setujui
                    </button>
                    <button type="button"
                        onclick="openRejectFromDetail({{ $kth->id }}, '{{ addslashes($kth->nama_kth) }}')"
                        class="w-28 py-2 rounded-xl border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-semibold text-xs transition-all duration-200">
                        <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Tolak
                    </button>
                @endif
            </div>
        </div>
    </dialog>

    <script>
        // ============================================
        // LEAFLET MAP untuk Detail Verifikasi Admin
        // ============================================
        let verifikasiDetailMap = null;
        let verifikasiDetailMarker = null;

        function initVerifikasiDetailMap(lat, lng) {
            const container = document.getElementById('detailKTHAdminMapContainer');
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
                if (verifikasiDetailMap) {
                    verifikasiDetailMap.remove();
                    verifikasiDetailMap = null;
                    verifikasiDetailMarker = null;
                }

                verifikasiDetailMap = L.map(container, {
                    center: [defaultLat, defaultLng],
                    zoom: 13,
                    zoomControl: true
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(verifikasiDetailMap);

                if (lat && lng) {
                    verifikasiDetailMarker = L.marker([lat, lng], {
                        draggable: false
                    }).addTo(verifikasiDetailMap);
                }

                setTimeout(() => {
                    if (verifikasiDetailMap) {
                        verifikasiDetailMap.invalidateSize();
                    }
                }, 500);
            } catch (error) {
                console.error('Error initializing map:', error);
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
        // FUNGSI BUKA DETAIL MODAL
        // ============================================
        window.openDetailVerifikasiModal = function(kthId) {
            const modal = document.getElementById('modalDetailVerifikasiKTH');
            if (modal) {
                modal.showModal();
                document.body.classList.add('no-scroll');

                setTimeout(() => {
                    @if ($kth && $kth->latitude && $kth->longitude)
                        initVerifikasiDetailMap({{ $kth->latitude }}, {{ $kth->longitude }});
                    @else
                        initVerifikasiDetailMap(null, null);
                    @endif
                }, 400);
            }
        };

        // ============================================
        // FUNGSI TUTUP DETAIL MODAL
        // ============================================
        function closeDetailVerifikasiModal() {
            const modal = document.getElementById('modalDetailVerifikasiKTH');
            if (modal) {
                modal.close();
                document.body.classList.remove('no-scroll');
                if (verifikasiDetailMap) {
                    verifikasiDetailMap.remove();
                    verifikasiDetailMap = null;
                    verifikasiDetailMarker = null;
                }
            }
        }

        // ============================================
        // FUNGSI APPROVE DARI DETAIL
        // ============================================
        function openApproveFromDetail(id, namaKth) {
            closeDetailVerifikasiModal();
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
        // FUNGSI REJECT DARI DETAIL
        // ============================================
        function openRejectFromDetail(id, namaKth) {
            closeDetailVerifikasiModal();
            if (typeof window.openRejectKTHModal === 'function') {
                window.openRejectKTHModal(id, namaKth);
            } else {
                alert('Modal reject tidak tersedia.');
            }
        }

        // ============================================
        // FUNGSI APPROVE KTH
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
                        timer: 1500,
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
        // EVENT LISTENER MODAL
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalDetailVerifikasiKTH');
            if (modal) {
                modal.addEventListener('close', function() {
                    document.body.classList.remove('no-scroll');
                    if (verifikasiDetailMap) {
                        verifikasiDetailMap.remove();
                        verifikasiDetailMap = null;
                        verifikasiDetailMarker = null;
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
    <dialog id="modalDetailVerifikasiKTH"
        class="w-full max-w-md mx-auto rounded-lg shadow-lg p-6 backdrop:bg-black/50">
        <p class="text-red-500 font-semibold">Data KTH tidak ditemukan.</p>
        <button onclick="closeDetailVerifikasiModal()" class="mt-4 bg-gray-200 px-4 py-2 rounded">Tutup</button>
    </dialog>
@endif
