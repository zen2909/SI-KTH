@props(['kth' => null, 'rejectUrl' => ''])

<dialog id="modalRejectKTH"
    class="w-[420px] mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-3xl flex flex-col relative">
        {{-- Tombol Close --}}
        <button type="button" onclick="closeRejectModal()"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition z-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        {{-- Body --}}
        <div class="px-5 pt-5 pb-4">
            {{-- Icon --}}
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-zinc-900 font-poppins">Tolak Data KTH</h3>
            </div>

            {{-- Nama KTH --}}
            <div class="mb-3.5">
                <p class="text-[10px] font-medium text-neutral-500 uppercase tracking-wide">Nama Kelompok Tani Hutan</p>
                <p class="text-sm font-medium text-emerald-900 font-poppins truncate" id="rejectNamaKTH">
                    {{ $kth->nama_kth ?? 'Data KTH' }}
                </p>
            </div>

            {{-- FORM --}}
            <form id="rejectForm" method="POST" action="{{ $rejectUrl }}">
                @csrf
                <input type="hidden" name="kth_id" id="rejectKTHId" value="{{ $kth->id ?? '' }}">

                <div class="mb-1">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-zinc-900">Catatan Penolakan</span>
                        <span class="text-[10px] text-red-600 font-medium">*Wajib diisi</span>
                    </div>
                    <div>
                        <input type="text" name="catatan_revisi" id="catatan_revisi" required
                            class="w-full mt-1.5 px-3.5 py-2.5 bg-zinc-100 rounded-xl border border-stone-300 focus:ring-2 focus:ring-emerald-900 focus:outline-none text-sm placeholder:text-neutral-400"
                            placeholder="Berikan alasan spesifik mengapa data ini ditolak...">
                        {{-- 🔥 PESAN ERROR DI BAWAH INPUT --}}
                        <p id="errorCatatanKosong" class="text-xs text-red-600 mt-1 hidden">
                            ⚠️ Catatan revisi wajib diisi!
                        </p>
                    </div>
                </div>

                {{-- Info --}}
                <div class="flex items-start gap-2.5 mt-3 p-2.5 bg-zinc-100 rounded-xl">
                    <svg class="w-4 h-5 text-gray-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <span class="text-xs text-gray-600 font-inter leading-relaxed">
                        Catatan ini akan dikirimkan kepada pengurus KTH melalui email dan dashboard mereka untuk proses
                        perbaikan data.
                    </span>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-2.5 mt-4">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-5 py-2 rounded-full border border-neutral-400 text-zinc-600 font-semibold text-sm hover:bg-neutral-50 transition">
                        Batal
                    </button>
                    <button type="submit" id="submitRejectBtn"
                        class="flex items-center gap-2 px-5 py-2 bg-red-700 rounded-full text-white font-semibold text-sm hover:bg-red-800 transition shadow">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // FUNGSI BUKA MODAL REJECT
    // ============================================
    window.openRejectKTHModal = function(kthId, namaKth) {
        console.log('KTH ID diterima:', kthId);

        const modal = document.getElementById('modalRejectKTH');
        const namaElement = document.getElementById('rejectNamaKTH');
        const form = document.getElementById('rejectForm');
        const hiddenInput = document.getElementById('rejectKTHId');
        const inputCatatan = document.getElementById('catatan_revisi');
        const errorEl = document.getElementById('errorCatatanKosong');

        if (namaElement) {
            namaElement.textContent = namaKth || 'Data KTH';
        }

        // UPDATE FORM ACTION
        if (form && hiddenInput) {
            const id = parseInt(kthId);
            hiddenInput.value = id;
            form.action = '/admin/kth/verifikasi/' + id + '/reject';
            console.log('Form action set to:', form.action);
        }

        if (inputCatatan) {
            inputCatatan.value = '';
            inputCatatan.classList.remove('border-red-500', 'border-2');
        }
        if (errorEl) {
            errorEl.classList.add('hidden');
        }

        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');
        }
    };

    // ============================================
    // FUNGSI TUTUP MODAL REJECT
    // ============================================
    function closeRejectModal() {
        const modal = document.getElementById('modalRejectKTH');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
    }

    // ============================================
    // HILANGKAN ERROR SAAT USER MENGETIK
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('catatan_revisi');
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
    // 🔥 VALIDASI SEBELUM SUBMIT
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('rejectForm');
        const inputCatatan = document.getElementById('catatan_revisi');
        const errorEl = document.getElementById('errorCatatanKosong');

        if (form) {
            form.addEventListener('submit', function(e) {
                const catatan = inputCatatan ? inputCatatan.value.trim() : '';

                if (catatan.length === 0) {
                    e.preventDefault();
                    if (errorEl) {
                        errorEl.classList.remove('hidden');
                    }
                    if (inputCatatan) {
                        inputCatatan.classList.add('border-red-500', 'border-2');
                        inputCatatan.focus();
                    }
                    return;
                }

                // Validasi minimal 10 karakter
                if (catatan.length < 10) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Catatan Terlalu Pendek',
                        text: 'Catatan penolakan minimal 10 karakter.',
                        confirmButtonColor: '#0e4c34',
                    });
                    inputCatatan?.focus();
                    return;
                }

                // Konfirmasi sebelum submit
                e.preventDefault();
                Swal.fire({
                    icon: 'question',
                    title: 'Konfirmasi Penolakan',
                    text: 'Apakah Anda yakin ingin menolak data KTH ini?',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Tolak',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // 🔥 TUTUP MODAL TERLEBIH DAHULU
                        closeRejectModal();
                        // Submit form
                        form.submit();
                    }
                });
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('catatan_revisi');
        const errorEl = document.getElementById('errorCatatanKosong');

        if (input && errorEl) {
            input.addEventListener('input', function() {
                if (this.value.trim().length > 0) {
                    errorEl.classList.add('hidden'); // 🔥 PASTIKAN INI ADA
                    this.classList.remove('border-red-500', 'border-2');
                }
            });
        }
    });

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
        const modal = document.getElementById('modalRejectKTH');
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
