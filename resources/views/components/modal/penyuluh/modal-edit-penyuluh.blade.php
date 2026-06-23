@props(['penyuluh' => null])

@if ($penyuluh)
    <dialog id="modalEditPenyuluh"
        class="w-full max-w-4xl mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

        <div class="bg-white rounded-3xl flex flex-col max-h-[90vh]">
            {{-- Header --}}
            <div
                class="flex items-center bg-white py-6 px-8 border-b border-gray-100 sticky top-0 z-20 flex-shrink-0 relative">
                <div
                    class="w-12 h-12 mr-4 flex items-center justify-center bg-[#0E4C34] rounded-xl text-white flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-[#0E4C34]">Edit Profil Penyuluh</h2>
                    <p class="text-sm text-[#404943]">Perbarui informasi data diri dan wilayah tugas extension officer
                    </p>
                </div>

                {{-- Tombol close --}}
                <button type="button" onclick="document.getElementById('modalEditPenyuluh').close()"
                    class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            {{-- Body form --}}
            <div class="overflow-y-auto flex-1 px-8 py-4">
                <form action="{{ route('penyuluh.profile.update') }}" method="POST" enctype="multipart/form-data"
                    id="editProfilForm">
                    @csrf
                    @method('PUT')

                    <div class="flex gap-8">
                        {{-- KOLOM KIRI: Identitas Dasar --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5 text-[#0E4C34]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-sm font-bold text-[#191C1D]">Identitas Dasar</span>
                            </div>

                            {{-- Nama Lengkap --}}
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-[#404943] mb-1">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $penyuluh->nama_lengkap ?? '') }}"
                                    class="w-full bg-[#F8F9FA] rounded-lg border border-[#C0C9C1] px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2B644A] focus:outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                {{-- NIP --}}
                                <div class="mb-3">
                                    <label class="block text-xs font-medium text-[#404943] mb-1">NIP</label>
                                    <input type="text" name="nip" value="{{ old('nip', $penyuluh->nip ?? '') }}"
                                        class="w-full bg-[#F8F9FA] rounded-lg border border-[#C0C9C1] px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2B644A] focus:outline-none">
                                </div>

                                {{-- NIK --}}
                                <div class="mb-3">
                                    <label class="block text-xs font-medium text-[#404943] mb-1">Golongan /
                                        Pangkat</label>
                                    <input type="text" name="golongan_pangkat"
                                        value="{{ old('nik', $penyuluh->golongan_pangkat ?? '') }}"
                                        class="w-full bg-[#F8F9FA] rounded-lg border border-[#C0C9C1] px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2B644A] focus:outline-none">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="block text-xs font-medium text-[#404943] mb-1">NIK</label>
                                <input type="text" name="nik" value="{{ old('nik', $penyuluh->nik ?? '') }}"
                                    class="w-full bg-[#F8F9FA] rounded-lg border border-[#C0C9C1] px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2B644A] focus:outline-none">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="mb-3">
                                    <label class="block text-xs font-medium text-[#404943] mb-1">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $penyuluh->tempat_lahir ?? '') }}"
                                        class="w-full bg-[#F8F9FA] rounded-lg border border-[#C0C9C1] px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2B644A] focus:outline-none">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-xs font-medium text-[#404943] mb-1">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir"
                                        value="{{ old('tempat_lahir', $penyuluh->tanggal_lahir->format('Y-m-d') ?? '') }}"
                                        class="w-full bg-[#F8F9FA] rounded-lg border border-[#C0C9C1] px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2B644A] focus:outline-none">
                                </div>
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label class="block text-xs font-medium text-[#404943] mb-1">Jenis Kelamin</label>
                                <div class="flex gap-6">
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="radio" name="jenis_kelamin" value="L"
                                            {{ old('jenis_kelamin', $penyuluh->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}
                                            class="w-4 h-4 accent-[#2B644A]"> Laki-laki
                                    </label>
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="radio" name="jenis_kelamin" value="P"
                                            {{ old('jenis_kelamin', $penyuluh->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }}
                                            class="w-4 h-4 accent-[#2B644A]"> Perempuan
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: Data Kontak & Pekerjaan --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5 text-[#0E4C34]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-sm font-bold text-[#191C1D]">Data Kontak & Pekerjaan</span>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-[#404943] mb-1">Alamat Domisili</label>
                                <textarea name="alamat" rows="2"
                                    class="w-full bg-[#F8F9FA] rounded-lg border border-[#C0C9C1] px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2B644A] focus:outline-none resize-none">{{ old('alamat', $penyuluh->alamat ?? '') }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                {{-- Telepon --}}
                                <div class="mb-3">
                                    <label class="block text-xs font-medium text-[#404943] mb-1">Nomor Telepon</label>
                                    <input type="text" name="no_telepon"
                                        value="{{ old('no_telepon', $penyuluh->no_telepon ?? '') }}"
                                        class="w-full bg-[#F8F9FA] rounded-lg border border-[#C0C9C1] px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2B644A] focus:outline-none">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-xs font-medium text-[#404943] mb-1">Email Pribadi</label>
                                    <input type="email" name="email_pribadi"
                                        value="{{ old('no_telepon', $penyuluh->email_pribadi ?? '') }}"
                                        class="w-full bg-[#F8F9FA] rounded-lg border border-[#C0C9C1] px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2B644A] focus:outline-none">
                                </div>
                            </div>

                            {{-- Jabatan --}}
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-[#404943] mb-1">Jabatan</label>
                                <input type="select" name="jabatan"
                                    value="{{ old('jabatan', $penyuluh->jabatan ?? '') }}"
                                    class="w-full bg-[#F8F9FA] rounded-lg border border-[#C0C9C1] px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2B644A] focus:outline-none">
                            </div>

                            {{-- Wilayah Kerja --}}
                            <div>
                                <label class="block text-xs font-medium text-[#404943] mb-1">Wilayah Kerja
                                    (WKPP)</label>
                                <input type="text" name="wilayah_kerja"
                                    value="{{ old('wilayah_kerja', $penyuluh->wilayah_kerja ?? '') }}"
                                    class="w-full bg-[#F8F9FA] rounded-lg border border-[#C0C9C1] px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2B644A] focus:outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- Info box --}}
                    <div class="flex items-start bg-[#F3F4F5] py-3 px-4 mt-4 rounded-xl border border-[#E1E3E4]">
                        <svg class="w-5 h-5 mr-3 text-[#404943] flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-[#404943]">
                            Pastikan NIP dan Email sudah benar. Data ini digunakan untuk verifikasi login ke portal
                            utama Forestry Connect.
                        </span>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div
                class="flex justify-end items-center border-t border-gray-100 px-8 py-4 bg-white sticky bottom-0 flex-shrink-0">
                <button type="button" onclick="document.getElementById('modalEditPenyuluh').close()"
                    class="bg-[#D2E8DC] px-6 py-2.5 mr-3 rounded-lg hover:bg-[#b5d9c8] transition font-bold text-[#0E4C34] text-sm">
                    Batal
                </button>
                <button type="submit" form="editProfilForm"
                    class="flex items-center bg-[#2B644A] px-6 py-2.5 gap-2 rounded-lg shadow hover:bg-[#1f4d36] transition">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                    <span class="text-white text-sm font-bold">Simpan Perubahan</span>
                </button>
            </div>
        </div>
    </dialog>

    <script>
        window.openEditProfilModal = function() {
            const modal = document.getElementById('modalEditPenyuluh');
            if (modal) {
                modal.showModal();
            }
        };
    </script>
@else
    <dialog id="modalEditPenyuluh" class="w-full max-w-md mx-auto rounded-lg shadow-lg p-6 backdrop:bg-black/50">
        <p class="text-red-500 font-semibold">Data penyuluh tidak ditemukan. Hubungi admin.</p>
        <button onclick="document.getElementById('modalEditPenyuluh').close()"
            class="mt-4 bg-gray-200 px-4 py-2 rounded">Tutup</button>
    </dialog>
    <script>
        window.openEditProfilModal = function() {
            const modal = document.getElementById('modalEditPenyuluh');
            if (modal) modal.showModal();
        };
    </script>

    <script>
        window.openEditProfilModal = function() {
            const modal = document.getElementById('modalEditPenyuluh');
            if (modal) {
                modal.showModal();
                document.body.classList.add('no-scroll');
            }
        };

        // Listener untuk ketika modal ditutup
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalEditPenyuluh');
            if (modal) {
                modal.addEventListener('close', function() {
                    document.body.classList.remove('no-scroll');
                });
                // Juga jika user klik outside dialog, tetap remove class
                modal.addEventListener('cancel', function() {
                    document.body.classList.remove('no-scroll');
                });
            }
        });
    </script>
@endif
