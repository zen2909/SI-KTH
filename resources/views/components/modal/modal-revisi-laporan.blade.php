<dialog id="modalRevisiLaporan"
    class="w-full max-w-3xl mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-3xl flex flex-col max-h-[90vh]">
        {{-- Header --}}
        <div class="flex items-start bg-white py-5 px-6 border-b border-gray-100 sticky top-0 z-20 flex-shrink-0">
            <div class="flex flex-col">
                <div class="bg-red-100 rounded-full px-3 py-1 inline-flex items-center gap-1.5 mb-2">
                    <svg class="w-4 h-4 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <span class="text-red-800 text-sm font-semibold">Laporan Ditolak</span>
                </div>
                <h3 class="text-2xl font-semibold text-zinc-900 font-poppins">Catatan Revisi Laporan</h3>
            </div>
            <button type="button" onclick="closeRevisiLaporanModal()"
                class="ml-auto text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="overflow-y-auto flex-1 px-6 py-4 bg-[#F8F9FA]">
            {{-- Loading state --}}
            <div id="revisiLoading" class="text-center py-8">
                <svg class="w-8 h-8 mx-auto text-emerald-900 animate-spin" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <p class="text-sm text-gray-500 mt-2">Memuat data revisi...</p>
            </div>

            {{-- Content --}}
            <div id="revisiContent" class="hidden">
                {{-- Informasi Laporan --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-50 rounded-xl p-4 border border-stone-300/30">
                        <p class="text-neutral-700 text-xs font-medium">Nama KTH</p>
                        <p class="text-emerald-900 text-base font-semibold" id="revisiNamaKTH">-</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 border border-stone-300/30">
                        <p class="text-neutral-700 text-xs font-medium">Periode Laporan</p>
                        <p class="text-emerald-900 text-base font-semibold" id="revisiPeriode">-</p>
                    </div>
                </div>

                {{-- Catatan Revisi --}}
                <div class="bg-white rounded-3xl border-l-4 border-red-700 p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span class="text-zinc-900 text-xl font-medium font-poppins">Catatan Admin</span>
                    </div>
                    <div class="text-neutral-700 text-base font-normal leading-relaxed" id="revisiCatatan">
                        <p class="text-gray-500 italic">Tidak ada catatan revisi dari Admin.</p>
                    </div>
                </div>

                {{-- Informasi Tambahan --}}
                <div class="mt-4 p-3 bg-gray-50 rounded-xl border border-stone-300/30">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span class="text-gray-600 text-sm font-semibold">Status verifikasi akan diperbarui setelah
                            revisi dikirimkan.</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div
            class="flex justify-end items-center bg-zinc-100 py-4 px-6 border-t border-stone-300/20 sticky bottom-0 flex-shrink-0">
            <button type="button" onclick="closeRevisiLaporanModal()"
                class="w-24 h-12 bg-zinc-200 rounded-full text-neutral-700 font-semibold text-sm hover:bg-zinc-300 transition mr-3">
                Tutup
            </button>
            <a id="revisiEditLink" href="#"
                class="inline-flex items-center justify-center w-56 h-12 bg-emerald-900 rounded-full text-white font-semibold text-sm hover:bg-emerald-800 transition gap-2">
                <svg class="w-5 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Perbaiki Sekarang
            </a>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // FUNGSI BUKA MODAL REVISI LAPORAN
    // ============================================
    window.openRevisiLaporanModal = function(laporanId) {
        const modal = document.getElementById('modalRevisiLaporan');
        const loading = document.getElementById('revisiLoading');
        const content = document.getElementById('revisiContent');

        // Show loading, hide content
        if (loading) loading.classList.remove('hidden');
        if (content) content.classList.add('hidden');

        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');
        }

        // Fetch data
        fetch(`/penyuluh/laporan/${laporanId}/edit-data`)
            .then(response => response.json())
            .then(data => {
                console.log('Data revisi:', data);

                // Update content
                const namaKTH = document.getElementById('revisiNamaKTH');
                const periode = document.getElementById('revisiPeriode');
                const catatan = document.getElementById('revisiCatatan');
                const editLink = document.getElementById('revisiEditLink');

                if (namaKTH) namaKTH.textContent = data.nama_kth || '-';
                if (periode) {
                    periode.textContent = data.periode_laporan ? new Date(data.periode_laporan)
                        .toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        }) : '-';
                }
                if (catatan) {
                    if (data.catatan_revisi) {
                        catatan.innerHTML = data.catatan_revisi.replace(/\n/g, '<br>');
                    } else {
                        catatan.innerHTML =
                            '<p class="text-gray-500 italic">Tidak ada catatan revisi dari Admin.</p>';
                    }
                }
                if (editLink) {
                    editLink.href = `/penyuluh/laporan/${data.id}/edit`;
                }

                // Hide loading, show content
                if (loading) loading.classList.add('hidden');
                if (content) content.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching revisi data:', error);
                if (loading) loading.classList.add('hidden');
                if (content) content.classList.remove('hidden');
                const catatan = document.getElementById('revisiCatatan');
                if (catatan) {
                    catatan.innerHTML =
                        '<p class="text-red-500">Gagal memuat data revisi. Silakan refresh halaman.</p>';
                }
            });
    };

    // ============================================
    // FUNGSI TUTUP MODAL REVISI LAPORAN
    // ============================================
    function closeRevisiLaporanModal() {
        const modal = document.getElementById('modalRevisiLaporan');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
    }

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalRevisiLaporan');
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
