@props(['laporan' => null])

<dialog id="modalApproveLaporan"
    class="w-[380px] mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-3xl flex flex-col relative">

        {{-- Body --}}
        <div class="px-5 pt-4 pb-3">
            {{-- Icon dan Judul --}}
            <div class="flex items-center gap-2.5 mb-2.5">
                <div class="w-10 h-10 bg-green-200 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-zinc-900 font-poppins">Setujui Laporan</h3>
            </div>

            {{-- Pesan --}}
            <p class="text-xs text-neutral-700 text-center font-inter leading-relaxed">
                Laporan ini akan ditandai sebagai
                <span class="text-zinc-900 font-semibold">Terverifikasi</span>.
                Tindakan ini akan memberitahukan pengelola KTH
                dan mengunci data untuk periode ini.
            </p>

            {{-- Informasi Laporan --}}
            <div class="bg-zinc-100 rounded-xl p-3 border border-stone-300/30 mt-3">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] text-neutral-700 font-medium">Periode Laporan</span>
                    <span class="text-[11px] text-zinc-900 font-semibold" id="approvePeriode">
                        {{ isset($laporan) && $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('F Y') : '-' }}
                    </span>
                </div>
                <div class="w-full h-px bg-stone-300/30 my-1.5"></div>
                <div class="flex items-center justify-between">
                    <span class="text-[11px] text-neutral-700 font-medium">Nama KTH</span>
                    <span class="text-[11px] text-zinc-900 font-semibold" id="approveNamaKTH">
                        {{ $laporan->kth->nama_kth ?? '-' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-center gap-2.5 px-5 pb-3">
            <button type="button" onclick="closeApproveLaporanModal()"
                class="w-32 py-2 rounded-xl bg-gray-200 text-neutral-700 font-semibold text-xs hover:bg-gray-300 transition">
                Batal
            </button>
            <button type="button" onclick="confirmApproveLaporan()"
                class="w-32 py-2 bg-emerald-900 rounded-xl text-white font-semibold text-xs hover:bg-emerald-800 transition shadow">
                Ya, Setujui
            </button>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // VARIABEL GLOBAL
    // ============================================
    let approveLaporanCallback = null;
    let approveLaporanId = null;

    // ============================================
    // FUNGSI BUKA MODAL APPROVE LAPORAN
    // ============================================
    window.openApproveLaporanModal = function(laporanId, periode, namaKth, callback) {
        const modal = document.getElementById('modalApproveLaporan');
        const periodeEl = document.getElementById('approvePeriode');
        const namaEl = document.getElementById('approveNamaKTH');

        if (periodeEl) periodeEl.textContent = periode || '-';
        if (namaEl) namaEl.textContent = namaKth || '-';

        approveLaporanId = laporanId;
        approveLaporanCallback = callback;

        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');
        }
    };

    // ============================================
    // FUNGSI TUTUP MODAL APPROVE LAPORAN
    // ============================================
    function closeApproveLaporanModal() {
        const modal = document.getElementById('modalApproveLaporan');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
        approveLaporanId = null;
        approveLaporanCallback = null;
    }

    // ============================================
    // FUNGSI KONFIRMASI APPROVE LAPORAN
    // ============================================
    function confirmApproveLaporan() {
        if (typeof approveLaporanCallback === 'function' && approveLaporanId) {
            approveLaporanCallback(approveLaporanId);
        }
        closeApproveLaporanModal();
    }

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalApproveLaporan');
        if (modal) {
            modal.addEventListener('close', function() {
                document.body.classList.remove('no-scroll');
                approveLaporanId = null;
                approveLaporanCallback = null;
            });
            modal.addEventListener('cancel', function() {
                document.body.classList.remove('no-scroll');
                approveLaporanId = null;
                approveLaporanCallback = null;
            });
        }
    });
</script>
