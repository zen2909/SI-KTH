@props(['file' => null, 'type' => 'dokumentasi', 'index' => 0])

<dialog id="modalPreviewUpload"
    class="w-full max-w-2xl mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-3xl flex flex-col max-h-[90vh]">
        {{-- Header --}}
        <div class="flex items-center border-b border-stone-300/30 py-4 px-6">
            <div class="w-6 h-7 flex items-center justify-center">
                <svg class="w-5 h-4 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <span class="text-emerald-900 text-xl font-medium font-poppins ml-3">Pratinjau Unggah</span>
            <button type="button" onclick="closePreviewModal('cancel')"
                class="ml-auto text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="flex gap-6 p-6">
            {{-- Thumbnail --}}
            <div class="w-60 flex-shrink-0">
                <div class="w-60 h-60 bg-zinc-100 rounded-3xl overflow-hidden flex items-center justify-center">
                    <img src="" alt="Preview" class="w-full h-full object-cover hidden" id="previewImage">
                    <div id="previewPlaceholder" class="flex flex-col items-center">
                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="text-sm text-gray-500 mt-2">Preview tidak tersedia</span>
                    </div>
                </div>
                <p class="text-center text-neutral-500 text-sm mt-2" id="previewLabel">Pratinjau Thumbnail</p>
            </div>

            {{-- Detail File --}}
            <div class="flex-1 space-y-3">
                <div>
                    <p class="text-neutral-500 text-sm">Nama File</p>
                    <p class="text-zinc-900 font-poppins text-sm" id="previewFileName">-</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-neutral-500 text-sm">Tipe File</p>
                        <span class="inline-block px-3 py-1 bg-gray-300 rounded-full text-gray-600 text-sm"
                            id="previewFileType">-</span>
                    </div>
                    <div>
                        <p class="text-neutral-500 text-sm">Ukuran File</p>
                        <p class="text-zinc-900 font-semibold text-sm" id="previewFileSize">-</p>
                    </div>
                </div>
                <div class="bg-zinc-100 rounded-xl p-4 border border-stone-300/30">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-6 text-emerald-900 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <div>
                            <p class="text-neutral-700 text-sm">
                                Maksimal ukuran file <span class="font-semibold">5MB</span>.
                                Format yang diperbolehkan: <span class="text-emerald-900 font-medium">JPG, PNG,
                                    PDF</span>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end bg-zinc-100 py-4 px-6">
            <button type="button" onclick="closePreviewModal('cancel')"
                class="px-6 py-2.5 bg-gray-300 rounded-lg text-emerald-900 font-semibold hover:bg-gray-400 transition mr-3">
                Batal
            </button>
            <button type="button" onclick="confirmUpload()"
                class="flex items-center gap-2 px-6 py-2.5 bg-emerald-900 rounded-lg text-white font-semibold hover:bg-emerald-800 transition shadow">
                <svg class="w-4 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                    </path>
                </svg>
                <span>Unggah File</span>
            </button>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // VARIABEL GLOBAL
    // ============================================
    let previewCallback = null;
    let previewFileData = null;
    let previewFileIndex = null;
    let isConfirmed = false; // 🔥 TAMBAHKAN FLAG

    // ============================================
    // FUNGSI BUKA MODAL PREVIEW
    // ============================================
    window.openPreviewModal = function(file, type, index, callback) {
        const modal = document.getElementById('modalPreviewUpload');
        if (!modal) {
            console.error('Modal preview tidak ditemukan!');
            return;
        }

        // Reset flag
        isConfirmed = false;

        // Update data
        document.getElementById('previewFileName').textContent = file.name || '-';
        document.getElementById('previewFileType').textContent = file.extension || '-';
        document.getElementById('previewFileSize').textContent = file.size || '-';
        document.getElementById('previewLabel').textContent = type === 'sertifikat' ? 'Pratinjau Sertifikat' :
            'Pratinjau Thumbnail';

        const previewImg = document.getElementById('previewImage');
        const placeholder = document.getElementById('previewPlaceholder');

        // 🔥 CEK APAKAH ADA PREVIEW (BASE64 ATAU URL)
        if (file.preview) {
            previewImg.src = file.preview;
            previewImg.classList.remove('hidden');
            placeholder.classList.add('hidden');
        } else {
            previewImg.classList.add('hidden');
            placeholder.classList.remove('hidden');
            placeholder.innerHTML = `
            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                </path>
            </svg>
            <span class="text-sm text-gray-500 mt-2">Preview tidak tersedia</span>
        `;
        }

        // Simpan data dan callback
        previewFileData = file;
        previewFileIndex = index;
        previewCallback = callback;

        modal.showModal();
        document.body.classList.add('no-scroll');
    };

    // ============================================
    // FUNGSI TUTUP MODAL PREVIEW (BATAL)
    // ============================================
    function closePreviewModal() {
        const modal = document.getElementById('modalPreviewUpload');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }

        // 🔥 HANYA KIRIM CANCEL JIKA BELUM DIKONFIRMASI
        if (!isConfirmed && previewCallback) {
            console.log('Close preview - cancel');
            previewCallback('cancel', previewFileData, previewFileIndex);
        } else if (isConfirmed) {
            console.log('Close preview - already confirmed, skip cancel');
        }

        previewFileData = null;
        previewFileIndex = null;
        previewCallback = null;
    }

    // ============================================
    // FUNGSI KONFIRMASI UPLOAD
    // ============================================
    function confirmUpload() {
        console.log('Confirm upload button clicked');

        // 🔥 SET FLAG KONFIRMASI
        isConfirmed = true;

        if (previewCallback) {
            previewCallback('confirm', previewFileData, previewFileIndex);
        }

        // 🔥 TUTUP MODAL TANPA MENGIRIM CANCEL
        const modal = document.getElementById('modalPreviewUpload');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }

        previewFileData = null;
        previewFileIndex = null;
        previewCallback = null;
    }

    // ============================================
    // EVENT LISTENER
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalPreviewUpload');
        if (modal) {
            modal.addEventListener('close', function() {
                document.body.classList.remove('no-scroll');
                // 🔥 HANYA KIRIM CANCEL JIKA BELUM DIKONFIRMASI
                if (!isConfirmed && previewCallback) {
                    console.log('Modal closed - cancel');
                    previewCallback('cancel', previewFileData, previewFileIndex);
                }
                previewFileData = null;
                previewFileIndex = null;
                previewCallback = null;
            });
            modal.addEventListener('cancel', function() {
                document.body.classList.remove('no-scroll');
                // 🔥 HANYA KIRIM CANCEL JIKA BELUM DIKONFIRMASI
                if (!isConfirmed && previewCallback) {
                    console.log('Modal cancelled (ESC) - cancel');
                    previewCallback('cancel', previewFileData, previewFileIndex);
                }
                previewFileData = null;
                previewFileIndex = null;
                previewCallback = null;
            });
        }
    });
</script>
