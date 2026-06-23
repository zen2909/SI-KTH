@props(['laporan' => null, 'fieldChanged' => null, 'changes' => null])

<dialog id="modalWarningLaporan"
    class="w-[380px] mx-auto rounded-2xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-2xl flex flex-col max-h-[85vh] relative">
        {{-- Tombol Close --}}
        <button type="button" onclick="closeWarningLaporanModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition z-10">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        {{-- Header dengan Icon --}}
        <div class="flex flex-col items-center pt-6 px-4">
            <div
                class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center mb-2.5 shadow-[0px_0px_20px_0px_rgba(245,158,11,0.20)]">
                <svg class="w-8 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>

            <h3 class="text-base font-semibold text-zinc-900 text-center font-poppins">
                Konfirmasi Perubahan
            </h3>
            <p class="text-xs text-neutral-700 text-center mt-1.5 font-inter leading-relaxed">
                Mengubah laporan yang sudah diverifikasi akan<br />
                mengembalikan status menjadi
                <span class="text-amber-700 font-bold">Pending</span> dan<br />
                memerlukan verifikasi ulang oleh Admin.
            </p>
        </div>

        {{-- Target Perubahan --}}
        <div class="mx-3.5 mt-3 p-2.5 bg-zinc-100 rounded-xl border border-stone-300">
            <div class="grid grid-cols-2 gap-1">
                <div>
                    <p class="text-[10px] text-neutral-500 font-medium">Periode Laporan:</p>
                    <p class="text-xs text-zinc-900 font-semibold" id="warningPeriode">-</p>
                </div>
                <div>
                    <p class="text-[10px] text-neutral-500 font-medium">Nama KTH:</p>
                    <p class="text-xs text-zinc-900 font-semibold" id="warningNamaKTH">-</p>
                </div>
            </div>
            {{-- Detail perubahan --}}
            <div id="warningChangesContainer" class="mt-2 space-y-0.5 border-t border-stone-200 pt-1.5">
                @if ($changes && count($changes) > 0)
                    @foreach ($changes as $change)
                        <div class="flex items-center justify-between text-[10px] py-0.5">
                            <span
                                class="font-medium text-neutral-600 w-20 flex-shrink-0 truncate">{{ $change['label'] }}</span>
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
            <button type="button" onclick="closeWarningLaporanModal()"
                class="w-28 py-1.5 rounded-full border-2 border-emerald-900 text-emerald-900 font-semibold text-xs hover:bg-emerald-50 transition">
                Batal
            </button>
            <button type="button" onclick="confirmEditLaporan()"
                class="w-32 py-1.5 rounded-full bg-emerald-900 text-white font-semibold text-xs hover:bg-emerald-800 transition flex items-center justify-center gap-1">
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
    let warningLaporanCallback = null;

    // ============================================
    // FUNGSI BUKA MODAL WARNING LAPORAN
    // ============================================
    window.openWarningLaporanModal = function(periode, namaKth, changes, callback) {
        const modal = document.getElementById('modalWarningLaporan');
        const periodeEl = document.getElementById('warningPeriode');
        const namaKthEl = document.getElementById('warningNamaKTH');
        const changesContainer = document.getElementById('warningChangesContainer');
        const noChangesMessage = document.getElementById('noChangesMessage');

        // Update periode dan nama KTH
        if (periodeEl) periodeEl.textContent = periode || '-';
        if (namaKthEl) namaKthEl.textContent = namaKth || '-';

        // Update detail perubahan
        if (changesContainer) {
            const items = changesContainer.querySelectorAll('.change-item');
            items.forEach(item => item.remove());

            if (changes && changes.length > 0) {
                if (noChangesMessage) noChangesMessage.style.display = 'none';

                changes.forEach(change => {
                    const div = document.createElement('div');
                    div.className = 'change-item flex items-center justify-between text-[10px] py-0.5';
                    div.innerHTML = `
                        <span class="font-medium text-neutral-600 w-20 flex-shrink-0 truncate">${change.label}</span>
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
        warningLaporanCallback = callback;

        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');
        }
    };

    // ============================================
    // FUNGSI TUTUP MODAL WARNING
    // ============================================
    function closeWarningLaporanModal() {
        const modal = document.getElementById('modalWarningLaporan');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
        warningLaporanCallback = null;
    }

    // ============================================
    // FUNGSI KONFIRMASI EDIT
    // ============================================
    function confirmEditLaporan() {
        if (typeof warningLaporanCallback === 'function') {
            warningLaporanCallback();
        }
        closeWarningLaporanModal();
    }

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalWarningLaporan');
        if (modal) {
            modal.addEventListener('close', function() {
                document.body.classList.remove('no-scroll');
                warningLaporanCallback = null;
            });
            modal.addEventListener('cancel', function() {
                document.body.classList.remove('no-scroll');
                warningLaporanCallback = null;
            });
        }
    });
</script>
