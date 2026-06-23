@props(['laporan' => null])

<dialog id="modalRejectLaporan"
    class="w-[420px] mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-3xl flex flex-col relative">
        {{-- Tombol Close --}}
        <button type="button" onclick="closeRejectLaporanModal()"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition z-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        {{-- Body --}}
        <div class="px-5 pt-5 pb-4">
            {{-- Header --}}
            <div class="mb-3">
                <h3 class="text-2xl font-semibold text-zinc-900 font-poppins">Tolak Laporan</h3>
                <p class="text-sm text-neutral-700 font-inter mt-1">Pastikan alasan penolakan sudah sesuai dengan
                    regulasi KTH.</p>
            </div>

            {{-- Informasi Laporan --}}
            <div class="bg-zinc-100 rounded-xl p-3.5 border border-stone-300/30 mb-4">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium text-neutral-700 uppercase tracking-wide">Periode Laporan</span>
                    <span class="text-sm font-semibold text-zinc-900" id="rejectPeriode">
                        {{ isset($laporan) && $laporan->periode_laporan ? \Carbon\Carbon::parse($laporan->periode_laporan)->format('F Y') : '-' }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-neutral-700 uppercase tracking-wide">Nama KTH</span>
                    <span class="text-sm font-semibold text-zinc-900" id="rejectNamaKTH">
                        {{ $laporan->kth->nama_kth ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- Form Catatan Penolakan --}}
            <form id="rejectLaporanForm" method="POST" action="">
                @csrf
                <div class="mb-1">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-zinc-900">Catatan Penolakan</span>
                        <span class="text-xs text-red-600 font-medium">*Wajib diisi</span>
                    </div>
                    <div>
                        <input type="text" name="catatan_revisi" id="catatan_revisi_laporan" required
                            class="w-full mt-1.5 px-3.5 py-2.5 bg-gray-50 rounded-xl border border-stone-300 focus:ring-2 focus:ring-emerald-900 focus:outline-none text-sm placeholder:text-neutral-400"
                            placeholder="Berikan alasan mengapa laporan ini ditolak...">
                        {{-- 🔥 PESAN ERROR DI BAWAH INPUT --}}
                        <p id="errorCatatanKosong" class="text-xs text-red-600 mt-1 hidden">⚠️ Catatan penolakan wajib
                            diisi!</p>
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end gap-2.5 px-5 pb-5 pt-1">
            <button type="button" onclick="closeRejectLaporanModal()"
                class="px-5 py-2.5 rounded-full bg-gray-50 border border-stone-300 text-zinc-600 font-semibold text-sm hover:bg-gray-100 transition">
                Batal
            </button>
            <button type="button" onclick="submitRejectLaporan()"
                class="flex items-center gap-2 px-5 py-2.5 bg-red-700 rounded-full text-white font-semibold text-sm hover:bg-red-800 transition shadow">
                <svg class="w-4 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tolak Laporan
            </button>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // VARIABEL GLOBAL
    // ============================================
    let rejectLaporanId = null;

    // ============================================
    // FUNGSI BUKA MODAL REJECT LAPORAN
    // ============================================
    window.openRejectLaporanModal = function(laporanId, periode, namaKth) {
        const modal = document.getElementById('modalRejectLaporan');
        const periodeEl = document.getElementById('rejectPeriode');
        const namaEl = document.getElementById('rejectNamaKTH');
        const form = document.getElementById('rejectLaporanForm');
        const input = document.getElementById('catatan_revisi_laporan');
        const errorEl = document.getElementById('errorCatatanKosong');

        if (periodeEl) periodeEl.textContent = periode || '-';
        if (namaEl) namaEl.textContent = namaKth || '-';

        // 🔥 SET FORM ACTION
        if (form) {
            form.action = `/admin/laporan/verifikasi/${laporanId}/reject`;
        }

        // Reset input dan error
        if (input) {
            input.value = '';
            input.classList.remove('border-red-500', 'border-2');
        }
        if (errorEl) {
            errorEl.classList.add('hidden');
        }

        rejectLaporanId = laporanId;

        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');
        }
    };

    // ============================================
    // FUNGSI TUTUP MODAL REJECT LAPORAN
    // ============================================
    function closeRejectLaporanModal() {
        const modal = document.getElementById('modalRejectLaporan');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
        rejectLaporanId = null;
    }

    // ============================================
    // HILANGKAN ERROR SAAT USER MENGETIK
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('catatan_revisi_laporan');
        const errorEl = document.getElementById('errorCatatanKosong');

        if (input && errorEl) {
            input.addEventListener('input', function() {
                if (this.value.trim().length > 0) {
                    errorEl.classList.add('hidden');
                    this.classList.remove('border-red-500', 'border-2');
                }
            });
        }
    });

    // ============================================
    // 🔥 FUNGSI SUBMIT REJECT LAPORAN
    // ============================================
    function submitRejectLaporan() {
        const form = document.getElementById('rejectLaporanForm');
        const input = document.getElementById('catatan_revisi_laporan');
        const errorEl = document.getElementById('errorCatatanKosong');
        const catatan = input ? input.value.trim() : '';

        // 🔥 VALIDASI: CEK APAKAH CATATAN KOSONG
        if (catatan.length === 0) {
            // Tampilkan error di modal
            if (errorEl) {
                errorEl.classList.remove('hidden');
            }
            if (input) {
                input.classList.add('border-red-500', 'border-2');
                input.focus();
            }
            return;
        }

        // Sembunyikan error jika ada
        if (errorEl) {
            errorEl.classList.add('hidden');
        }
        if (input) {
            input.classList.remove('border-red-500', 'border-2');
        }

        // 🔥 VALIDASI MINIMAL 10 KARAKTER
        if (catatan.length < 10) {
            Swal.fire({
                icon: 'warning',
                title: 'Catatan Terlalu Pendek',
                text: 'Catatan penolakan minimal 10 karakter.',
                confirmButtonColor: '#0e4c34',
            });
            input?.focus();
            return;
        }

        // 🔥 LANGSUNG SUBMIT FORM (TANPA KONFIRMASI)
        closeRejectLaporanModal();
        if (form) {
            form.submit();
        }
    }

    // ============================================
    // 🔥 TAMPILKAN NOTIFIKASI DARI SESSION (SUKSES/GAGAL)
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false,
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc2626',
            });
        @endif
    });

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalRejectLaporan');
        if (modal) {
            modal.addEventListener('close', function() {
                document.body.classList.remove('no-scroll');
                rejectLaporanId = null;
            });
            modal.addEventListener('cancel', function() {
                document.body.classList.remove('no-scroll');
                rejectLaporanId = null;
            });
        }
    });
</script>
