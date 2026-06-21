@props(['kth' => null, 'fieldChanged' => null, 'changes' => null])

<dialog id="modalWarningEdit"
    class="w-[380px] mx-auto rounded-2xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-2xl flex flex-col max-h-[85vh] relative">
        {{-- Tombol Close --}}
        <button type="button" onclick="closeWarningModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition z-10">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        {{-- Header dengan Icon --}}
        <div class="flex flex-col items-center pt-6 px-4">
            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mb-2.5">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>

            <h3 class="text-base font-semibold text-zinc-900 text-center font-poppins">
                Peringatan Edit Data Terverifikasi
            </h3>
            <p class="text-xs text-neutral-700 text-center mt-1.5 font-inter leading-relaxed px-1">
                Apakah Anda yakin ingin mengubah data KTH ini? Karena data sudah diverifikasi, setiap perubahan akan
                menyebabkan status verifikasi kembali menjadi
                <span class="text-emerald-900 font-bold">Pending</span> dan memerlukan persetujuan ulang dari Admin.
            </p>
        </div>

        {{-- Target Perubahan --}}
        <div class="mx-3.5 mt-3 p-2.5 bg-zinc-100 rounded-xl border border-stone-300 max-h-44 overflow-y-auto">
            <div class="flex items-center gap-2 mb-1.5">
                <div class="w-6 h-6 bg-green-200 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-3 h-3 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-[9px] font-medium text-neutral-700 uppercase tracking-wider">Target Perubahan</p>
                    <p class="text-[11px] font-semibold text-zinc-900 truncate max-w-[220px]" id="targetPerubahan">
                        {{ $fieldChanged ?? 'Data KTH' }}
                    </p>
                </div>
            </div>

            {{-- Detail Perubahan --}}
            <div id="changesContainer" class="mt-1 space-y-0.5 border-t border-stone-200 pt-1.5">
                @if ($changes && count($changes) > 0)
                    @foreach ($changes as $change)
                        <div class="flex items-center justify-between text-[10px] py-0.5">
                            <span
                                class="font-medium text-neutral-600 w-16 flex-shrink-0 truncate">{{ $change['label'] }}</span>
                            <div class="flex items-center gap-1 flex-1 ml-1">
                                <span
                                    class="text-red-600 line-through truncate max-w-[55px] text-[9px]">{{ $change['old'] ?: '-' }}</span>
                                <svg class="w-1.5 h-1.5 text-gray-400 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                                <span
                                    class="text-green-700 font-medium truncate max-w-[55px] text-[9px]">{{ $change['new'] ?: '-' }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-[9px] text-neutral-500 text-center py-1" id="noChangesMessage">Tidak ada perubahan
                        yang terdeteksi</p>
                @endif
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center justify-center gap-2 px-4 py-4">
            <button type="button" onclick="closeWarningModal()"
                class="w-28 py-1.5 rounded-full border-2 border-emerald-900 text-emerald-900 font-semibold text-xs hover:bg-emerald-50 transition">
                Batal
            </button>
            <button type="button" onclick="confirmEdit()"
                class="w-32 py-1.5 rounded-full bg-amber-500 text-white font-semibold text-xs hover:bg-amber-600 transition flex items-center justify-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Lanjutkan Edit
            </button>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // VARIABEL GLOBAL UNTUK CALLBACK
    // ============================================
    let warningCallback = null;

    // ============================================
    // FUNGSI BUKA MODAL WARNING
    // ============================================
    window.openWarningModal = function(fieldChanged, changes, callback) {
        const modal = document.getElementById('modalWarningEdit');
        const targetElement = document.getElementById('targetPerubahan');
        const changesContainer = document.getElementById('changesContainer');
        const noChangesMessage = document.getElementById('noChangesMessage');

        // Update target perubahan
        if (targetElement) {
            targetElement.textContent = fieldChanged || 'Data KTH';
        }

        // Update detail perubahan
        if (changesContainer) {
            // Hapus semua child kecuali noChangesMessage
            const items = changesContainer.querySelectorAll('.change-item');
            items.forEach(item => item.remove());

            if (changes && changes.length > 0) {
                if (noChangesMessage) noChangesMessage.style.display = 'none';

                changes.forEach(change => {
                    const div = document.createElement('div');
                    div.className = 'change-item flex items-center justify-between text-[10px] py-0.5';
                    div.innerHTML = `
                        <span class="font-medium text-neutral-600 w-16 flex-shrink-0 truncate">${change.label}</span>
                        <div class="flex items-center gap-1 flex-1 ml-1">
                            <span class="text-red-600 line-through truncate max-w-[55px] text-[9px]">${change.old || '-'}</span>
                            <svg class="w-1.5 h-1.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                            <span class="text-green-700 font-medium truncate max-w-[55px] text-[9px]">${change.new || '-'}</span>
                        </div>
                    `;
                    changesContainer.appendChild(div);
                });
            } else {
                if (noChangesMessage) noChangesMessage.style.display = 'block';
            }
        }

        // Simpan callback
        warningCallback = callback;

        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');
        }
    };

    // ============================================
    // FUNGSI TUTUP MODAL WARNING
    // ============================================
    function closeWarningModal() {
        const modal = document.getElementById('modalWarningEdit');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
        warningCallback = null;
    }

    // ============================================
    // FUNGSI KONFIRMASI EDIT
    // ============================================
    function confirmEdit() {
        if (typeof warningCallback === 'function') {
            warningCallback();
        }
        closeWarningModal();
    }

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalWarningEdit');
        if (modal) {
            modal.addEventListener('close', function() {
                document.body.classList.remove('no-scroll');
                warningCallback = null;
            });
            modal.addEventListener('cancel', function() {
                document.body.classList.remove('no-scroll');
                warningCallback = null;
            });
        }
    });
</script>
