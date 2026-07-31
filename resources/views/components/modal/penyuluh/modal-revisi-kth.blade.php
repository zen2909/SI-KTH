@props(['kth' => null])

<dialog id="modalCatatanRevisi"
    class="w-full max-w-lg mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-3xl flex flex-col max-h-[90vh]">
        {{-- Header --}}
        <div class="flex items-start bg-white py-5 px-6 border-b border-gray-100 sticky top-0 z-20 flex-shrink-0">
            <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-8 h-8 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-xl font-medium text-zinc-900 font-poppins">Catatan Revisi KTH</h3>
                <p class="text-sm text-neutral-700 font-semibold">
                    Status Verifikasi: <span class="text-red-700 font-bold">Ditolak</span>
                </p>
            </div>
            <button type="button" onclick="closeCatatanRevisiModal()"
                class="ml-auto text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        {{-- Identitas KTH --}}
        <div class="mx-5 mt-4 p-3 bg-zinc-100 rounded-lg border border-stone-300">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-5 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <span class="text-neutral-700 text-sm font-normal">Identitas KTH:</span>
                <span class="text-emerald-900 text-sm font-bold"
                    id="catatanRevisiNamaKTH">{{ $kth->nama_kth ?? 'Data KTH' }}</span>
            </div>
        </div>

        {{-- Body Catatan Revisi --}}
        <div class="flex-1 overflow-y-auto px-5 py-4">
            <div class="bg-red-50 rounded-xl shadow border-l-4 border-red-700 p-4">
                {{-- Judul Pesan --}}
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <span class="text-neutral-700 text-sm font-medium uppercase tracking-wide">Pesan
                        Administrator</span>
                </div>

                {{-- Isi Catatan Revisi --}}
                <div class="text-neutral-700 text-sm font-normal leading-relaxed space-y-3" id="catatanRevisiIsi">
                    @if ($kth && $kth->catatan_revisi)
                        {!! nl2br(e($kth->catatan_revisi)) !!}
                    @else
                        <p class="text-gray-500 italic">Tidak ada catatan revisi dari Admin.</p>
                    @endif
                </div>

                {{-- Footer Info --}}
                <div class="mt-4 pt-3 border-t border-red-200">
                    <p class="text-neutral-500 text-xs font-normal">
                        Diajukan kembali setelah revisi dilakukan melalui dashboard Verifikasi.
                    </p>
                </div>
            </div>

            {{-- Informasi Update --}}
            <div class="mt-3 p-3 bg-zinc-200/30 rounded-lg">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-neutral-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>

                    {{-- Updated At --}}
                    <span class="text-neutral-700 text-sm font-normal" id="catatanRevisiUpdatedAt">
                        @if ($kth && $kth->updated_at)
                            pada {{ \Carbon\Carbon::parse($kth->updated_at)->format('d M Y, H:i') }} WIB
                        @else
                            -
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div
            class="flex justify-center items-center bg-zinc-100 py-4 px-6 border-t border-gray-100 sticky bottom-0 flex-shrink-0">
            <button type="button" onclick="closeCatatanRevisiModal()"
                class="w-52 py-3 rounded-full bg-emerald-900 text-white font-semibold text-sm hover:bg-emerald-800 transition shadow-lg flex items-center justify-center gap-2">
                <svg class="w-4 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Mengerti & Tutup
            </button>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // FUNGSI BUKA MODAL CATATAN REVISI DENGAN FETCH
    // ============================================
    window.openCatatanRevisiModal = function(kthId) {
        const modal = document.getElementById('modalCatatanRevisi');
        if (!modal) {
            console.error('Modal not found');
            return;
        }

        // Tampilkan loading
        modal.showModal();
        document.body.classList.add('no-scroll');

        // Ambil data KTH via fetch
        fetch('/penyuluh/kth/' + kthId)
            .then(response => response.json())
            .then(data => {
                // Update nama KTH
                const namaKth = document.getElementById('catatanRevisiNamaKTH');
                if (namaKth) {
                    namaKth.textContent = data.nama_kth || 'Data KTH';
                }

                // Update catatan revisi
                const catatan = document.getElementById('catatanRevisiIsi');
                if (catatan) {
                    if (data.catatan_revisi) {
                        catatan.innerHTML = data.catatan_revisi.replace(/\n/g, '<br>');
                    } else {
                        catatan.innerHTML =
                            '<p class="text-gray-500 italic">Tidak ada catatan revisi dari Admin.</p>';
                    }
                }

                // Update tanggal update
                const updatedAt = document.getElementById('catatanRevisiUpdatedAt');
                if (updatedAt && data.updated_at) {
                    const date = new Date(data.updated_at);
                    updatedAt.textContent = date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    }) + ' WIB';
                }
            })
            .catch(error => {
                console.error('Error fetching KTH data:', error);
                // Fallback: tetap tampilkan modal dengan data yang ada (dari props)
                const namaKth = document.getElementById('catatanRevisiNamaKTH');
                if (namaKth) {
                    namaKth.textContent = 'Data KTH';
                }
            });
    };

    // ============================================
    // FUNGSI TUTUP MODAL CATATAN REVISI
    // ============================================
    function closeCatatanRevisiModal() {
        const modal = document.getElementById('modalCatatanRevisi');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
    }

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalCatatanRevisi');
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
