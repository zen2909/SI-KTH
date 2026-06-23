@props(['user' => null])

<dialog id="modalHapusUserAdmin"
    class="w-[384px] max-w-[384px] mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-3xl flex flex-col items-center overflow-hidden">
        {{-- Header --}}
        <div class="w-full px-8 pt-8 pb-4 flex flex-col items-center">
            <div class="w-16 h-20 pb-4 flex flex-col justify-start items-start">
                <div class="w-16 h-16 bg-rose-200 rounded-full flex items-center justify-center">
                    <svg class="w-9 h-9 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
            </div>
            <h3 class="text-zinc-900 text-2xl font-semibold font-['Poppins'] leading-8 text-center">Hapus User</h3>
            <div class="pt-2 px-3.5">
                <p class="text-center text-neutral-700 text-sm font-normal font-['Inter'] leading-5">
                    Apakah Anda yakin ingin menghapus user ini?
                    Tindakan ini tidak dapat dibatalkan dan akan mencabut seluruh hak akses user tersebut dari sistem.
                </p>
            </div>
        </div>

        {{-- User Info --}}
        <div class="w-full px-4 pb-4">
            <div class="w-full p-4 bg-zinc-100 rounded-xl border border-stone-300/30 flex items-center gap-4">
                <div id="hapusUserAvatar"
                    class="w-12 h-12 bg-green-800 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-emerald-200 text-xl font-bold font-['Inter']">??</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p id="hapusUserName" class="text-zinc-900 text-base font-normal font-['Inter'] leading-5 truncate">
                        -</p>
                    <p id="hapusUserEmail"
                        class="text-neutral-700 text-sm font-normal font-['Inter'] leading-5 truncate">-</p>
                </div>
                <div id="hapusUserRoleBadge" class="flex-shrink-0">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">-</span>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="w-full px-8 pb-8 flex flex-col gap-3">
            <form id="formHapusUserAdmin" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full h-12 bg-red-700 rounded-lg text-white text-base font-normal font-['Inter'] hover:bg-red-800 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Ya, Hapus
                </button>
            </form>
            <button type="button" onclick="closeHapusUserAdminModal()"
                class="w-full h-12 rounded-lg border border-neutral-500 text-zinc-600 text-base font-normal font-['Inter'] hover:bg-gray-50 transition">
                Batal
            </button>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // FUNGSI BUKA MODAL HAPUS USER ADMIN
    // ============================================
    function openHapusUserAdminModal(userId, userName, userEmail, userRole, userFoto) {
        var avatar = document.getElementById('hapusUserAvatar');
        var nameEl = document.getElementById('hapusUserName');
        var emailEl = document.getElementById('hapusUserEmail');
        var roleBadge = document.getElementById('hapusUserRoleBadge');
        var form = document.getElementById('formHapusUserAdmin');

        // Update avatar
        if (avatar) {
            if (userFoto) {
                avatar.innerHTML = '<img src="/storage/' + userFoto + '" alt="' + userName +
                    '" class="w-full h-full rounded-full object-cover">';
            } else {
                var initial = userName ? userName.charAt(0).toUpperCase() : '?';
                avatar.innerHTML = '<span class="text-emerald-200 text-xl font-bold font-[\'Inter\']">' + initial +
                    '</span>';
            }
        }

        // Update name
        if (nameEl) nameEl.textContent = userName || '-';

        // Update email
        if (emailEl) emailEl.textContent = userEmail || '-';

        // Update role badge
        if (roleBadge) {
            var badgeHtml = '';
            if (userRole === 'admin') {
                badgeHtml =
                    '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Admin</span>';
            } else if (userRole === 'penyuluh') {
                badgeHtml =
                    '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Penyuluh</span>';
            } else if (userRole === 'pimpinan') {
                badgeHtml =
                    '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">Pimpinan</span>';
            } else {
                badgeHtml =
                    '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">' +
                    (userRole || '-') + '</span>';
            }
            roleBadge.innerHTML = badgeHtml;
        }

        // Update form action
        if (form) {
            var url = '/admin/user/' + userId;
            form.action = url;
        }

        // Tampilkan modal
        var modal = document.getElementById('modalHapusUserAdmin');
        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');
        }
    }

    // ============================================
    // FUNGSI TUTUP MODAL HAPUS USER ADMIN
    // ============================================
    function closeHapusUserAdminModal() {
        var modal = document.getElementById('modalHapusUserAdmin');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
    }

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('modalHapusUserAdmin');
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
