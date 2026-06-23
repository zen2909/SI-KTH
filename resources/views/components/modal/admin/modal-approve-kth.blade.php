@props(['kth' => null])

<dialog id="modalApproveKTH"
    class="w-[380px] mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-3xl flex flex-col relative pb-5">
        {{-- Body --}}
        <div class="px-5 pt-6 pb-4">
            {{-- Icon --}}
            <div class="flex items-center justify-center mb-2.5">
                <div class="w-12 h-12 bg-green-200 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>

            {{-- Judul --}}
            <h3 class="text-lg font-semibold text-zinc-900 text-center font-poppins mb-3.5">
                Konfirmasi Persetujuan
            </h3>

            {{-- Informasi KTH --}}
            <div class="bg-zinc-100 rounded-xl px-3.5 py-3 border border-stone-300/20 mb-3 pl-2">
                <p class="text-[10px] font-medium text-neutral-500 uppercase tracking-wide ml-2">Nama Kelompok Tani
                    Hutan</p>
                <p class="text-sm font-medium text-emerald-900 font-poppins truncate ml-2" id="approveNamaKTH">
                    {{ $kth->nama_kth ?? 'Data KTH' }}
                </p>
            </div>

            {{-- Pesan --}}
            <p class="text-xs text-neutral-700 text-center font-inter leading-relaxed">
                Apakah Anda yakin ingin memverifikasi data ini?
                <span class="text-zinc-900 font-bold">Data ini akan berubah status menjadi Verified</span>
                dan akan segera dipublikasikan ke sistem manajemen regional.
            </p>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-center gap-2.5 px-5 pb-5 mb-4">
            <button type="button" onclick="closeApproveModal()"
                class="w-28 py-2 rounded-xl border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-semibold text-xs transition-all duration-200">
                Batalkan
            </button>
            <button type="button" onclick="confirmApprove()"
                class="w-32 py-2 bg-emerald-900 rounded-xl text-white font-semibold text-xs hover:bg-emerald-800 transition shadow flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Ya, Setujui
            </button>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // VARIABEL GLOBAL
    // ============================================
    let approveCallback = null;
    let approveKTHId = null;

    // ============================================
    // FUNGSI BUKA MODAL APPROVE
    // ============================================
    window.openApproveModal = function(kthId, namaKth, callback) {
        const modal = document.getElementById('modalApproveKTH');
        const namaElement = document.getElementById('approveNamaKTH');

        if (namaElement) {
            namaElement.textContent = namaKth || 'Data KTH';
        }

        approveKTHId = kthId;
        approveCallback = callback;

        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');
        }
    };

    // ============================================
    // FUNGSI TUTUP MODAL APPROVE
    // ============================================
    function closeApproveModal() {
        const modal = document.getElementById('modalApproveKTH');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
        approveKTHId = null;
        approveCallback = null;
    }

    // ============================================
    // FUNGSI KONFIRMASI APPROVE
    // ============================================
    function confirmApprove() {
        if (typeof approveCallback === 'function' && approveKTHId) {
            approveCallback(approveKTHId);
        }
        closeApproveModal();
    }

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalApproveKTH');
        if (modal) {
            modal.addEventListener('close', function() {
                document.body.classList.remove('no-scroll');
                approveKTHId = null;
                approveCallback = null;
            });
            modal.addEventListener('cancel', function() {
                document.body.classList.remove('no-scroll');
                approveKTHId = null;
                approveCallback = null;
            });
        }
    });
</script>
