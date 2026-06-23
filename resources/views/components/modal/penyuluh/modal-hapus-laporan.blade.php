@props(['laporan' => null])

<dialog id="modalHapusLaporan"
    class="w-[380px] mx-auto rounded-2xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-2xl flex flex-col max-h-[85vh] relative">
        {{-- Tombol Close --}}
        <button type="button" onclick="closeHapusLaporanModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition z-10">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        {{-- Header dengan Icon --}}
        <div class="flex flex-col items-center pt-6 px-4">
            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mb-3">
                <svg class="w-7 h-7 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </div>

            <h3 class="text-lg font-semibold text-zinc-900 text-center font-poppins">
                Hapus Laporan KTH?
            </h3>
            <p class="text-xs text-neutral-700 text-center mt-1.5 font-inter leading-relaxed">
                Apakah Anda yakin ingin menghapus<br />
                laporan ini? Tindakan ini tidak dapat<br />
                dibatalkan.
            </p>
        </div>

        {{-- Target Identitas --}}
        <div class="mx-3.5 mt-3 p-3 bg-zinc-100 rounded-xl border border-stone-300">
            <div class="grid grid-cols-2 gap-1">
                <div>
                    <p class="text-[10px] text-neutral-500 font-medium">Periode</p>
                    <p class="text-xs text-zinc-900 font-semibold" id="hapusPeriode">-</p>
                </div>
                <div>
                    <p class="text-[10px] text-neutral-500 font-medium">Nama KTH</p>
                    <p class="text-xs text-zinc-900 font-semibold" id="hapusNamaKTH">-</p>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex flex-col items-center gap-2.5 px-4 py-5">
            <form id="formHapusLaporan" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-64 py-3 rounded-xl bg-red-700 text-white font-semibold text-sm hover:bg-red-800 transition flex items-center justify-center gap-2 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    Ya, Hapus
                </button>
            </form>
            <button type="button" onclick="closeHapusLaporanModal()"
                class="w-64 py-3 rounded-xl border-2 border-neutral-500 text-neutral-700 font-semibold text-sm hover:bg-neutral-50 transition">
                Batal
            </button>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // FUNGSI BUKA MODAL HAPUS LAPORAN
    // ============================================
    window.openHapusLaporanModal = function(laporanId, periode, namaKth) {
        const modal = document.getElementById('modalHapusLaporan');
        const periodeEl = document.getElementById('hapusPeriode');
        const namaKthEl = document.getElementById('hapusNamaKTH');
        const form = document.getElementById('formHapusLaporan');

        // Update data
        if (periodeEl) periodeEl.textContent = periode || '-';
        if (namaKthEl) namaKthEl.textContent = namaKth || '-';

        // Update form action
        if (form) {
            const url = "{{ route('penyuluh.laporan.destroy', ['laporan' => ':id']) }}".replace(':id', laporanId);
            form.action = url;
        }

        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');
        }
    };

    // ============================================
    // FUNGSI TUTUP MODAL HAPUS LAPORAN
    // ============================================
    function closeHapusLaporanModal() {
        const modal = document.getElementById('modalHapusLaporan');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
    }

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalHapusLaporan');
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
