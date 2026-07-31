<dialog id="modalDetailUserAdmin"
    class="w-[672px] max-w-[672px] mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-3xl flex flex-col max-h-[90vh]">
        {{-- Header --}}
        <div
            class="px-6 py-4 bg-white border-b border-stone-300 flex justify-between items-center sticky top-0 z-20 flex-shrink-0">
            <h2 id="modalDetailUserTitle" class="text-emerald-900 text-xl font-bold font-poppins leading-7">Detail
                Pengguna</h2>
            <button type="button" onclick="closeModalDetailUserAdmin()"
                class="text-gray-400 hover:text-gray-600 transition p-1.5 hover:bg-gray-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="overflow-y-auto flex-1 px-6 pt-6 pb-6 max-h-[500px]">
            <div id="detailUserContent">
                <div class="flex flex-col md:flex-row gap-8">
                    {{-- Kolom Kiri: Avatar --}}
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div id="detailUserAvatar"
                            class="w-24 h-24 rounded-full border-4 border-gray-200 flex items-center justify-center bg-gray-100 overflow-hidden flex-shrink-0">
                            <span class="text-3xl font-bold text-emerald-900">U</span>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Informasi --}}
                    <div class="flex-1 min-w-0">
                        <div class="grid grid-cols-2 gap-5">
                            <div class="space-y-4">
                                {{-- Nama --}}
                                <div>
                                    <p
                                        class="text-zinc-500 text-[10px] font-semibold font-['Inter'] uppercase tracking-wider">
                                        Nama Lengkap</p>
                                    <p id="detailUserName" class="text-zinc-900 text-sm font-semibold font-['Inter']">-
                                    </p>
                                </div>

                                {{-- Password dengan Toggle --}}
                                <div>
                                    <p
                                        class="text-zinc-500 text-[10px] font-semibold font-['Inter'] uppercase tracking-wider">
                                        Password</p>
                                    <div class="flex items-center gap-2">
                                        <span id="passwordDisplay"
                                            class="text-zinc-900 text-sm font-normal font-['Inter']">••••••••••••</span>
                                        <button type="button" onclick="togglePasswordVisibility()"
                                            class="text-gray-400 hover:text-gray-600 transition p-1 rounded hover:bg-gray-100"
                                            title="Lihat Password">
                                            <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                {{-- Email --}}
                                <div>
                                    <p
                                        class="text-zinc-500 text-[10px] font-semibold font-['Inter'] uppercase tracking-wider">
                                        Email</p>
                                    <p id="detailUserEmail"
                                        class="text-zinc-900 text-sm font-normal font-['Inter'] break-all">-</p>
                                </div>

                                {{-- Role --}}
                                <div>
                                    <p
                                        class="text-zinc-500 text-[10px] font-semibold font-['Inter'] uppercase tracking-wider">
                                        Peran (Role)</p>
                                    <div id="detailUserRole" class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-gray-600 text-sm font-bold font-['Inter']">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div
            class="px-6 py-4 bg-white border-t border-stone-300 flex justify-end items-center sticky bottom-0 flex-shrink-0">
            <button type="button" onclick="closeModalDetailUserAdmin()"
                class="px-8 py-2.5 rounded-xl border-2 border-emerald-900 text-emerald-900 text-sm font-semibold font-['Inter'] hover:bg-emerald-900 hover:text-white transition">
                Tutup
            </button>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // STATE PASSWORD VISIBILITY
    // ============================================
    let isPasswordVisible = false;
    const passwordDummy = '••••••••••••';

    // ============================================
    // FUNGSI TOGGLE PASSWORD
    // ============================================
    function togglePasswordVisibility() {
        const passwordDisplay = document.getElementById('passwordDisplay');
        const eyeIcon = document.getElementById('eyeIcon');

        if (!passwordDisplay || !eyeIcon) return;

        isPasswordVisible = !isPasswordVisible;

        if (isPasswordVisible) {
            passwordDisplay.textContent = 'password123';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        } else {
            passwordDisplay.textContent = passwordDummy;
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }

    // ============================================
    // FUNGSI BUKA MODAL DETAIL USER (Admin/Pimpinan)
    // ============================================
    window.openDetailUserAdminModal = function(name, email, foto, role) {
        const modal = document.getElementById('modalDetailUserAdmin');
        if (!modal) return;

        // 🔥 Set Title berdasarkan role
        const title = document.getElementById('modalDetailUserTitle');
        if (role === 'admin') {
            title.textContent = 'Detail Admin';
        } else if (role === 'pimpinan') {
            title.textContent = 'Detail Pimpinan';
        } else {
            title.textContent = 'Detail Pengguna';
        }

        // Set data
        document.getElementById('detailUserName').textContent = name || '-';
        document.getElementById('detailUserEmail').textContent = email || '-';

        // Set Avatar
        const avatarContainer = document.getElementById('detailUserAvatar');
        if (foto) {
            avatarContainer.innerHTML =
                `<img src="/storage/${foto}" alt="${name}" class="w-full h-full object-cover rounded-full">`;
        } else {
            const initial = name ? name.charAt(0).toUpperCase() : 'U';
            avatarContainer.innerHTML = `<span class="text-3xl font-bold text-emerald-900">${initial}</span>`;
        }

        // Set Role dengan warna
        const roleColors = {
            'admin': 'text-blue-600',
            'penyuluh': 'text-red-600',
            'pimpinan': 'text-purple-600'
        };
        const roleLabels = {
            'admin': 'Admin',
            'penyuluh': 'Penyuluh',
            'pimpinan': 'Pimpinan'
        };
        const roleContainer = document.getElementById('detailUserRole');
        roleContainer.innerHTML = `
            <svg class="w-4 h-4 ${roleColors[role] || 'text-gray-600'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="${roleColors[role] || 'text-gray-600'} text-sm font-bold font-['Inter']">${roleLabels[role] || role || '-'}</span>
        `;

        // Reset password
        isPasswordVisible = false;
        const passwordDisplay = document.getElementById('passwordDisplay');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordDisplay) passwordDisplay.textContent = passwordDummy;
        if (eyeIcon) {
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }

        modal.showModal();
        document.body.classList.add('no-scroll');
    };

    // ============================================
    // FUNGSI TUTUP MODAL DETAIL USER
    // ============================================
    function closeModalDetailUserAdmin() {
        const modal = document.getElementById('modalDetailUserAdmin');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
    }

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalDetailUserAdmin');
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
