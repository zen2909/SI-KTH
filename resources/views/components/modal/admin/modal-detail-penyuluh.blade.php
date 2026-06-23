<dialog id="modalDetailPenyuluhAdmin"
    class="w-[672px] max-w-[672px] mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">


    <div class="bg-white rounded-3xl flex flex-col max-h-[90vh]">

        {{-- Header --}}
        <div
            class="px-6 py-4 bg-white border-b border-stone-300 flex justify-between items-center sticky top-0 z-20 flex-shrink-0">
            <h2 class="text-emerald-900 text-xl font-bold font-poppins leading-7">Detail Data Penyuluh</h2>
            <button type="button" onclick="closeModalDetailPenyuluhAdmin()"
                class="text-gray-400 hover:text-gray-600 transition p-1.5 hover:bg-gray-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="overflow-y-auto flex-1 px-6 md:px-10 pt-6 pb-6 max-h-[700px]">
            <div id="detailPenyuluhContent">
                {{-- Akan diisi oleh JavaScript --}}
            </div>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // STATE PASSWORD VISIBILITY
    // ============================================
    let isPasswordVisiblePenyuluh = false;
    const passwordDummyPenyuluh = '••••••••••••';

    // ============================================
    // FUNGSI TOGGLE PASSWORD
    // ============================================
    function togglePasswordPenyuluh() {
        const passwordDisplay = document.getElementById('passwordDisplayPenyuluh');
        const eyeIcon = document.getElementById('eyeIconPenyuluh');

        if (!passwordDisplay || !eyeIcon) return;

        isPasswordVisiblePenyuluh = !isPasswordVisiblePenyuluh;

        if (isPasswordVisiblePenyuluh) {
            passwordDisplay.textContent = passwordDisplay.dataset.realPassword || 'password123';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        } else {
            passwordDisplay.textContent = passwordDummyPenyuluh;
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }

    // ============================================
    // FUNGSI BUKA MODAL DETAIL PENYULUH
    // ============================================
    window.openDetailPenyuluhAdminModal = function(
        name,
        email,
        foto,
        nip,
        nik,
        tempatLahir,
        tanggalLahir,
        jenisKelamin,
        alamat,
        noTelepon,
        emailPribadi,
        jabatan,
        golonganPangkat,
        wilayahKerja,
        plainPassword
    ) {
        const modal = document.getElementById('modalDetailPenyuluhAdmin');
        if (!modal) return;

        const content = document.getElementById('detailPenyuluhContent');
        const initial = name ? name.charAt(0).toUpperCase() : 'U';

        // Reset password state
        isPasswordVisiblePenyuluh = false;

        // Format tanggal lahir
        let formattedTanggalLahir = tanggalLahir || '-';
        if (tanggalLahir) {
            try {
                const date = new Date(tanggalLahir);
                if (!isNaN(date.getTime())) {
                    formattedTanggalLahir = date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                }
            } catch (e) {}
        }

        // Format jenis kelamin
        let genderLabel = '-';
        if (jenisKelamin === 'L') genderLabel = 'Laki-laki';
        else if (jenisKelamin === 'P') genderLabel = 'Perempuan';

        // Password default
        const realPassword = plainPassword || 'password123';

        content.innerHTML = `
            <div class="flex flex-col gap-6">
                {{-- Profile Header --}}
                <div class="flex flex-col md:flex-row items-start gap-6">
                    {{-- Avatar --}}
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 rounded-full border-4 border-gray-200 flex items-center justify-center bg-gray-100 overflow-hidden">
                            ${foto ? 
                                `<img src="/storage/${foto}" alt="${name}" class="w-full h-full object-cover rounded-full">` :
                                `<span class="text-3xl font-bold text-emerald-900">${initial}</span>`
                            }
                        </div>
                    </div>

                    {{-- Info Utama --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-3 mb-1">
                            <h3 class="text-zinc-900 text-xl font-medium font-poppins leading-7">${name || '-'}</h3>
                        </div>
                        <p class="text-neutral-700 text-base font-normal font-['Inter'] leading-6">${jabatan || '-'} - ${golonganPangkat || '-'}</p>
                        
                        {{-- Password dengan Toggle --}}
                        <div class="mt-3">
                            <p class="text-zinc-500 text-[10px] font-semibold font-['Inter'] uppercase tracking-wider">Password</p>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span id="passwordDisplayPenyuluh" data-real-password="${realPassword}" 
                                    class="text-zinc-900 text-sm font-normal font-['Inter']">${passwordDummyPenyuluh}</span>
                                <button type="button" onclick="togglePasswordPenyuluh()"
                                    class="text-gray-400 hover:text-gray-600 transition p-1 rounded hover:bg-gray-100" title="Lihat Password">
                                    <svg id="eyeIconPenyuluh" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Grid 2 Kolom --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Identitas Dasar --}}
                    <div class="bg-gray-50 rounded-3xl p-6 border border-stone-300">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-1.5 h-5 bg-emerald-900 rounded-full"></div>
                            <p class="text-emerald-900 text-sm font-semibold font-['Inter'] uppercase tracking-wider">Identitas Dasar</p>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-neutral-700 text-xs font-medium font-['Inter'] leading-4">NIP</p>
                                <p class="text-zinc-900 text-sm font-semibold font-['Inter'] leading-6">${nip || '-'}</p>
                            </div>
                            <div>
                                <p class="text-neutral-700 text-xs font-medium font-['Inter'] leading-4">NIK</p>
                                <p class="text-zinc-900 text-sm font-semibold font-['Inter'] leading-6">${nik || '-'}</p>
                            </div>
                            <div>
                                <p class="text-neutral-700 text-xs font-medium font-['Inter'] leading-4">Tempat, Tanggal Lahir</p>
                                <p class="text-zinc-900 text-sm font-semibold font-['Inter'] leading-6">${tempatLahir || '-'}, ${formattedTanggalLahir}</p>
                            </div>
                            <div>
                                <p class="text-neutral-700 text-xs font-medium font-['Inter'] leading-4">Jenis Kelamin</p>
                                <p class="text-zinc-900 text-sm font-semibold font-['Inter'] leading-6">${genderLabel}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Kontak & Kepegawaian --}}
                    <div class="bg-gray-50 rounded-3xl p-6 border border-stone-300">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-1.5 h-5 bg-emerald-900 rounded-full"></div>
                            <p class="text-emerald-900 text-sm font-semibold font-['Inter'] uppercase tracking-wider">Kontak & Kepegawaian</p>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-neutral-700 text-xs font-medium font-['Inter'] leading-4">Alamat</p>
                                <p class="text-zinc-900 text-sm font-semibold font-['Inter'] leading-6">${alamat || '-'}</p>
                            </div>
                            <div>
                                <p class="text-neutral-700 text-xs font-medium font-['Inter'] leading-4">Nomor Telepon</p>
                                <p class="text-zinc-900 text-sm font-semibold font-['Inter'] leading-6">${noTelepon || '-'}</p>
                            </div>
                            <div>
                                <p class="text-neutral-700 text-xs font-medium font-['Inter'] leading-4">Email Pribadi</p>
                                <p class="text-zinc-900 text-sm font-semibold font-['Inter'] leading-6">${emailPribadi || email || '-'}</p>
                            </div>
                            <div>
                                <p class="text-neutral-700 text-xs font-medium font-['Inter'] leading-4">Jabatan</p>
                                <p class="text-zinc-900 text-sm font-semibold font-['Inter'] leading-6">${jabatan || '-'}</p>
                            </div>
                            <div>
                                <p class="text-neutral-700 text-xs font-medium font-['Inter'] leading-4">Golongan / Pangkat</p>
                                <p class="text-zinc-900 text-sm font-semibold font-['Inter'] leading-6">${golonganPangkat || '-'}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Wilayah Kerja --}}
                <div class="bg-gray-50 rounded-3xl p-6 border border-stone-300">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-5 bg-emerald-900 rounded-full"></div>
                        <p class="text-emerald-900 text-sm font-semibold font-['Inter'] uppercase tracking-wider">Wilayah Kerja</p>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-green-800/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-zinc-900 text-base font-semibold font-['Inter'] leading-6">Wilayah Kerja</p>
                            <p class="text-neutral-700 text-sm font-normal font-['Inter'] leading-5">${wilayahKerja || '-'}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        modal.showModal();
        document.body.classList.add('no-scroll');
    };

    // ============================================
    // FUNGSI TUTUP MODAL DETAIL PENYULUH
    // ============================================
    function closeModalDetailPenyuluhAdmin() {
        const modal = document.getElementById('modalDetailPenyuluhAdmin');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
    }

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalDetailPenyuluhAdmin');
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
