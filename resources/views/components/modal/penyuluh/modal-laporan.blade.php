@props(['kth' => null, 'laporan' => null, 'mode' => 'create', 'kthOptions' => []])

<dialog id="modalLaporan"
    class="w-full max-w-4xl mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-3xl flex flex-col max-h-[90vh]">
        {{-- Header --}}
        <div class="bg-white border-b border-stone-300 sticky top-0 z-20 flex-shrink-0">
            <div class="flex items-center py-4 px-6">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="text-neutral-700 text-sm font-normal">Laporan KTH</span>
                        <svg class="w-4 h-5 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                        <span class="text-emerald-900 text-sm font-normal"
                            id="modalFormTitle">{{ $mode == 'edit' ? 'Edit' : 'Tambah' }} Laporan Baru</span>
                    </div>
                    <span class="text-zinc-900 text-base font-medium font-poppins" id="modalTitle">Formulir Pelaporan
                        KTH</span>
                </div>
                <button type="button" onclick="closeLaporanModal()"
                    class="ml-auto text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <p class="text-neutral-700 text-sm font-normal px-6 pb-4">Silakan lengkapi data laporan Kelompok Tani Hutan
                secara berkala untuk pemantauan perkembangan usaha.</p>
        </div>

        {{-- Body Form --}}
        <div class="overflow-y-auto flex-1 px-6 py-4 bg-white">
            <form
                action="{{ $mode == 'edit' ? route('penyuluh.laporan.update', $laporan->id ?? 0) : route('penyuluh.laporan.store') }}"
                method="POST" enctype="multipart/form-data" id="formLaporan">
                @csrf
                @if ($mode == 'edit')
                    @method('PUT')
                @endif

                {{-- Hidden ID --}}
                <input type="hidden" name="laporan_id" id="laporan_id" value="{{ $laporan->id ?? '' }}">
                <input type="hidden" name="id_kth" id="id_kth_hidden" value="{{ $kth->id ?? '' }}">

                {{-- 🔥 HIDDEN INPUT UNTUK STATUS VERIFIKASI --}}
                <input type="hidden" name="status_verifikasi_hidden" id="status_verifikasi_hidden"
                    value="{{ $laporan->status_verifikasi ?? 'pending' }}">

                {{-- Informasi Dasar --}}
                <div class="bg-white rounded-3xl shadow p-6 mb-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gray-300 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-900" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <span class="text-zinc-900 text-base font-medium font-poppins">Informasi Dasar</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Pilih KTH --}}
                        <div>
                            <label class="text-neutral-700 text-sm font-normal block mb-1">Pilih KTH</label>
                            <select name="id_kth" id="id_kth_select" required
                                class="w-full h-12 bg-gray-50 rounded-lg border border-zinc-200 px-4 text-sm focus:ring-2 focus:ring-emerald-900 focus:outline-none">
                                <option value="">Pilih Kelompok Tani Hutan...</option>
                                @if ($kthOptions && count($kthOptions) > 0)
                                    @foreach ($kthOptions as $option)
                                        <option value="{{ $option->id }}"
                                            {{ $kth && $kth->id == $option->id ? 'selected' : '' }}>
                                            {{ $option->nama_kth }}
                                        </option>
                                    @endforeach
                                @elseif($kth)
                                    <option value="{{ $kth->id }}" selected>{{ $kth->nama_kth }}</option>
                                @endif
                            </select>
                            <p class="text-xs text-gray-500 mt-1">* Hanya menampilkan KTH dengan status Pending atau
                                Verified</p>
                        </div>

                        {{-- Periode Laporan --}}
                        <div>
                            <label class="text-neutral-700 text-sm font-normal block mb-1">Periode Laporan</label>
                            <input type="date" name="periode_laporan" id="periode_laporan"
                                value="{{ old('periode_laporan', isset($laporan) && $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('Y-m-d') : '') }}"
                                class="w-full h-12 bg-gray-50 rounded-lg border border-zinc-200 px-4 text-sm focus:ring-2 focus:ring-emerald-900 focus:outline-none">
                        </div>
                    </div>

                    {{-- Jenis Usaha --}}
                    <div class="mt-3">
                        <label class="text-neutral-700 text-sm font-normal block mb-1">Jenis Usaha</label>
                        <input type="text" name="jenis_usaha" id="jenis_usaha"
                            value="{{ old('jenis_usaha', $laporan->jenis_usaha ?? '') }}"
                            placeholder="Contoh: Pengolahan Madu Hutan, Hasil Hutan Bukan Kayu (HHBK)"
                            class="w-full h-10 bg-white rounded-lg border border-gray-500 px-4 text-sm focus:ring-2 focus:ring-emerald-900 focus:outline-none">
                    </div>
                </div>

                {{-- Legalitas & Branding --}}
                <div class="bg-white rounded-3xl shadow p-6 mb-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gray-300 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-900" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-zinc-900 text-base font-medium font-poppins">Legalitas & Branding</span>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        {{-- NIB --}}
                        <div>
                            <label class="text-neutral-700 text-sm font-normal block mb-1">Nomor Induk Berusaha
                                (NIB)</label>
                            <input type="text" name="nib" id="nib"
                                value="{{ old('nib', $laporan->nib ?? '') }}" placeholder="Masukkan 13 digit NIB"
                                class="w-full h-10 bg-white rounded-lg border border-gray-500 px-4 text-sm focus:ring-2 focus:ring-emerald-900 focus:outline-none">
                        </div>

                        {{-- PIRT --}}
                        <div>
                            <label class="text-neutral-700 text-sm font-normal block mb-1">PIRT</label>
                            <input type="text" name="pirt" id="pirt"
                                value="{{ old('pirt', $laporan->pirt ?? '') }}" placeholder="Nomor PIRT"
                                class="w-full h-10 bg-white rounded-lg border border-gray-500 px-4 text-sm focus:ring-2 focus:ring-emerald-900 focus:outline-none">
                        </div>

                        {{-- Merek Dagang --}}
                        <div>
                            <label class="text-neutral-700 text-sm font-normal block mb-1">Merek Dagang</label>
                            <input type="text" name="merek_dagang" id="merek_dagang"
                                value="{{ old('merek_dagang', $laporan->merek_dagang ?? '') }}"
                                placeholder="Nama Merek (Jika ada)"
                                class="w-full h-10 bg-white rounded-lg border border-gray-500 px-4 text-sm focus:ring-2 focus:ring-emerald-900 focus:outline-none">
                        </div>
                    </div>
                </div>

                {{-- Data Produksi & Ekonomi --}}
                <div class="bg-white rounded-3xl shadow p-6 mb-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gray-300 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-900" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-zinc-900 text-base font-medium font-poppins">Data Produksi & Ekonomi</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Potensi Produksi --}}
                        <div>
                            <label class="text-neutral-700 text-sm font-normal block mb-1">Potensi Produksi</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="potensi_produksi" id="potensi_produksi"
                                    value="{{ old('potensi_produksi', $laporan->potensi_produksi ?? '') }}"
                                    placeholder="0" min="0" step="0.01"
                                    class="flex-1 h-10 bg-white rounded-lg border border-gray-500 px-4 text-sm focus:ring-2 focus:ring-emerald-900 focus:outline-none">
                                <select name="satuan_produksi" id="satuan_produksi"
                                    class="w-28 h-10 bg-gray-50 rounded-lg border border-gray-500 px-3 text-sm focus:ring-2 focus:ring-emerald-900 focus:outline-none">
                                    <option value="Kg"
                                        {{ old('satuan_produksi', $laporan->satuan_produksi ?? '') == 'Kg' ? 'selected' : '' }}>
                                        Kg</option>
                                    <option value="Ton"
                                        {{ old('satuan_produksi', $laporan->satuan_produksi ?? '') == 'Ton' ? 'selected' : '' }}>
                                        Ton</option>
                                    <option value="Liter"
                                        {{ old('satuan_produksi', $laporan->satuan_produksi ?? '') == 'Liter' ? 'selected' : '' }}>
                                        Liter</option>
                                    <option value="Unit"
                                        {{ old('satuan_produksi', $laporan->satuan_produksi ?? '') == 'Unit' ? 'selected' : '' }}>
                                        Unit</option>
                                </select>
                            </div>
                        </div>

                        {{-- NTE per Bulan --}}
                        <div>
                            <label class="text-neutral-700 text-sm font-normal block mb-1">NTE per Bulan (Rp)</label>
                            <div
                                class="flex items-center border border-gray-500 rounded-lg bg-white focus-within:ring-2 focus-within:ring-emerald-900">
                                <span
                                    class="px-3 text-gray-500 font-medium border-r border-gray-300 bg-gray-50 rounded-l-lg py-2 text-sm">
                                    Rp
                                </span>
                                <input type="number" name="nte_per_bulan" id="nte_per_bulan"
                                    value="{{ old('nte_per_bulan', isset($laporan) ? (int) $laporan->nte_per_bulan : '') }}"
                                    placeholder="0" min="0" step="1"
                                    class="flex-1 h-10 bg-transparent border-0 px-3 text-sm focus:ring-0 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                        </div>
                    </div>

                    {{-- Jangkauan Pemasaran --}}
                    <div class="mt-3">
                        <label class="text-neutral-700 text-sm font-normal block mb-1">Jangkauan Pemasaran</label>
                        <select name="jangkauan_pemasaran" id="jangkauan_pemasaran"
                            class="w-full h-12 bg-gray-50 rounded-lg border border-zinc-200 px-4 text-sm focus:ring-2 focus:ring-emerald-900 focus:outline-none">
                            <option value="">Pilih Jangkauan Pemasaran</option>
                            <option value="Lokal"
                                {{ old('jangkauan_pemasaran', $laporan->jangkauan_pemasaran ?? '') == 'Lokal' ? 'selected' : '' }}>
                                Lokal</option>
                            <option value="Regional"
                                {{ old('jangkauan_pemasaran', $laporan->jangkauan_pemasaran ?? '') == 'Regional' ? 'selected' : '' }}>
                                Regional</option>
                            <option value="Nasional"
                                {{ old('jangkauan_pemasaran', $laporan->jangkauan_pemasaran ?? '') == 'Nasional' ? 'selected' : '' }}>
                                Nasional</option>
                            <option value="Ekspor"
                                {{ old('jangkauan_pemasaran', $laporan->jangkauan_pemasaran ?? '') == 'Ekspor' ? 'selected' : '' }}>
                                Ekspor</option>
                        </select>
                    </div>
                </div>

                {{-- Operasional & Pengembangan --}}
                <div class="bg-white rounded-3xl shadow p-6 mb-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gray-300 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-900" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="text-zinc-900 text-base font-medium font-poppins">Operasional &
                            Pengembangan</span>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <div>
                            <label class="text-neutral-700 text-sm font-normal block mb-1">Kendala Usaha</label>
                            <textarea name="kendala_usaha" id="kendala_usaha" rows="2"
                                class="w-full bg-white rounded-lg border border-gray-500 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-900 focus:outline-none resize-none">{{ old('kendala_usaha', $laporan->kendala_usaha ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="text-neutral-700 text-sm font-normal block mb-1">Kebutuhan
                                Pengembangan</label>
                            <textarea name="kebutuhan_pengembangan" id="kebutuhan_pengembangan" rows="2"
                                class="w-full bg-white rounded-lg border border-gray-500 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-900 focus:outline-none resize-none">{{ old('kebutuhan_pengembangan', $laporan->kebutuhan_pengembangan ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="text-neutral-700 text-sm font-normal block mb-1">Keterangan Tambahan</label>
                            <textarea name="keterangan_tambahan" id="keterangan_tambahan" rows="2"
                                class="w-full bg-white rounded-lg border border-gray-500 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-900 focus:outline-none resize-none">{{ old('keterangan_tambahan', $laporan->keterangan_tambahan ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Upload Dokumen --}}
                <div class="bg-white rounded-3xl shadow p-6 mb-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gray-300 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-900" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </div>
                        <span class="text-zinc-900 text-base font-medium font-poppins">Upload Dokumen</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Upload Sertifikat Halal --}}
                        <div class="border-2 border-emerald-900/20 rounded-2xl p-4 text-center"
                            id="sertifikatContainer">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-14 text-emerald-900" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="text-zinc-900 text-sm font-semibold mt-2">📄 Upload Sertifikat
                                    Halal</span>
                                <span class="text-neutral-500 text-xs">Format: PDF, JPG, PNG (Max 5MB)</span>

                                {{-- File yang sudah diupload --}}
                                <div id="sertifikatFileInfo" class="mt-2 hidden">
                                    <div class="flex items-center gap-2 bg-green-50 px-3 py-1.5 rounded-lg">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm text-green-700" id="sertifikatFileName">file.pdf</span>
                                        <button type="button" onclick="removeSertifikat()"
                                            class="text-red-500 hover:text-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <input type="file" name="sertifikat_halal_file" accept=".pdf,.jpg,.jpeg,.png"
                                    class="hidden" id="sertifikat_halal_file" onchange="previewSertifikat(this)">
                                <button type="button"
                                    onclick="document.getElementById('sertifikat_halal_file').click()"
                                    class="mt-3 px-4 py-2 bg-emerald-900 text-white rounded-lg text-sm hover:bg-emerald-800 transition"
                                    id="sertifikatUploadBtn">
                                    Pilih File Sertifikat
                                </button>
                            </div>
                        </div>

                        {{-- Upload Dokumentasi --}}
                        <div class="border-2 border-stone-300 rounded-2xl p-4 text-center" id="dokumentasiContainer">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-14 text-neutral-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-zinc-900 text-sm font-semibold mt-2">📸 Upload Dokumentasi
                                    Kegiatan</span>
                                <span class="text-neutral-500 text-xs">Format: JPG, PNG, MP4 (Max 5 file, 10MB
                                    each)</span>

                                {{-- Daftar file yang sudah diupload --}}
                                <div id="dokumentasiFileList" class="mt-2 w-full space-y-1"></div>

                                <input type="file" name="dokumentasi[]" accept=".jpg,.jpeg,.png,.mp4" multiple
                                    class="hidden" id="dokumentasi" onchange="previewDokumentasi(this)">
                                <button type="button" onclick="document.getElementById('dokumentasi').click()"
                                    class="mt-3 px-4 py-2 bg-emerald-900 text-white rounded-lg text-sm hover:bg-emerald-800 transition"
                                    id="dokumentasiUploadBtn">
                                    Pilih File Dokumentasi
                                </button>
                                <p class="text-xs text-gray-400 mt-1" id="dokumentasiCount">0 dari 5 file</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div class="bg-zinc-100 border-t border-stone-300 py-4 px-6 sticky bottom-0 flex-shrink-0">
            <div class="flex justify-end items-center gap-3">
                <button type="button" onclick="closeLaporanModal()"
                    class="w-24 h-12 bg-gray-300 rounded-lg text-emerald-900 font-semibold hover:bg-gray-400 transition">
                    Batal
                </button>
                <button type="submit" form="formLaporan"
                    class="flex items-center justify-center gap-2 w-56 h-12 bg-emerald-900 rounded-lg text-white font-semibold hover:bg-emerald-800 transition px-4">
                    <svg class="w-5 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                    Simpan Laporan
                </button>
            </div>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // VARIABEL GLOBAL
    // ============================================
    let sertifikatFile = null;
    let sertifikatConfirmed = false;
    let dokumentasiFiles = [];
    const MAX_DOKUMENTASI = 5;

    // ============================================
    // FUNGSI FORMAT FILE SIZE
    // ============================================
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    // ============================================
    // FUNGSI UPDATE FILE INPUT
    // ============================================
    function updateFileInput() {
        const fileInput = document.getElementById('dokumentasi');
        if (!fileInput) return;

        const dataTransfer = new DataTransfer();
        let fileCount = 0;

        dokumentasiFiles.forEach(file => {
            // Hanya file yang sudah dikonfirmasi dan bukan existing yang dimasukkan
            if (file.confirmed && !file.isExisting && file.file) {
                dataTransfer.items.add(file.file);
                fileCount++;
            }
        });

        fileInput.files = dataTransfer.files;
        console.log(`File input updated: ${fileCount} files ready for upload`);
    }

    // ============================================
    // FUNGSI RENDER DOKUMENTASI LIST
    // ============================================
    function renderDokumentasiList() {
        const list = document.getElementById('dokumentasiFileList');
        const count = document.getElementById('dokumentasiCount');

        if (!list) return;

        list.innerHTML = '';

        if (dokumentasiFiles.length === 0) {
            const emptyDiv = document.createElement('div');
            emptyDiv.className = 'text-center text-gray-400 text-sm py-2';
            emptyDiv.innerHTML = `
            <svg class="w-8 h-8 mx-auto mb-1 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                </path>
            </svg>
            <span>Belum ada file dokumentasi</span>
        `;
            list.appendChild(emptyDiv);

            if (count) count.textContent = '0 dari 5 file';
            const btn = document.getElementById('dokumentasiUploadBtn');
            if (btn) btn.style.display = 'inline-flex';
            return;
        }

        dokumentasiFiles.forEach((file, index) => {
            const div = document.createElement('div');
            div.className =
                'flex items-center justify-between bg-green-50 px-3 py-1.5 rounded-lg text-sm cursor-pointer hover:bg-green-100 transition';

            // 🔥 TAMBAHKAN EVENT KLIK UNTUK PREVIEW
            div.addEventListener('click', function(e) {
                // Jangan trigger jika klik tombol hapus
                if (e.target.closest('button')) return;

                // 🔥 BUKA MODAL PREVIEW
                if (typeof window.openPreviewModal === 'function') {
                    // Buat data untuk preview
                    const previewData = {
                        name: file.name,
                        size: file.size,
                        extension: file.extension,
                        preview: file.preview || null,
                        type: file.type || 'image',
                        file: file.file || null
                    };

                    // Jika file existing (dari database), coba ambil dari URL
                    if (file.isExisting && file.file_path) {
                        previewData.preview = `/storage/${file.file_path}`;
                        previewData.type = 'image';
                    }

                    window.openPreviewModal(previewData, 'dokumentasi', index, function(action, data,
                        idx) {
                        if (action === 'confirm') {
                            console.log('File confirmed from preview:', data.name);
                            if (idx >= 0 && idx < dokumentasiFiles.length) {
                                dokumentasiFiles[idx].confirmed = true;
                                updateFileInput();
                            }
                            renderDokumentasiList();
                        } else if (action === 'cancel') {
                            console.log('File cancelled from preview:', data.name);
                            // Hanya hapus jika file bukan existing
                            if (!dokumentasiFiles[idx]?.isExisting) {
                                removeDokumentasi(idx);
                            }
                        }
                    });
                }
            });

            let iconHtml = file.isExisting ?
                `<svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>` :
                `<svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>`;

            div.innerHTML = `
            <div class="flex items-center gap-2 flex-1 min-w-0">
                ${iconHtml}
                <span class="text-green-700 truncate max-w-[120px]" title="${file.name}">${file.name}</span>
                <span class="text-xs text-gray-400 flex-shrink-0">(${file.size})</span>
                ${file.isExisting ? '<span class="text-xs text-blue-500 ml-1 flex-shrink-0">📎 tersimpan</span>' : ''}
                ${!file.isExisting && file.confirmed ? '<span class="text-xs text-green-600 ml-1 flex-shrink-0">✅</span>' : ''}
                ${!file.isExisting && !file.confirmed ? '<span class="text-xs text-yellow-500 ml-1 flex-shrink-0">⏳</span>' : ''}
                <span class="text-xs text-gray-400 ml-1 flex-shrink-0">(klik untuk preview)</span>
            </div>
            <button type="button" onclick="event.stopPropagation(); removeDokumentasi(${index})" class="text-red-500 hover:text-red-700 flex-shrink-0 ml-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
            list.appendChild(div);
        });

        if (count) {
            const confirmedCount = dokumentasiFiles.filter(f => f.confirmed).length;
            count.textContent =
                `${dokumentasiFiles.length} dari ${MAX_DOKUMENTASI} file (${confirmedCount} dikonfirmasi)`;
        }

        const btn = document.getElementById('dokumentasiUploadBtn');
        if (btn) {
            btn.style.display = dokumentasiFiles.length >= MAX_DOKUMENTASI ? 'none' : 'inline-flex';
        }
    }
    // ============================================
    // FUNGSI RESET SEMUA DATA
    // ============================================
    function resetAllData() {
        console.log('Reset all data');

        // 🔥 RESET SERTIFIKAT - BERSIHKAN SEPENUHNYA
        sertifikatFile = null;
        sertifikatConfirmed = false;
        const sertifikatInput = document.getElementById('sertifikat_halal_file');
        if (sertifikatInput) {
            sertifikatInput.value = ''; // Reset input file
            // 🔥 BUAT ULANG INPUT FILE UNTUK MENGHAPUS REFERENSI
            const newInput = sertifikatInput.cloneNode(true);
            sertifikatInput.parentNode.replaceChild(newInput, sertifikatInput);
            // Pasang ulang event listener
            newInput.id = 'sertifikat_halal_file';
            newInput.onchange = function() {
                previewSertifikat(this);
            };
        }
        const sertifikatInfo = document.getElementById('sertifikatFileInfo');
        if (sertifikatInfo) {
            sertifikatInfo.classList.add('hidden');
            sertifikatInfo.style.cursor = 'default';
            sertifikatInfo.onclick = null;
        }
        const sertifikatBtn = document.getElementById('sertifikatUploadBtn');
        if (sertifikatBtn) sertifikatBtn.style.display = 'inline-flex';

        // Reset dokumentasi
        dokumentasiFiles = [];
        const list = document.getElementById('dokumentasiFileList');
        if (list) list.innerHTML = '';
        const count = document.getElementById('dokumentasiCount');
        if (count) count.textContent = '0 dari 5 file';
        const dokumentasiInput = document.getElementById('dokumentasi');
        if (dokumentasiInput) {
            dokumentasiInput.value = '';
            // 🔥 BUAT ULANG INPUT FILE UNTUK MENGHAPUS REFERENSI
            const newDokInput = dokumentasiInput.cloneNode(true);
            dokumentasiInput.parentNode.replaceChild(newDokInput, dokumentasiInput);
            newDokInput.id = 'dokumentasi';
            newDokInput.onchange = function() {
                previewDokumentasi(this);
            };
        }
        const dokumentasiBtn = document.getElementById('dokumentasiUploadBtn');
        if (dokumentasiBtn) dokumentasiBtn.style.display = 'inline-flex';

        // Hapus hidden input deleted_dokumentasi
        const form = document.getElementById('formLaporan');
        if (form) {
            const deletedInputs = form.querySelectorAll('input[name="deleted_dokumentasi[]"]');
            deletedInputs.forEach(el => el.remove());
        }
    }

    // ============================================
    // FUNGSI REMOVE SERTIFIKAT
    // ============================================
    function removeSertifikat() {
        sertifikatFile = null;
        sertifikatConfirmed = false;

        // 🔥 SET FLAG SERTIFIKAT DIHAPUS
        window._sertifikatRemoved = true;

        const input = document.getElementById('sertifikat_halal_file');
        if (input) {
            input.value = '';
            const newInput = input.cloneNode(true);
            input.parentNode.replaceChild(newInput, input);
            newInput.id = 'sertifikat_halal_file';
            newInput.onchange = function() {
                previewSertifikat(this);
            };
        }

        const info = document.getElementById('sertifikatFileInfo');
        if (info) {
            info.classList.add('hidden');
            info.style.cursor = 'default';
            info.onclick = null;
        }

        document.getElementById('sertifikatUploadBtn').style.display = 'inline-flex';
    }

    // ============================================
    // FUNGSI REMOVE DOKUMENTASI
    // ============================================
    function removeDokumentasi(index) {
        if (index >= 0 && index < dokumentasiFiles.length) {
            const file = dokumentasiFiles[index];

            if (file.isExisting) {
                // File existing - tandai untuk dihapus
                const form = document.getElementById('formLaporan');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'deleted_dokumentasi[]';
                input.value = file.id;
                form.appendChild(input);

                // 🔥 UPDATE ORIGINAL DATA COUNT
                if (window._originalLaporanData) {
                    window._originalLaporanData.dokumentasi_count = Math.max(0, (window._originalLaporanData
                        .dokumentasi_count || 0) - 1);
                }
            }

            dokumentasiFiles.splice(index, 1);
            renderDokumentasiList();
            updateFileInput();
        }
    }

    // ============================================
    // FUNGSI PREVIEW SERTIFIKAT
    // ============================================
    function previewSertifikat(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            console.log('Sertifikat selected:', file.name);

            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file maksimal 5MB!');
                input.value = '';
                return;
            }

            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format file harus JPG, PNG, atau PDF!');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                // 🔥 BUAT FILE DATA DENGAN FILE BARU
                const fileData = {
                    name: file.name,
                    size: formatFileSize(file.size),
                    extension: file.name.split('.').pop().toUpperCase(),
                    preview: e.target.result,
                    type: file.type.startsWith('image/') ? 'image' : 'pdf',
                    file: file,
                    confirmed: false,
                    isExisting: false // 🔥 PASTIKAN BUKAN FILE EXISTING
                };

                // 🔥 SIMPAN KE SERTIFIKAT FILE
                sertifikatFile = fileData;

                // Tampilkan file sementara
                const info = document.getElementById('sertifikatFileInfo');
                const name = document.getElementById('sertifikatFileName');
                name.textContent = file.name;
                info.classList.remove('hidden');
                info.style.cursor = 'pointer';
                info.title = 'Klik untuk preview';
                info.onclick = function() {
                    if (typeof window.openPreviewModal === 'function') {
                        window.openPreviewModal(fileData, 'sertifikat', 0, function(action, data, index) {
                            if (action === 'confirm') {
                                console.log('Sertifikat dikonfirmasi');
                                sertifikatConfirmed = true;
                                sertifikatFile.confirmed = true;
                            } else if (action === 'cancel') {
                                console.log('Sertifikat dibatalkan');
                                removeSertifikat();
                            }
                        });
                    }
                };

                document.getElementById('sertifikatUploadBtn').style.display = 'none';

                // Buka modal preview
                if (typeof window.openPreviewModal === 'function') {
                    window.openPreviewModal(fileData, 'sertifikat', 0, function(action, data, index) {
                        if (action === 'confirm') {
                            console.log('Sertifikat dikonfirmasi');
                            sertifikatConfirmed = true;
                            sertifikatFile.confirmed = true;
                        } else if (action === 'cancel') {
                            console.log('Sertifikat dibatalkan');
                            removeSertifikat();
                        }
                    });
                }
            };
            reader.readAsDataURL(file);
        }
    }

    // ============================================
    // FUNGSI PREVIEW DOKUMENTASI
    // ============================================
    function previewDokumentasi(input) {
        console.log('Files selected:', input.files.length);

        const files = input.files;
        if (files.length === 0) return;

        const remaining = MAX_DOKUMENTASI - dokumentasiFiles.length;
        if (files.length > remaining) {
            alert(`Maksimal upload ${MAX_DOKUMENTASI} file. Tersisa ${remaining} slot.`);
            input.value = '';
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            console.log('Processing file:', file.name);

            if (file.size > 10 * 1024 * 1024) {
                alert(`File ${file.name} melebihi 10MB!`);
                continue;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const fileData = {
                    name: file.name,
                    size: formatFileSize(file.size),
                    extension: file.name.split('.').pop().toUpperCase(),
                    preview: e.target.result,
                    type: file.type.startsWith('image/') ? 'image' : 'video',
                    file: file,
                    confirmed: false
                };

                const tempIndex = dokumentasiFiles.length;
                dokumentasiFiles.push(fileData);
                renderDokumentasiList();

                if (typeof window.openPreviewModal === 'function') {
                    window.openPreviewModal(fileData, 'dokumentasi', tempIndex, function(action, data, index) {
                        if (action === 'confirm') {
                            console.log('File confirmed:', data.name);
                            if (index >= 0 && index < dokumentasiFiles.length) {
                                dokumentasiFiles[index].confirmed = true;
                                updateFileInput();
                            }
                            renderDokumentasiList();
                        } else if (action === 'cancel') {
                            console.log('File cancelled, removing:', data.name);
                            removeDokumentasi(index);
                        }
                    });
                }
            };
            reader.readAsDataURL(file);
        }

        input.value = '';
    }

    // ============================================
    // FUNGSI BUKA MODAL LAPORAN (CREATE)
    // ============================================
    window.openLaporanModal = function(mode = 'create', kthId = null) {
        const modal = document.getElementById('modalLaporan');
        const form = document.getElementById('formLaporan');

        // 🔥 RESET SEMUA DATA TERLEBIH DAHULU
        resetAllData();

        // Reset form fields
        const fields = ['laporan_id', 'id_kth_hidden', 'periode_laporan', 'jenis_usaha',
            'nib', 'pirt', 'merek_dagang', 'potensi_produksi', 'nte_per_bulan',
            'jangkauan_pemasaran', 'kendala_usaha', 'kebutuhan_pengembangan', 'keterangan_tambahan'
        ];
        fields.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });

        // 🔥 RESET SELECT JANGKAUAN PEMASARAN
        const jangkauanSelect = document.getElementById('jangkauan_pemasaran');
        if (jangkauanSelect) jangkauanSelect.value = '';

        // Set KTH jika ada
        const kthSelect = document.getElementById('id_kth_select');
        if (kthSelect) kthSelect.value = kthId || '';

        // Reset form action ke store
        if (form) {
            form.action = "{{ route('penyuluh.laporan.store') }}";
        }

        // Hapus method PUT jika ada
        const methodInput = form ? form.querySelector('input[name="_method"]') : null;
        if (methodInput) {
            methodInput.remove();
        }

        // Update title
        const title = document.getElementById('modalTitle');
        if (title) title.textContent = 'Formulir Pelaporan KTH';

        const formTitle = document.getElementById('modalFormTitle');
        if (formTitle) formTitle.textContent = 'Tambah Laporan Baru';

        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');
        }
    };

    // ============================================
    // FUNGSI BUKA MODAL LAPORAN (EDIT)
    // ============================================
    window.openEditLaporanModal = function(laporanId) {
        console.log('Opening edit modal for laporan ID:', laporanId);

        const modal = document.getElementById('modalLaporan');
        const title = document.getElementById('modalTitle');
        const formTitle = document.getElementById('modalFormTitle');

        if (title) title.textContent = 'Memuat data laporan...';
        if (formTitle) formTitle.textContent = 'Loading...';

        resetAllData();

        fetch(`/penyuluh/laporan/${laporanId}/edit-data`)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                console.log('Data laporan:', data);

                // 🔥 SIMPAN STATUS VERIFIKASI
                window._laporanStatusVerifikasi = data.status_verifikasi || 'pending';
                window._originalLaporanData = {
                    periode_laporan: data.periode_laporan || '',
                    jenis_usaha: data.jenis_usaha || '',
                    nib: data.nib || '',
                    pirt: data.pirt || '',
                    merek_dagang: data.merek_dagang || '',
                    potensi_produksi: data.potensi_produksi || '',
                    nte_per_bulan: data.nte_per_bulan || '',
                    jangkauan_pemasaran: data.jangkauan_pemasaran || '',
                    kendala_usaha: data.kendala_usaha || '',
                    kebutuhan_pengembangan: data.kebutuhan_pengembangan || '',
                    keterangan_tambahan: data.keterangan_tambahan || '',
                    nama_kth: data.nama_kth || 'Data KTH',
                    sertifikat_halal_file: data.sertifikat_halal_file || null,
                    dokumentasi_count: data.dokumentasi ? data.dokumentasi.length : 0
                };

                const form = document.getElementById('formLaporan');

                // 🔥 ISI FIELD SATU PER SATU
                // Laporan ID
                const laporanIdInput = document.getElementById('laporan_id');
                if (laporanIdInput) laporanIdInput.value = data.id;

                // KTH Hidden
                const kthHidden = document.getElementById('id_kth_hidden');
                if (kthHidden) kthHidden.value = data.id_kth;

                // 🔥 PERIODE LAPORAN - PASTIKAN FORMAT YYYY-MM-DD
                const periodeInput = document.getElementById('periode_laporan');
                if (periodeInput) {
                    periodeInput.value = data.periode_laporan || '';
                    console.log('Periode laporan diisi:', periodeInput.value);
                }

                // Field lainnya
                const fieldMapping = {
                    'jenis_usaha': data.jenis_usaha,
                    'nib': data.nib,
                    'pirt': data.pirt,
                    'merek_dagang': data.merek_dagang,
                    'potensi_produksi': data.potensi_produksi || 0,
                    'nte_per_bulan': data.nte_per_bulan || 0,
                    'jangkauan_pemasaran': data.jangkauan_pemasaran,
                    'kendala_usaha': data.kendala_usaha,
                    'kebutuhan_pengembangan': data.kebutuhan_pengembangan,
                    'keterangan_tambahan': data.keterangan_tambahan
                };

                Object.keys(fieldMapping).forEach(key => {
                    const el = document.getElementById(key);
                    if (el) {
                        el.value = fieldMapping[key] || '';
                    }
                });

                // 🔥 SATUAN PRODUKSI
                const satuanSelect = document.getElementById('satuan_produksi');
                if (satuanSelect) {
                    satuanSelect.value = data.satuan_produksi || 'Kg';
                }

                // 🔥 KTH SELECT
                const kthSelect = document.getElementById('id_kth_select');
                if (kthSelect) {
                    kthSelect.value = data.id_kth;
                }

                // 🔥 FORM ACTION
                if (form) {
                    const updateUrl = "{{ route('penyuluh.laporan.update', ['laporan' => ':id']) }}".replace(
                        ':id', laporanId);
                    form.action = updateUrl;
                }

                // 🔥 METHOD PUT
                let methodInput = form ? form.querySelector('input[name="_method"]') : null;
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    if (form) form.appendChild(methodInput);
                } else {
                    methodInput.value = 'PUT';
                }

                // 🔥 STATUS VERIFIKASI HIDDEN
                const statusHidden = document.getElementById('status_verifikasi_hidden');
                if (statusHidden) {
                    statusHidden.value = data.status_verifikasi || 'pending';
                }

                // Update title
                if (title) title.textContent = 'Edit Formulir Pelaporan KTH';
                if (formTitle) formTitle.textContent = 'Edit Laporan';

                // Tampilkan sertifikat jika ada
                if (data.sertifikat_halal_file) {
                    const info = document.getElementById('sertifikatFileInfo');
                    const name = document.getElementById('sertifikatFileName');
                    if (info && name) {
                        const fileName = data.sertifikat_halal_file.split('/').pop() || 'sertifikat.pdf';
                        name.textContent = fileName;
                        info.classList.remove('hidden');
                        document.getElementById('sertifikatUploadBtn').style.display = 'none';
                    }
                }

                // Tampilkan dokumentasi jika ada
                if (data.dokumentasi && data.dokumentasi.length > 0) {
                    dokumentasiFiles = data.dokumentasi.map(doc => {
                        const fileName = doc.file_name || doc.file_path.split('/').pop() ||
                            'dokumentasi.jpg';
                        return {
                            id: doc.id,
                            name: fileName,
                            size: formatFileSize(doc.size || 0),
                            extension: (fileName.split('.').pop() || 'jpg').toUpperCase(),
                            preview: `/storage/${doc.file_path}`,
                            type: 'image',
                            file: null,
                            confirmed: true,
                            isExisting: true,
                            file_path: doc.file_path
                        };
                    });
                    renderDokumentasiList();
                }

                // Buka modal
                if (modal) {
                    modal.showModal();
                    document.body.classList.add('no-scroll');
                }
            })
            .catch(error => {
                console.error('Error fetching laporan data:', error);
                alert('Gagal mengambil data laporan. Silakan refresh halaman dan coba lagi.');
                if (title) title.textContent = 'Formulir Pelaporan KTH';
                if (formTitle) formTitle.textContent = 'Edit Laporan';
            });
    };

    // ============================================
    // FUNGSI TUTUP MODAL LAPORAN
    // ============================================
    function closeLaporanModal() {
        const modal = document.getElementById('modalLaporan');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
    }

    // ============================================
    // HANDLE SUBMIT FORM DENGAN WARNING (UNTUK EDIT LAPORAN VERIFIED/REJECTED)
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formLaporan');

        if (form) {
            form.addEventListener('submit', function(e) {
                const laporanIdInput = document.getElementById('laporan_id');
                const laporanId = laporanIdInput ? laporanIdInput.value : '';

                const methodInput = form.querySelector('input[name="_method"]');
                const isEdit = methodInput && methodInput.value === 'PUT';

                if (!isEdit || !laporanId) {
                    return;
                }

                const statusVerifikasi = window._laporanStatusVerifikasi || 'pending';
                console.log('Status verifikasi laporan:', statusVerifikasi);

                if (statusVerifikasi === 'verified' || statusVerifikasi === 'rejected') {
                    e.preventDefault();

                    const changes = [];
                    const formData = new FormData(form);

                    const fieldLabels = {
                        'periode_laporan': 'Periode Laporan',
                        'jenis_usaha': 'Jenis Usaha',
                        'nib': 'NIB',
                        'pirt': 'PIRT',
                        'merek_dagang': 'Merek Dagang',
                        'potensi_produksi': 'Potensi Produksi',
                        'nte_per_bulan': 'NTE per Bulan',
                        'jangkauan_pemasaran': 'Jangkauan Pemasaran',
                        'kendala_usaha': 'Kendala Usaha',
                        'kebutuhan_pengembangan': 'Kebutuhan Pengembangan',
                        'keterangan_tambahan': 'Keterangan Tambahan'
                    };

                    const originalData = window._originalLaporanData || {};

                    // Cek perubahan text/select fields
                    Object.keys(fieldLabels).forEach(field => {
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

                    // 🔥 CEK PERUBAHAN SERTIFIKAT HALAL
                    const sertifikatInput = document.getElementById('sertifikat_halal_file');
                    const hasNewSertifikat = sertifikatInput && sertifikatInput.files &&
                        sertifikatInput
                        .files.length > 0;
                    const hasExistingSertifikat = originalData.sertifikat_halal_file || false;

                    if (hasNewSertifikat) {
                        // Ada sertifikat baru diupload
                        changes.push({
                            label: 'Sertifikat Halal',
                            old: hasExistingSertifikat ? 'File lama' : 'Tidak ada',
                            new: 'File baru: ' + sertifikatInput.files[0].name
                        });
                    } else if (hasExistingSertifikat && window._sertifikatRemoved) {
                        // Sertifikat dihapus
                        changes.push({
                            label: 'Sertifikat Halal',
                            old: 'File tersimpan',
                            new: 'Dihapus'
                        });
                    }

                    // 🔥 CEK PERUBAHAN DOKUMENTASI
                    const originalDokumentasiCount = originalData.dokumentasi_count || 0;
                    const currentDokumentasiCount = dokumentasiFiles.filter(f => f.confirmed &&
                        !f
                        .isExisting).length;
                    const deletedDokumentasi = form.querySelectorAll(
                        'input[name="deleted_dokumentasi[]"]');
                    const deletedCount = deletedDokumentasi.length;

                    if (currentDokumentasiCount > 0) {
                        changes.push({
                            label: 'Dokumentasi',
                            old: originalDokumentasiCount > 0 ?
                                originalDokumentasiCount +
                                ' file' : 'Tidak ada',
                            new: originalDokumentasiCount + currentDokumentasiCount +
                                ' file (' + currentDokumentasiCount + ' baru)'
                        });
                    } else if (deletedCount > 0) {
                        changes.push({
                            label: 'Dokumentasi',
                            old: originalDokumentasiCount + ' file',
                            new: (originalDokumentasiCount - deletedCount) + ' file (' +
                                deletedCount + ' dihapus)'
                        });
                    }

                    // Ambil periode dan nama KTH
                    const periode = originalData.periode_laporan || '-';
                    const namaKth = originalData.nama_kth || 'Data KTH';

                    // Buka modal warning
                    if (typeof window.openWarningLaporanModal === 'function') {
                        window.openWarningLaporanModal(
                            periode,
                            namaKth,
                            changes,
                            function() {
                                // Submit form setelah konfirmasi
                                form.submit();
                            }
                        );
                    } else {
                        if (confirm(
                                'Peringatan! Laporan ini sudah diverifikasi. Perubahan akan mengembalikan status ke Pending. Lanjutkan?'
                            )) {
                            form.submit();
                        }
                    }
                }
            });
        }
    });

    // ============================================
    // SIMPAN DATA ORIGINAL LAPORAN SAAT EDIT
    // ============================================
    // Override fungsi openEditLaporanModal untuk menyimpan data original
    const originalOpenEditLaporanModal = window.openEditLaporanModal;

    window.openEditLaporanModal = function(laporanId) {
        // Panggil fungsi asli
        originalOpenEditLaporanModal(laporanId);

        // Setelah data di-fetch, simpan data original
        fetch(`/penyuluh/laporan/${laporanId}/edit-data`)
            .then(response => response.json())
            .then(data => {
                window._originalLaporanData = {
                    periode_laporan: data.periode_laporan || '',
                    jenis_usaha: data.jenis_usaha || '',
                    nib: data.nib || '',
                    pirt: data.pirt || '',
                    merek_dagang: data.merek_dagang || '',
                    potensi_produksi: data.potensi_produksi || '',
                    nte_per_bulan: data.nte_per_bulan || '',
                    jangkauan_pemasaran: data.jangkauan_pemasaran || '',
                    kendala_usaha: data.kendala_usaha || '',
                    kebutuhan_pengembangan: data.kebutuhan_pengembangan || '',
                    keterangan_tambahan: data.keterangan_tambahan || ''
                };
                console.log('Original laporan data:', window._originalLaporanData);
            })
            .catch(error => {
                console.error('Error fetching original data:', error);
            });
    };

    document.addEventListener('DOMContentLoaded', function() {
        const nteInput = document.getElementById('nte_per_bulan');
        if (nteInput) {
            nteInput.addEventListener('blur', function() {
                if (this.value) {
                    // Hapus pemisah ribuan untuk penyimpanan
                    const cleanValue = this.value.replace(/\./g, '');
                    if (!isNaN(cleanValue) && cleanValue !== '') {
                        this.value = parseInt(cleanValue);
                    }
                }
            });
        }
    });


    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalLaporan');
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
