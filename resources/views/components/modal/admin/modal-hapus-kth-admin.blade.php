<dialog id="modalHapusKTHAdmin"
    class="w-[380px] mx-auto rounded-2xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-2xl flex flex-col max-h-[85vh] relative">
        {{-- Tombol Close --}}
        <button type="button" onclick="closeHapusAdminModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition z-10">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        {{-- Header dengan Icon --}}
        <div class="flex flex-col items-center pt-6 px-4">
            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mb-3">
                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </div>

            <h3 class="text-lg font-semibold text-zinc-900 text-center font-poppins">
                Konfirmasi Hapus Data KTH
            </h3>
            <p class="text-xs text-neutral-700 text-center mt-2 font-inter leading-relaxed">
                Apakah Anda yakin ingin menghapus data KTH ini?<br />
                Tindakan ini tidak dapat dibatalkan dan semua laporan<br />
                terkait dengan KTH ini juga akan ikut terhapus secara<br />
                permanen.
            </p>
        </div>

        {{-- Target Identitas --}}
        <div class="mx-3.5 mt-3 p-3 bg-zinc-100 rounded-xl border border-stone-300">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-green-200 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-[9px] font-medium text-neutral-500 uppercase tracking-wider">Identitas Target</p>
                    <p class="text-xs font-semibold text-zinc-900" id="targetNamaKTHAdmin">
                        Data KTH
                    </p>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center justify-center gap-2.5 px-4 py-5">
            <button type="button" onclick="closeHapusAdminModal()"
                class="w-28 py-2 rounded-lg border-2 border-neutral-300 text-neutral-700 font-semibold text-xs hover:bg-neutral-50 transition">
                Batal
            </button>
            <form id="formHapusKTHAdmin" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-32 py-2 rounded-lg bg-red-700 text-white font-semibold text-xs hover:bg-red-800 transition flex items-center justify-center gap-1.5 shadow">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // FUNGSI BUKA MODAL HAPUS ADMIN
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        // Definisikan fungsi setelah DOM siap
        window.openHapusKTHAdminModal = function(kthId, namaKth) {
            console.log('🔥 Function called with:', kthId, namaKth);

            // Cari modal dengan cara yang lebih baik
            const modal = document.getElementById('modalHapusKTHAdmin');
            console.log('📦 Modal found:', modal);

            if (!modal) {
                console.error('❌ Modal not found!');
                // Fallback ke confirm
                if (confirm('Apakah Anda yakin ingin menghapus KTH "' + namaKth + '"?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/kth/' + kthId;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
                return;
            }

            const targetElement = document.getElementById('targetNamaKTHAdmin');
            const form = document.getElementById('formHapusKTHAdmin');

            if (targetElement) {
                targetElement.textContent = namaKth || 'Data KTH';
            }

            if (form) {
                form.action = '/admin/kth/' + kthId;
                console.log('📝 Form action set to:', form.action);
            }

            // Gunakan try-catch untuk menangani error
            try {
                modal.showModal();
                document.body.classList.add('no-scroll');
                console.log('✅ Modal opened successfully');
            } catch (error) {
                console.error('❌ Error showing modal:', error);
                // Fallback ke confirm jika modal gagal
                if (confirm('Apakah Anda yakin ingin menghapus KTH "' + namaKth + '"?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/kth/' + kthId;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        };
    });

    // ============================================
    // FUNGSI TUTUP MODAL HAPUS ADMIN
    // ============================================
    window.closeHapusAdminModal = function() {
        const modal = document.getElementById('modalHapusKTHAdmin');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
    };

    // ============================================
    // EVENT LISTENER
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalHapusKTHAdmin');
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
