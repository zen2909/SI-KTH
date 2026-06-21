@props(['kth' => null, 'mode' => 'create'])

<dialog id="modalKTH"
    class="w-full max-w-4xl mx-auto rounded-2xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-2xl flex flex-col max-h-[90vh]">
        {{-- Header --}}
        <div class="flex items-start bg-[#F8F9FA] py-6 px-6 border-b border-gray-100 sticky top-0 z-20 flex-shrink-0">
            <div
                class="w-12 h-12 mr-4 flex items-center justify-center bg-[#0E4C34] rounded-xl text-white flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-[#0E4C34]" id="modalTitle">Formulir Kelompok Tani Hutan</h2>
                <p class="text-sm text-[#404943]">Lengkapi data administrasi dan geografis kelompok tani hutan
                </p>
            </div>
            <button type="button" onclick="closeKTHModal()"
                class="ml-auto text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        {{-- Body form --}}
        <div class="overflow-y-auto flex-1 px-6 py-4 bg-[#F8F9FA]">
            <form
                action="{{ $mode == 'edit' ? route('penyuluh.kth.update', ['kth' => $kth->id ?? 0]) : route('penyuluh.kth.store') }}"
                method="POST" enctype="multipart/form-data" id="formKTH">

                @csrf
                @if ($mode == 'edit')
                    @method('PUT')
                @endif

                {{-- Hidden ID untuk edit --}}
                <input type="hidden" name="kth_id" id="kth_id" value="{{ $kth->id ?? '' }}">

                <input type="hidden" name="status_verifikasi_hidden" id="status_verifikasi_hidden"
                    value="{{ $kth->status_verifikasi ?? 'pending' }}">

                {{-- Identitas Kelompok --}}
                <div class="bg-white rounded-lg shadow-sm p-6 mb-4">
                    <div class="flex items-center mb-6 gap-3">
                        <div class="w-10 h-10 bg-[#0E4C34] rounded-lg flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <span class="text-black text-xl font-semibold">Identitas Kelompok</span>
                    </div>

                    {{-- Nama KTH & Kelas --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="text-[#404943] text-sm font-bold block mb-1">Nama KTH *</label>
                            <input type="text" name="nama_kth" id="nama_kth"
                                value="{{ old('nama_kth', $kth->nama_kth ?? '') }}"
                                placeholder="Contoh: KTH Madani Lestari"
                                class="w-full bg-[#F3F4F5] rounded-lg border border-[#C0C9C1] px-4 py-3 text-sm focus:ring-2 focus:ring-[#0E4C34] focus:outline-none"
                                required>
                        </div>
                        <div>
                            <label class="text-[#404943] text-sm font-bold block mb-1">Kelas KTH *</label>
                            <select name="kelas_kth" id="kelas_kth" required
                                class="w-full bg-[#F3F4F5] rounded-lg border border-[#C0C9C1] px-4 py-3 text-sm focus:ring-2 focus:ring-[#0E4C34] focus:outline-none">
                                <option value="">Pilih Kelas</option>
                                <option value="Pemula"
                                    {{ old('kelas_kth', $kth->kelas_kth ?? '') == 'Pemula' ? 'selected' : '' }}>Pemula
                                </option>
                                <option value="Madya"
                                    {{ old('kelas_kth', $kth->kelas_kth ?? '') == 'Madya' ? 'selected' : '' }}>Madya
                                </option>
                                <option value="Utama"
                                    {{ old('kelas_kth', $kth->kelas_kth ?? '') == 'Utama' ? 'selected' : '' }}>Utama
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- Nomor Register & Tanggal Register --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[#404943] text-sm font-bold block mb-1">Nomor Register *</label>
                            <input type="text" name="nomor_register" id="nomor_register" required
                                value="{{ old('nomor_register', $kth->nomor_register ?? '') }}"
                                placeholder="Masukkan nomor register resmi"
                                class="w-full bg-[#F3F4F5] rounded-lg border border-[#C0C9C1] px-4 py-3 text-sm focus:ring-2 focus:ring-[#0E4C34] focus:outline-none">
                        </div>
                        <div>
                            <label class="text-[#404943] text-sm font-bold block mb-1">Tanggal Register *</label>
                            <input type="date" name="tanggal_register" id="tanggal_register" required
                                value="{{ old('tanggal_register', '') }}"
                                class="w-full bg-[#F3F4F5] rounded-lg border border-[#C0C9C1] px-4 py-3 text-sm focus:ring-2 focus:ring-[#0E4C34] focus:outline-none">
                        </div>
                    </div>
                </div>

                {{-- Lokasi & Kontak --}}
                <div class="bg-white rounded-lg shadow-sm p-6 mb-4">
                    <div class="flex items-center mb-6 gap-3">
                        <div class="w-10 h-10 bg-[#0E4C34] rounded-lg flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <span class="text-black text-xl font-semibold">Lokasi & Kontak</span>
                    </div>

                    {{-- Kabupaten, Kecamatan, Desa --}}
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="text-[#404943] text-sm font-bold block mb-1">Kabupaten *</label>
                            <input type="text" name="kabupaten" id="kabupaten" required
                                value="{{ old('kabupaten', $kth->kabupaten ?? 'Sumenep') }}"
                                placeholder="Contoh: Sumenep"
                                class="w-full bg-[#F3F4F5] rounded-lg border border-[#C0C9C1] px-4 py-3 text-sm focus:ring-2 focus:ring-[#0E4C34] focus:outline-none">
                        </div>
                        <div>
                            <label class="text-[#404943] text-sm font-bold block mb-1">Kecamatan *</label>
                            <input type="text" name="kecamatan" id="kecamatan" required
                                value="{{ old('kecamatan', $kth->kecamatan ?? '') }}" placeholder="Contoh: Cimenyan"
                                class="w-full bg-[#F3F4F5] rounded-lg border border-[#C0C9C1] px-4 py-3 text-sm focus:ring-2 focus:ring-[#0E4C34] focus:outline-none">
                        </div>
                        <div>
                            <label class="text-[#404943] text-sm font-bold block mb-1">Desa *</label>
                            <input type="text" name="desa" id="desa" required
                                value="{{ old('desa', $kth->desa ?? '') }}" placeholder="Contoh: Mandalamekar"
                                class="w-full bg-[#F3F4F5] rounded-lg border border-[#C0C9C1] px-4 py-3 text-sm focus:ring-2 focus:ring-[#0E4C34] focus:outline-none">
                        </div>
                    </div>

                    {{-- Nama Ketua & Nomor HP --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[#404943] text-sm font-bold block mb-1">Nama Ketua KTH *</label>
                            <input type="text" name="nama_ketua" id="nama_ketua" required
                                value="{{ old('nama_ketua', $kth->nama_ketua ?? '') }}"
                                placeholder="Masukkan nama lengkap ketua"
                                class="w-full bg-[#F3F4F5] rounded-lg border border-[#C0C9C1] px-4 py-3 text-sm focus:ring-2 focus:ring-[#0E4C34] focus:outline-none">
                        </div>
                        <div>
                            <label class="text-[#404943] text-sm font-bold block mb-1">Nomor HP Ketua *</label>
                            <input type="text" name="no_hp_ketua" id="no_hp_ketua" required
                                value="{{ old('no_hp_ketua', $kth->no_hp_ketua ?? '') }}" placeholder="08xxxxxxxxxx"
                                class="w-full bg-[#F3F4F5] rounded-lg border border-[#C0C9C1] px-4 py-3 text-sm focus:ring-2 focus:ring-[#0E4C34] focus:outline-none">
                        </div>
                    </div>
                </div>

                {{-- Status KTH --}}
                <div class="bg-white rounded-lg shadow-sm p-6 mb-4">
                    <div class="flex items-center mb-4 gap-3">
                        <div class="w-10 h-10 bg-[#0E4C34] rounded-lg flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-black text-xl font-semibold">Status KTH</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[#404943] text-sm font-bold block mb-1">Status KTH *</label>
                            <select name="status_kth" id="status_kth" required
                                class="w-full bg-[#F3F4F5] rounded-lg border border-[#C0C9C1] px-4 py-3 text-sm focus:ring-2 focus:ring-[#0E4C34] focus:outline-none"
                                onchange="toggleTahunTidakAktif(this.value)">
                                <option value="Aktif"
                                    {{ old('status_kth', $kth->status_kth ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>
                                    Aktif</option>
                                <option value="Tidak Aktif"
                                    {{ old('status_kth', $kth->status_kth ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>
                                    Tidak Aktif</option>
                            </select>
                        </div>
                        <div id="tahun_tidak_aktif_wrapper"
                            style="{{ old('status_kth', $kth->status_kth ?? 'Aktif') == 'Tidak Aktif' ? '' : 'display: none;' }}">
                            <label class="text-[#404943] text-sm font-bold block mb-1">
                                Tahun Tidak Aktif <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="tahun_tidak_aktif" id="tahun_tidak_aktif"
                                value="{{ old('tahun_tidak_aktif', $kth->tahun_tidak_aktif ?? '') }}"
                                placeholder="Contoh: 2024" min="2000" max="{{ date('Y') }}"
                                {{ old('status_kth', $kth->status_kth ?? 'Aktif') == 'Tidak Aktif' ? 'required' : '' }}
                                class="w-full bg-[#F3F4F5] rounded-lg border border-[#C0C9C1] px-4 py-3 text-sm focus:ring-2 focus:ring-[#0E4C34] focus:outline-none">
                        </div>
                    </div>
                </div>

                {{-- Lokasi Geografis dengan Leaflet --}}
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center mb-4 gap-3">
                        <div class="w-10 h-10 bg-[#0E4C34] rounded-lg flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                </path>
                            </svg>
                        </div>
                        <span class="text-black text-xl font-semibold">Lokasi Geografis</span>
                        <span class="text-xs text-gray-500 ml-2">(Klik peta untuk menentukan koordinat)</span>
                    </div>

                    {{-- Peta Leaflet --}}
                    <div class="bg-[#EDEEEF] rounded-lg border border-[#C0C9C133] shadow-sm overflow-hidden">
                        <div id="mapContainer" style="height: 350px; width: 100%;"></div>

                        {{-- Informasi koordinat --}}
                        <div
                            class="bg-[#0E4C340D] px-4 py-2 flex items-center justify-between border-t border-[#C0C9C133]">
                            <div class="flex items-center gap-4">
                                <span class="text-sm text-[#404943]">
                                    <span class="font-semibold">Latitude:</span>
                                    <span id="latitudeDisplay" class="text-[#0E4C34]">-</span>
                                </span>
                                <span class="text-sm text-[#404943]">
                                    <span class="font-semibold">Longitude:</span>
                                    <span id="longitudeDisplay" class="text-[#0E4C34]">-</span>
                                </span>
                            </div>
                            <button type="button" onclick="resetMapMarker()"
                                class="text-xs text-[#0E4C34] hover:text-[#1f4d36] font-medium">
                                Reset Posisi
                            </button>
                        </div>

                        {{-- Hidden fields untuk koordinat --}}
                        <input type="hidden" name="latitude" id="latitude"
                            value="{{ old('latitude', $kth->latitude ?? '') }}">
                        <input type="hidden" name="longitude" id="longitude"
                            value="{{ old('longitude', $kth->longitude ?? '') }}">
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div
            class="flex justify-end items-center bg-[#F8F9FA] py-4 px-6 border-t border-gray-100 sticky bottom-0 flex-shrink-0">
            <button type="button" onclick="closeKTHModal()"
                class="text-[#404943] text-sm font-bold mr-4 hover:text-gray-600 transition">
                Batal
            </button>
            <button type="submit" form="formKTH"
                class="flex items-center bg-[#0E4C34] text-white py-3 px-8 gap-2 rounded-lg shadow hover:bg-[#1f4d36] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm font-bold">Simpan Data</span>
            </button>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // LEAFLET MAP - Variabel global
    // ============================================
    let map = null;
    let marker = null;
    let isMapInitialized = false;

    // ============================================
    // FUNGSI TOGGLE TAHUN TIDAK AKTIF
    // ============================================
    function toggleTahunTidakAktif(status) {
        const wrapper = document.getElementById('tahun_tidak_aktif_wrapper');
        const input = document.getElementById('tahun_tidak_aktif');

        if (status === 'Tidak Aktif') {
            wrapper.style.display = 'block';
            input.setAttribute('required', 'required');
        } else {
            wrapper.style.display = 'none';
            input.removeAttribute('required');
            input.value = '';
        }
    }

    // ============================================
    // FUNGSI INISIALISASI MAP
    // ============================================
    function initMap(lat = -7.0, lng = 113.0) {
        if (isMapInitialized && map) {
            return;
        }

        const container = document.getElementById('mapContainer');
        if (!container) return;

        const defaultLat = -7.0;
        const defaultLng = 113.0;

        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        let initialLat = defaultLat;
        let initialLng = defaultLng;

        if (latInput && latInput.value && lngInput && lngInput.value) {
            initialLat = parseFloat(latInput.value);
            initialLng = parseFloat(lngInput.value);
        }

        map = L.map(container).setView([initialLat, initialLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        if (latInput && latInput.value && lngInput && lngInput.value) {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                marker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(map);
                updateCoordinateDisplay(lat, lng);
            }
        }

        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            setMarker(lat, lng);
        });

        if (marker) {
            marker.on('dragend', function(e) {
                const pos = marker.getLatLng();
                updateCoordinateDisplay(pos.lat, pos.lng);
            });
        }

        isMapInitialized = true;

        setTimeout(() => {
            if (map) {
                map.invalidateSize();
            }
        }, 300);
    }

    // ============================================
    // FUNGSI SET MARKER
    // ============================================
    function setMarker(lat, lng) {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            marker.on('dragend', function(e) {
                const pos = marker.getLatLng();
                updateCoordinateDisplay(pos.lat, pos.lng);
            });
        }

        updateCoordinateDisplay(lat, lng);
        map.setView([lat, lng], 15);
    }

    // ============================================
    // FUNGSI UPDATE DISPLAY KOORDINAT
    // ============================================
    function updateCoordinateDisplay(lat, lng) {
        const latDisplay = document.getElementById('latitudeDisplay');
        const lngDisplay = document.getElementById('longitudeDisplay');
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        const latFixed = lat.toFixed(7);
        const lngFixed = lng.toFixed(7);

        if (latDisplay) latDisplay.textContent = latFixed;
        if (lngDisplay) lngDisplay.textContent = lngFixed;
        if (latInput) latInput.value = latFixed;
        if (lngInput) lngInput.value = lngFixed;
    }

    // ============================================
    // FUNGSI RESET MARKER
    // ============================================
    function resetMapMarker() {
        const defaultLat = -7.0;
        const defaultLng = 113.0;
        setMarker(defaultLat, defaultLng);
    }

    // ============================================
    // FUNGSI BUKA MODAL (CREATE)
    // ============================================
    window.openKTHModal = function(mode = 'create', kthId = null) {
        const modal = document.getElementById('modalKTH');
        const title = document.getElementById('modalTitle');
        const form = document.getElementById('formKTH');

        // Reset form ke mode create
        document.getElementById('kth_id').value = '';
        document.getElementById('nama_kth').value = '';
        document.getElementById('kelas_kth').value = '';
        document.getElementById('nomor_register').value = '';
        document.getElementById('tanggal_register').value = '';
        document.getElementById('kabupaten').value = 'Sumenep';
        document.getElementById('kecamatan').value = '';
        document.getElementById('desa').value = '';
        document.getElementById('nama_ketua').value = '';
        document.getElementById('no_hp_ketua').value = '';
        document.getElementById('status_kth').value = 'Aktif';
        document.getElementById('tahun_tidak_aktif').value = '';
        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
        document.getElementById('latitudeDisplay').textContent = '-';
        document.getElementById('longitudeDisplay').textContent = '-';

        // 🔥 PERBAIKAN: Reset form action ke store
        form.action = "{{ route('penyuluh.kth.store') }}";

        // Hapus method PUT jika ada
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) {
            methodInput.remove();
        }

        title.textContent = 'Formulir Kelompok Tani Hutan (KTH)';

        // Hide tahun tidak aktif
        document.getElementById('tahun_tidak_aktif_wrapper').style.display = 'none';
        document.getElementById('tahun_tidak_aktif').removeAttribute('required');

        // Reset map
        isMapInitialized = false;
        if (map) {
            map.remove();
            map = null;
            marker = null;
        }

        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');

            setTimeout(() => {
                initMap();
            }, 400);
        }
    };

    function formatDateForInput(dateStr) {
        if (!dateStr) return '';
        // Jika format dd/mm/yyyy
        const parts = dateStr.split('/');
        if (parts.length === 3) {
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }
        // Jika sudah Y-m-d
        return dateStr;
    }
    // ============================================
    // FUNGSI BUKA MODAL (EDIT)
    // ============================================
    window.openEditKTHModal = function(id, nama_kth, kelas_kth, nomor_register, tanggal_register,
        kabupaten, kecamatan, desa, nama_ketua, no_hp_ketua,
        status_kth, tahun_tidak_aktif, latitude, longitude, status_verifikasi) {
        const modal = document.getElementById('modalKTH');
        const title = document.getElementById('modalTitle');
        const form = document.getElementById('formKTH');

        // Isi data ke form
        document.getElementById('kth_id').value = id;
        document.getElementById('nama_kth').value = nama_kth || '';
        document.getElementById('kelas_kth').value = kelas_kth || '';
        document.getElementById('nomor_register').value = nomor_register || '';
        document.getElementById('tanggal_register').value = tanggal_register || '';
        document.getElementById('kabupaten').value = kabupaten || 'Sumenep';
        document.getElementById('kecamatan').value = kecamatan || '';
        document.getElementById('desa').value = desa || '';
        document.getElementById('nama_ketua').value = nama_ketua || '';
        document.getElementById('no_hp_ketua').value = no_hp_ketua || '';
        document.getElementById('status_kth').value = status_kth || 'Aktif';
        document.getElementById('tahun_tidak_aktif').value = tahun_tidak_aktif || '';
        document.getElementById('latitude').value = latitude || '';
        document.getElementById('longitude').value = longitude || '';

        // 🔥 SIMPAN STATUS VERIFIKASI UNTUK VALIDASI
        const statusVerifikasiInput = document.getElementById('status_verifikasi_hidden');
        if (statusVerifikasiInput) {
            statusVerifikasiInput.value = status_verifikasi || 'pending';
        }

        // Update form action
        const updateUrl = "{{ route('penyuluh.kth.update', ['kth' => ':id']) }}".replace(':id', id);
        form.action = updateUrl;

        // Tambahkan method PUT
        let methodInput = form.querySelector('input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
        } else {
            methodInput.value = 'PUT';
        }

        title.textContent = 'Edit Kelompok Tani Hutan (KTH)';

        // Toggle tahun tidak aktif
        if (status_kth === 'Tidak Aktif') {
            document.getElementById('tahun_tidak_aktif_wrapper').style.display = 'block';
            document.getElementById('tahun_tidak_aktif').setAttribute('required', 'required');
        } else {
            document.getElementById('tahun_tidak_aktif_wrapper').style.display = 'none';
            document.getElementById('tahun_tidak_aktif').removeAttribute('required');
        }

        // Update display koordinat
        if (latitude && longitude) {
            document.getElementById('latitudeDisplay').textContent = latitude;
            document.getElementById('longitudeDisplay').textContent = longitude;
        }

        // Reset map
        isMapInitialized = false;
        if (map) {
            map.remove();
            map = null;
            marker = null;
        }

        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');

            setTimeout(() => {
                if (latitude && longitude) {
                    initMap(parseFloat(latitude), parseFloat(longitude));
                } else {
                    initMap();
                }
            }, 400);
        }
    };


    // ============================================
    // FUNGSI TUTUP MODAL
    // ============================================
    function closeKTHModal() {
        const modal = document.getElementById('modalKTH');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
    }

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalKTH');
        if (modal) {
            modal.addEventListener('close', function() {
                document.body.classList.remove('no-scroll');
            });
            modal.addEventListener('cancel', function() {
                document.body.classList.remove('no-scroll');
            });
        }
    });

    // ============================================
    // VALIDASI SUBMIT
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formKTH');
        if (form) {
            form.addEventListener('submit', function(e) {
                const lat = document.getElementById('latitude').value;
                const lng = document.getElementById('longitude').value;

                if (!lat || !lng) {
                    e.preventDefault();
                    alert('Mohon klik peta untuk menentukan koordinat lokasi KTH.');
                    return false;
                }
            });
        }
    });

    // ============================================
    // HANDLE SUBMIT FORM DENGAN WARNING (UNTUK EDIT DATA VERIFIED)
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formKTH');

        if (form) {
            form.addEventListener('submit', function(e) {
                // Ambil status verifikasi dari hidden input
                const statusVerifikasiInput = document.getElementById('status_verifikasi_hidden');
                const statusVerifikasi = statusVerifikasiInput ? statusVerifikasiInput.value :
                'pending';

                // Cek apakah mode edit (ada method PUT)
                const methodInput = form.querySelector('input[name="_method"]');
                const isEdit = methodInput && methodInput.value === 'PUT';

                // Hanya tampilkan warning jika mode edit dan status verified/rejected
                if (isEdit && (statusVerifikasi === 'verified' || statusVerifikasi === 'rejected')) {
                    e.preventDefault();

                    // Cari field yang berubah dengan detail
                    const changes = [];
                    const formData = new FormData(form);
                    const originalData = window._originalKTHData || {};

                    const fieldLabels = {
                        'nama_kth': 'Nama KTH',
                        'kelas_kth': 'Kelas KTH',
                        'nomor_register': 'Nomor Register',
                        'tanggal_register': 'Tanggal Register',
                        'kabupaten': 'Kabupaten',
                        'kecamatan': 'Kecamatan',
                        'desa': 'Desa',
                        'nama_ketua': 'Nama Ketua',
                        'no_hp_ketua': 'Nomor HP Ketua',
                        'status_kth': 'Status KTH',
                        'tahun_tidak_aktif': 'Tahun Tidak Aktif',
                        'latitude': 'Latitude',
                        'longitude': 'Longitude'
                    };

                    const fields = Object.keys(fieldLabels);
                    fields.forEach(field => {
                        const currentValue = formData.get(field) || '';
                        const originalValue = originalData[field] || '';
                        if (currentValue != originalValue) {
                            changes.push({
                                label: fieldLabels[field],
                                old: originalValue || '-',
                                new: currentValue || '-'
                            });
                        }
                    });

                    // Buat daftar field yang berubah untuk ditampilkan di judul
                    const fieldNames = changes.map(c => c.label);
                    const fieldChanged = fieldNames.length > 0 ?
                        fieldNames.slice(0, 3).join(', ') + (fieldNames.length > 3 ?
                            `, dan ${fieldNames.length - 3} field lainnya` : '') :
                        'Data KTH';

                    // Buka modal warning dengan detail perubahan
                    if (typeof window.openWarningModal === 'function') {
                        window.openWarningModal(fieldChanged, changes, function() {
                            // Submit form setelah konfirmasi
                            form.submit();
                        });
                    } else {
                        // Fallback
                        if (confirm(
                                `Peringatan! Data ini sudah diverifikasi. Perubahan akan mengembalikan status ke Pending. Lanjutkan?`
                                )) {
                            form.submit();
                        }
                    }
                }
            });
        }
    });

    // ============================================
    // SIMPAN DATA ORIGINAL SAAT EDIT
    // ============================================
    // Override fungsi openEditKTHModal untuk menyimpan data original
    const originalOpenEditKTHModal = window.openEditKTHModal;

    window.openEditKTHModal = function(id, nama_kth, kelas_kth, nomor_register, tanggal_register,
        kabupaten, kecamatan, desa, nama_ketua, no_hp_ketua,
        status_kth, tahun_tidak_aktif, latitude, longitude, status_verifikasi) {

        // 🔥 SIMPAN DATA ORIGINAL UNTUK PERBANDINGAN
        window._originalKTHData = {
            nama_kth: nama_kth || '',
            kelas_kth: kelas_kth || '',
            nomor_register: nomor_register || '',
            tanggal_register: tanggal_register || '',
            kabupaten: kabupaten || '',
            kecamatan: kecamatan || '',
            desa: desa || '',
            nama_ketua: nama_ketua || '',
            no_hp_ketua: no_hp_ketua || '',
            status_kth: status_kth || '',
            tahun_tidak_aktif: tahun_tidak_aktif || '',
            latitude: latitude || '',
            longitude: longitude || '',
            status_verifikasi: status_verifikasi || 'pending'
        };

        console.log('Data original tersimpan:', window._originalKTHData);

        // Panggil fungsi asli
        originalOpenEditKTHModal(id, nama_kth, kelas_kth, nomor_register, tanggal_register,
            kabupaten, kecamatan, desa, nama_ketua, no_hp_ketua,
            status_kth, tahun_tidak_aktif, latitude, longitude, status_verifikasi);
    };
</script>
