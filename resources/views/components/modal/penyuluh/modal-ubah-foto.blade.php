@props(['user' => null])

<dialog id="modalUbahFoto"
    class="w-full max-w-2xl mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-3xl flex flex-col">
        {{-- Header --}}
        <div class="flex items-center justify-between bg-white py-6 px-8 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-primary">Ubah Foto Profil</h2>
            <button type="button" onclick="document.getElementById('modalUbahFoto').close()"
                class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="flex flex-col items-center px-8 py-6">
            {{-- Preview Foto --}}
            <div class="relative mb-6">
                <div
                    class="w-40 h-40 rounded-full overflow-hidden border-4 border-[#E1E3E4] bg-[#F8F9FA] flex items-center justify-center">
                    @if ($user && $user->foto_profil)
                        <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" id="previewFoto"
                            class="w-full h-full object-cover">
                    @else
                        <span class="text-6xl text-gray-400 font-bold" id="previewPlaceholder">
                            {{ strtoupper(substr($user->nama_lengkap ?? 'U', 0, 2)) }}
                        </span>
                        <img src="" alt="Preview" id="previewFoto" class="w-full h-full object-cover hidden">
                    @endif
                </div>
                {{-- Tombol edit foto (di atas foto) --}}
                <button type="button" onclick="document.getElementById('fileInput').click()"
                    class="absolute bottom-0 right-0 bg-primary text-white p-2 rounded-full shadow-lg hover:bg-[#1f4d36] transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </button>
            </div>

            {{-- Tombol Pilih File --}}
            <form action="{{ route('penyuluh.profile.update-foto') }}" method="POST" enctype="multipart/form-data"
                id="formUbahFoto">
                @csrf
                @method('PUT')

                <input type="file" name="foto_profil" id="fileInput" accept="image/*" class="hidden"
                    onchange="previewFoto(this)">

                <button type="button" onclick="document.getElementById('fileInput').click()"
                    class="flex items-center bg-primary text-white py-2.5 px-8 gap-2 rounded-xl hover:bg-white hover:outline-2 hover:outline-primary hover:text-primary transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                        </path>
                    </svg>
                    <span class="text-sm font-bold">Pilih File</span>
                </button>
            </form>

            {{-- Tombol Hapus Foto --}}
            @if ($user && $user->foto_profil)
                <button type="button" onclick="hapusFoto()"
                    class="flex items-center gap-2 mt-3 py-2.5 px-5 text-[#BA1A1A] bg-gray-200 hover:text-white hover:bg-red-500 rounded-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    <span class="text-sm font-bold">Hapus Foto</span>
                </button>
            @endif

            {{-- Informasi File --}}
            <div class="flex items-start bg-[#EDEEEF] py-4 px-4 mt-4 rounded-xl border border-[#C0C9C14D] w-full">
                <svg class="w-5 h-6 mr-3 text-[#404943] flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="space-y-1">
                    <p class="text-xs text-[#404943] font-medium">Informasi File</p>
                    <ul class="text-sm text-[#404943] space-y-0.5 ml-4 list-disc">
                        <li>Format file yang didukung: JPG, PNG</li>
                        <li>Ukuran maksimum file: 2MB</li>
                        <li>Rasio ideal: 1:1 (Persegi)</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex justify-end items-center bg-[#F3F4F5] py-4 px-8 rounded-b-3xl gap-3">
            <button type="button" onclick="document.getElementById('modalUbahFoto').close()"
                class="text-[#404943] font-bold text-sm py-2.5 px-6 rounded-xl hover:bg-red-500 hover:text-white transition-all duration-200">
                Batal
            </button>
            <button type="submit" form="formUbahFoto"
                class="bg-primary text-white text-sm font-bold py-2.5 px-6 rounded-xl hover:bg-[#1f4d36] transition shadow">
                Simpan
            </button>
        </div>
    </div>
</dialog>

<script>
    // Preview foto sebelum upload
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('previewFoto');
                const placeholder = document.getElementById('previewPlaceholder');
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Hapus foto dengan konfirmasi
    function hapusFoto() {
        if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
            fetch('{{ route('penyuluh.profile.delete-foto') }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            }).catch(error => {
                alert('Terjadi kesalahan saat menghapus foto.');
            });
        }
    }

    // Fungsi untuk membuka modal
    window.openUbahFotoModal = function() {
        const modal = document.getElementById('modalUbahFoto');
        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');
        }
    };

    // Tutup modal saat klik di luar
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalUbahFoto');
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
