@props(['user' => null, 'mode' => 'create'])

<dialog id="modalCreateUserAdmin"
    class="w-[500px] max-w-[500px] mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div id="modalCreateUserContainer"
        class="bg-white rounded-3xl flex flex-col max-h-[90vh] transition-all duration-200">
        {{-- Header --}}
        <div
            class="px-5 py-4 bg-white border-b border-stone-300 flex justify-between items-center sticky top-0 z-20 flex-shrink-0">
            <h2 id="modalCreateUserTitle" class="text-emerald-900 text-lg font-bold font-['Poppins'] leading-7">
                {{ $mode == 'edit' ? 'Edit User' : 'Tambah User' }}
            </h2>
            <button type="button" onclick="closeModalCreateUserAdmin()"
                class="text-gray-400 hover:text-gray-600 transition p-1.5 hover:bg-gray-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="overflow-y-auto flex-1 px-5 pt-5 pb-3 max-h-[500px]">
            <form id="formCreateUserAdmin" method="POST" action="{{ route('user.store') }}"
                class="flex flex-col gap-3">
                @csrf
                @if ($mode == 'edit' && $user)
                    @method('PUT')
                @endif

                {{-- Hidden ID untuk edit --}}
                @if ($mode == 'edit' && $user)
                    <input type="hidden" name="id" value="{{ $user->id }}">
                @endif

                {{-- Nama --}}
                <div class="flex flex-col gap-1">
                    <label class="text-neutral-700 text-xs font-semibold font-['Inter'] leading-4 tracking-tight">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ $user->name ?? '' }}"
                        placeholder="Masukkan nama lengkap"
                        class="w-full h-10 px-3 py-2 bg-zinc-100 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-sm font-['Inter'] placeholder:text-gray-500">
                </div>

                {{-- Email --}}
                <div class="flex flex-col gap-1">
                    <label class="text-neutral-700 text-xs font-semibold font-['Inter'] leading-4 tracking-tight">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ $user->email ?? '' }}"
                        placeholder="contoh@kthmadani.com"
                        class="w-full h-10 px-3 py-2 bg-zinc-100 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-sm font-['Inter'] placeholder:text-gray-500">
                </div>

                {{-- Role --}}
                <div class="flex flex-col gap-1">
                    <label class="text-neutral-700 text-xs font-semibold font-['Inter'] leading-4 tracking-tight">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role" id="roleSelect"
                        class="w-full h-10 px-3 py-2 bg-zinc-100 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-sm font-['Inter'] appearance-none cursor-pointer">
                        <option value="admin" {{ isset($user) && $user->role == 'admin' ? 'selected' : '' }}>Admin
                        </option>
                        <option value="penyuluh" {{ isset($user) && $user->role == 'penyuluh' ? 'selected' : '' }}>
                            Penyuluh</option>
                        <option value="pimpinan" {{ isset($user) && $user->role == 'pimpinan' ? 'selected' : '' }}>
                            Pimpinan</option>
                    </select>
                </div>

                {{-- Form Penyuluh (muncul jika role = penyuluh) --}}
                <div id="formPenyuluh" class="flex flex-col gap-3" style="display: none;">

                    <div class="grid grid-cols-2 gap-3">
                        {{-- NIP --}}
                        <div class="flex flex-col gap-1">
                            <label
                                class="text-neutral-700 text-xs font-semibold font-['Inter'] leading-4 tracking-tight">
                                NIP <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nip" value="{{ $user->penyuluh->nip ?? '' }}"
                                placeholder="Masukkan NIP"
                                class="w-full h-10 px-3 py-2 bg-zinc-100 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-sm font-['Inter'] placeholder:text-gray-500">
                        </div>

                        {{-- NIK --}}
                        <div class="flex flex-col gap-1">
                            <label
                                class="text-neutral-700 text-xs font-semibold font-['Inter'] leading-4 tracking-tight">
                                NIK <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nik" value="{{ $user->penyuluh->nik ?? '' }}"
                                placeholder="Masukkan NIK"
                                class="w-full h-10 px-3 py-2 bg-zinc-100 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-sm font-['Inter'] placeholder:text-gray-500">
                        </div>
                    </div>
                </div>

                {{-- Password --}}
                @if ($mode == 'create')
                    <div class="flex flex-col gap-1">
                        <label class="text-neutral-700 text-xs font-semibold font-['Inter'] leading-4 tracking-tight">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" placeholder="••••••••"
                            class="w-full h-10 px-3 py-2 bg-zinc-100 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-sm font-['Inter'] placeholder:text-gray-500">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-neutral-700 text-xs font-semibold font-['Inter'] leading-4 tracking-tight">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" placeholder="••••••••"
                            class="w-full h-10 px-3 py-2 bg-zinc-100 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-sm font-['Inter'] placeholder:text-gray-500">
                    </div>
                @else
                    <div class="flex flex-col gap-1">
                        <label class="text-neutral-700 text-xs font-semibold font-['Inter'] leading-4 tracking-tight">
                            Password (kosongkan jika tidak diubah)
                        </label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                            class="w-full h-10 px-3 py-2 bg-zinc-100 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-sm font-['Inter'] placeholder:text-gray-500">
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru"
                            class="w-full h-10 px-3 py-2 bg-zinc-100 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-sm font-['Inter'] placeholder:text-gray-500">
                    </div>
                @endif
            </form>
        </div>

        {{-- Footer --}}
        <div
            class="px-5 py-3 bg-zinc-100 border-t border-stone-300 flex justify-end items-center gap-3 sticky bottom-0 flex-shrink-0">
            <button type="button" onclick="closeModalCreateUserAdmin()"
                class="h-9 px-5 py-2 bg-white rounded-lg border border-stone-300 text-neutral-700 text-sm font-semibold font-['Inter'] hover:bg-gray-50 transition">
                Batal
            </button>
            <button type="button" onclick="submitFormCreateUserAdmin()"
                class="h-9 px-5 py-2 bg-emerald-900 rounded-lg text-white text-sm font-semibold font-['Inter'] hover:bg-emerald-800 transition shadow-lg flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan
            </button>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // TOGGLE FORM PENYULUH BERDASARKAN ROLE
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        var roleSelect = document.getElementById('roleSelect');
        var formPenyuluh = document.getElementById('formPenyuluh');
        var modal = document.getElementById('modalCreateUserAdmin');

        function toggleFormPenyuluhOnChange() {
            if (roleSelect && formPenyuluh) {
                if (roleSelect.value === 'penyuluh') {
                    formPenyuluh.style.display = 'block';
                    if (modal) {
                        modal.style.width = '550px';
                        modal.style.maxWidth = '550px';
                    }
                } else {
                    formPenyuluh.style.display = 'none';
                    if (modal) {
                        modal.style.width = '450px';
                        modal.style.maxWidth = '450px';
                    }
                }
            }
        }

        if (roleSelect) {
            roleSelect.addEventListener('change', toggleFormPenyuluhOnChange);
            toggleFormPenyuluhOnChange();
        }
    });

    // ============================================
    // FUNGSI BUKA MODAL CREATE/EDIT USER
    // ============================================
    function openModalCreateUserAdmin(mode, userId) {
        var modal = document.getElementById('modalCreateUserAdmin');
        if (!modal) return;

        var form = document.getElementById('formCreateUserAdmin');
        var title = document.getElementById('modalCreateUserTitle');
        var roleSelect = document.getElementById('roleSelect');
        var formPenyuluh = document.getElementById('formPenyuluh');

        form.reset();

        if (mode === 'edit' && userId) {
            // ============================================
            // 🔥 MODE EDIT
            // ============================================
            form.action = '/admin/user/' + userId;

            var methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);

            var url = '/admin/user/' + userId + '/edit';

            fetch(url)
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('HTTP error! status: ' + response.status);
                    }
                    return response.json();
                })
                .then(function(data) {
                    if (data.success) {
                        var user = data.data;
                        var roleLabels = {
                            'admin': 'Admin',
                            'penyuluh': 'Penyuluh',
                            'pimpinan': 'Pimpinan'
                        };

                        // 🔥 Set judul berdasarkan role
                        var roleLabel = roleLabels[user.role] || 'User';
                        title.textContent = 'Edit ' + roleLabel;

                        form.querySelector('input[name="name"]').value = user.name || '';
                        form.querySelector('input[name="email"]').value = user.email || '';
                        roleSelect.value = user.role || 'admin';

                        if (user.penyuluh) {
                            form.querySelector('input[name="nip"]').value = user.penyuluh.nip || '';
                            form.querySelector('input[name="nik"]').value = user.penyuluh.nik || '';
                        }

                        toggleFormPenyuluh();

                        // Atur lebar modal berdasarkan role
                        if (user.role === 'penyuluh') {
                            modal.style.width = '550px';
                            modal.style.maxWidth = '550px';
                        } else {
                            modal.style.width = '450px';
                            modal.style.maxWidth = '450px';
                        }

                        var idInput = form.querySelector('input[name="id"]');
                        if (!idInput) {
                            idInput = document.createElement('input');
                            idInput.type = 'hidden';
                            idInput.name = 'id';
                            form.appendChild(idInput);
                        }
                        idInput.value = user.id;

                        modal.showModal();
                        document.body.classList.add('no-scroll');
                    } else {
                        alert('Gagal mengambil data: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    alert('Gagal mengambil data pengguna. Silakan refresh halaman dan coba lagi.');
                });
        } else {
            // ============================================
            // 🔥 MODE CREATE
            // ============================================
            title.textContent = 'Tambah User';
            form.action = "{{ route('user.store') }}";

            var methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }

            var nipInput = form.querySelector('input[name="nip"]');
            var nikInput = form.querySelector('input[name="nik"]');
            if (nipInput) nipInput.value = '';
            if (nikInput) nikInput.value = '';

            roleSelect.value = 'admin';
            formPenyuluh.style.display = 'none';

            modal.style.width = '450px';
            modal.style.maxWidth = '450px';

            var idInput = form.querySelector('input[name="id"]');
            if (idInput) {
                idInput.remove();
            }

            modal.showModal();
            document.body.classList.add('no-scroll');
        }
    }

    // ============================================
    // FUNGSI TUTUP MODAL CREATE USER
    // ============================================
    function closeModalCreateUserAdmin() {
        var modal = document.getElementById('modalCreateUserAdmin');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
    }

    // ============================================
    // FUNGSI SUBMIT FORM CREATE USER
    // ============================================
    function submitFormCreateUserAdmin() {
        var form = document.getElementById('formCreateUserAdmin');
        if (form) {
            var roleSelect = document.getElementById('roleSelect');
            if (roleSelect.value === 'penyuluh') {
                var nip = form.querySelector('input[name="nip"]').value;
                var nik = form.querySelector('input[name="nik"]').value;
                if (!nip || !nik) {
                    alert('NIP dan NIK wajib diisi untuk role Penyuluh!');
                    return;
                }
            }
            form.submit();
        }
    }

    // ============================================
    // FUNGSI TOGGLE FORM PENYULUH
    // ============================================
    function toggleFormPenyuluh() {
        var roleSelect = document.getElementById('roleSelect');
        var formPenyuluh = document.getElementById('formPenyuluh');

        if (roleSelect && formPenyuluh) {
            if (roleSelect.value === 'penyuluh') {
                formPenyuluh.style.display = 'block';
            } else {
                formPenyuluh.style.display = 'none';
            }
        }
    }

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('modalCreateUserAdmin');
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
