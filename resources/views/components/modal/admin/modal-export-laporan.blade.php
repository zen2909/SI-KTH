@props(['totalData' => 0, 'tahunList' => []])

<dialog id="modalExportLaporan"
    class="w-full max-w-[700px] mx-auto rounded-3xl shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm overflow-hidden">

    <div class="bg-white rounded-3xl flex flex-col max-h-[90vh]">
        {{-- Header --}}
        <div
            class="px-6 py-4 bg-white border-b border-stone-300 flex justify-between items-center sticky top-0 z-20 flex-shrink-0">
            <div>
                <h2 class="text-emerald-900 text-xl font-semibold font-['Poppins'] leading-7">Ekspor Laporan Kelompok
                    Tani Hutan</h2>
                <p class="text-neutral-700 text-sm font-normal font-['Inter'] leading-5 mt-0.5">
                    Silakan atur filter di bawah ini untuk mengunduh data laporan.
                </p>
            </div>
            <button type="button" onclick="closeModalExportLaporan()"
                class="text-gray-400 hover:text-gray-600 transition-all duration-200 p-1.5 hover:bg-gray-100 rounded-full flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="overflow-y-auto flex-1 px-6 py-4 max-h-[600px]">
            <form id="formExportLaporan" action="{{ route('laporan.export') }}" method="POST"
                class="flex flex-col gap-4">
                @csrf

                {{-- Jenis Data --}}
                <div class="w-40">
                    <label class="text-neutral-700 text-xs font-semibold font-['Inter'] uppercase tracking-wide">Jenis
                        Data</label>
                    <div class="h-10 bg-green-800 rounded-xl border border-green-800 flex items-center justify-center">
                        <span class="text-white text-md font-normal font-['Inter']">Data Laporan KTH</span>
                    </div>

                </div>

                {{-- Pencarian dengan Auto Complete --}}
                <div>
                    <label class="text-neutral-700 text-xs font-semibold font-['Inter'] uppercase tracking-wide">Cari
                        Nama KTH</label>
                    <div class="relative mt-1">
                        <input type="text" id="searchLaporanInput" name="search"
                            placeholder="Masukkan nama kelompok tani..."
                            class="w-full pl-9 pr-4 py-2.5 bg-zinc-100 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-sm font-['Inter'] placeholder:text-gray-500"
                            autocomplete="off">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        {{-- Auto Complete List --}}
                        <div id="searchLaporanResult"
                            class="absolute z-10 w-full mt-1 bg-white rounded-lg border border-stone-300 shadow-lg hidden max-h-48 overflow-y-auto">
                            <div id="searchLaporanResultList"></div>
                        </div>
                    </div>
                </div>

                {{-- Periode (Tahun) --}}
                <div>
                    <label class="text-neutral-700 text-xs font-semibold font-['Inter'] tracking-tight">Periode</label>
                    <select name="periode" id="periodeSelect"
                        class="w-full mt-1 px-4 py-2.5 bg-zinc-100 rounded-lg border border-stone-300 focus:outline-none focus:ring-2 focus:ring-emerald-900/20 focus:border-emerald-900 text-sm font-['Inter'] appearance-none cursor-pointer">
                        <option value="">Semua Periode</option>
                        @foreach ($tahunList as $tahun)
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Verifikasi --}}
                <div>
                    <label class="text-neutral-700 text-xs font-semibold font-['Inter'] tracking-tight">Status
                        Verifikasi</label>
                    <div class="flex flex-wrap gap-2 mt-1">
                        <label
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-zinc-100 rounded-full border border-stone-300 cursor-pointer hover:bg-gray-200 transition-all duration-200">
                            <input type="checkbox" name="status_verifikasi[]" value="pending"
                                class="status-checkbox-laporan w-3.5 h-3.5 text-emerald-900 rounded focus:ring-emerald-900">
                            <span class="text-zinc-900 text-xs font-normal font-['Inter']">Pending</span>
                        </label>
                        <label
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-zinc-100 rounded-full border border-stone-300 cursor-pointer hover:bg-gray-200 transition-all duration-200">
                            <input type="checkbox" name="status_verifikasi[]" value="verified"
                                class="status-checkbox-laporan w-3.5 h-3.5 text-emerald-900 rounded focus:ring-emerald-900">
                            <span class="text-zinc-900 text-xs font-normal font-['Inter']">Verified</span>
                        </label>
                        <label
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-zinc-100 rounded-full border border-stone-300 cursor-pointer hover:bg-gray-200 transition-all duration-200">
                            <input type="checkbox" name="status_verifikasi[]" value="rejected"
                                class="status-checkbox-laporan w-3.5 h-3.5 text-emerald-900 rounded focus:ring-emerald-900">
                            <span class="text-zinc-900 text-xs font-normal font-['Inter']">Rejected</span>
                        </label>
                    </div>
                </div>

                {{-- Format File --}}
                <div>
                    <label class="text-neutral-700 text-xs font-semibold font-['Inter'] uppercase tracking-wide">Format
                        File</label>
                    <div class="grid grid-cols-2 gap-3 mt-1">
                        <label id="excelOptionLaporan"
                            class="flex items-center gap-3 p-2.5 bg-white rounded-xl border-2 border-primary cursor-pointer hover:bg-gray-50 transition-all duration-200">
                            <input type="radio" name="format" value="excel" checked class="hidden">
                            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-primary text-sm font-normal font-['Inter']">Excel</p>
                                <p class="text-primary text-xs font-normal font-['Inter']">.xlsx</p>
                            </div>
                        </label>
                        <label id="pdfOptionLaporan"
                            class="flex items-center gap-3 p-2.5 bg-white rounded-xl border border-stone-300 cursor-pointer hover:bg-gray-50 transition-all duration-200">
                            <input type="radio" name="format" value="pdf" class="hidden">
                            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-primary text-sm font-normal font-['Inter']">PDF</p>
                                <p class="text-primary-500 text-xs font-normal font-['Inter']">.pdf</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Ringkasan Data --}}
                <div class="flex items-center gap-3 p-3 bg-green-800/10 rounded-xl border border-green-800/20">
                    <svg class="w-5 h-5 text-emerald-900 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-emerald-900 text-sm font-semibold font-['Inter']">Ringkasan Data</p>
                        <p class="text-green-900 text-sm font-normal font-['Inter']" id="totalLaporanDisplay">
                            Total <span class="font-bold"
                                id="totalLaporanCount">{{ number_format($totalData) }}</span> data laporan
                        </p>
                        <p class="text-xs text-neutral-500 mt-0.5" id="filterLaporanStatus">Semua status</p>
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div
            class="px-6 py-3 bg-white border-t border-stone-300 flex flex-wrap justify-between items-center gap-3 sticky bottom-0 flex-shrink-0">
            <div class="flex items-center gap-4 text-xs text-neutral-500">
                <span>🔒 Data aman</span>
                <span>⚡ Proses cepat</span>
                <span>📁 Tersimpan</span>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="resetFilterLaporan()"
                    class="px-4 py-1.5 text-neutral-600 text-sm font-normal font-['Inter'] hover:bg-gray-100 rounded-lg transition-all duration-200">
                    Reset Filter
                </button>
                <button type="submit" form="formExportLaporan"
                    class="flex items-center gap-2 px-5 py-2 bg-green-800 rounded-xl text-white text-sm font-normal font-['Inter'] hover:bg-green-700 transition-all duration-200 shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Ekspor Sekarang
                </button>
            </div>
        </div>
    </div>
</dialog>

<script>
    // ============================================
    // AUTO COMPLETE SEARCH UNTUK LAPORAN
    // ============================================
    (function() {
        var searchInput = document.getElementById('searchLaporanInput');
        var searchResult = document.getElementById('searchLaporanResult');
        var searchResultList = document.getElementById('searchLaporanResultList');
        var typingTimer;

        if (!searchInput) return;

        searchInput.addEventListener('input', function() {
            clearTimeout(typingTimer);
            var query = this.value.trim();

            if (query.length < 1) {
                searchResult.classList.add('hidden');
                updateTotalLaporan();
                return;
            }

            typingTimer = setTimeout(function() {
                // 🔥 Gunakan route search KTH (sama seperti di modal KTH)
                var url = '/admin/kth/search?search=' + encodeURIComponent(query);

                fetch(url)
                    .then(function(response) {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(function(data) {
                        if (data.length > 0) {
                            var html = '';
                            data.forEach(function(item) {
                                var desa = item.desa || '';
                                var kecamatan = item.kecamatan || '';
                                var lokasi = desa && kecamatan ? desa + ', ' +
                                    kecamatan : desa || kecamatan || '';

                                html += `
                                    <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-stone-100 last:border-0"
                                        onclick="selectLaporanSearchResult('${item.nama_kth}')">
                                        <div class="font-medium text-zinc-900 text-sm">${item.nama_kth}</div>
                                        ${lokasi ? `<div class="text-xs text-neutral-500">${lokasi}</div>` : ''}
                                    </div>
                                `;
                            });
                            searchResultList.innerHTML = html;
                            searchResult.classList.remove('hidden');
                        } else {
                            searchResultList.innerHTML = `
                                <div class="px-4 py-3 text-center text-neutral-500 text-sm">Tidak ditemukan</div>
                            `;
                            searchResult.classList.remove('hidden');
                        }
                        updateTotalLaporan();
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                        searchResultList.innerHTML = `
                            <div class="px-4 py-3 text-center text-red-500 text-sm">Gagal memuat data</div>
                        `;
                        searchResult.classList.remove('hidden');
                    });
            }, 300);
        });

        // Sembunyikan hasil saat klik di luar
        document.addEventListener('click', function(e) {
            if (searchInput && searchResult) {
                if (!searchInput.contains(e.target) && !searchResult.contains(e.target)) {
                    searchResult.classList.add('hidden');
                }
            }
        });
    })();

    function selectLaporanSearchResult(name) {
        var searchInput = document.getElementById('searchLaporanInput');
        var searchResult = document.getElementById('searchLaporanResult');
        if (searchInput) {
            searchInput.value = name;
        }
        if (searchResult) {
            searchResult.classList.add('hidden');
        }
        updateTotalLaporan();
    }

    // ============================================
    // UPDATE TOTAL DATA SAAT FILTER BERUBAH
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('formExportLaporan');
        if (!form) return;

        var inputs = form.querySelectorAll('input, select');

        inputs.forEach(function(input) {
            input.addEventListener('change', function() {
                updateTotalLaporan();
            });
            input.addEventListener('input', function() {
                if (this.type !== 'text') return;
                clearTimeout(this.timer);
                this.timer = setTimeout(function() {
                    updateTotalLaporan();
                }, 500);
            });
        });
    });

    function updateTotalLaporan() {
        var form = document.getElementById('formExportLaporan');
        if (!form) return;

        var formData = new FormData(form);
        var searchParams = new URLSearchParams();

        for (var pair of formData.entries()) {
            if (pair[1] && pair[1] !== '') {
                if (pair[0] === '_token' || pair[0] === 'format') continue;

                if (pair[0] === 'status_verifikasi[]') {
                    searchParams.append('status_verifikasi[]', pair[1]);
                } else {
                    searchParams.append(pair[0], pair[1]);
                }
            }
        }

        var url = '/admin/laporan/export-count?' + searchParams.toString();
        console.log('Fetching URL:', url);

        var countDisplay = document.getElementById('totalLaporanCount');
        var statusDisplay = document.getElementById('filterLaporanStatus');
        if (countDisplay) {
            countDisplay.textContent = '...';
        }

        fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(function(response) {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Server error: ' + response.status);
                }
                return response.json();
            })
            .then(function(data) {
                console.log('Data received:', data);

                if (countDisplay) {
                    if (data.success === false) {
                        countDisplay.textContent = '0';
                        if (statusDisplay) {
                            statusDisplay.textContent = 'Error: ' + (data.message || 'Terjadi kesalahan');
                            statusDisplay.style.color = 'red';
                        }
                    } else {
                        countDisplay.textContent = data.total || 0;
                        if (statusDisplay) {
                            statusDisplay.style.color = '';
                        }
                    }
                }

                if (statusDisplay && data.success !== false) {
                    var statuses = [];
                    var checkboxes = document.querySelectorAll('.status-checkbox-laporan:checked');
                    checkboxes.forEach(function(cb) {
                        statuses.push(cb.value.charAt(0).toUpperCase() + cb.value.slice(1));
                    });

                    var periode = document.getElementById('periodeSelect').value;
                    var search = document.getElementById('searchLaporanInput').value;

                    var filters = [];
                    if (search) filters.push('Cari: "' + search + '"');
                    if (periode) filters.push('Periode: ' + periode);
                    if (statuses.length > 0) filters.push('Status: ' + statuses.join(', '));

                    if (filters.length > 0) {
                        statusDisplay.textContent = 'Filter: ' + filters.join(' | ');
                    } else {
                        statusDisplay.textContent = 'Semua status';
                    }
                }
            })
            .catch(function(error) {
                console.error('Error updating total data:', error);

                if (countDisplay) {
                    countDisplay.textContent = '0';
                }
                if (statusDisplay) {
                    statusDisplay.textContent = 'Error: ' + error.message;
                    statusDisplay.style.color = 'red';
                }
            });
    }

    // ============================================
    // FUNGSI BUKA MODAL
    // ============================================
    window.openModalExportLaporan = function() {
        var modal = document.getElementById('modalExportLaporan');
        if (modal) {
            modal.showModal();
            document.body.classList.add('no-scroll');
            setTimeout(function() {
                updateTotalLaporan();
            }, 300);
        }
    };

    // ============================================
    // FUNGSI TUTUP MODAL
    // ============================================
    window.closeModalExportLaporan = function() {
        var modal = document.getElementById('modalExportLaporan');
        if (modal) {
            modal.close();
            document.body.classList.remove('no-scroll');
        }
    };

    // ============================================
    // FORMAT FILE TOGGLE LAPORAN
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        var excelOption = document.getElementById('excelOptionLaporan');
        var pdfOption = document.getElementById('pdfOptionLaporan');

        if (excelOption && pdfOption) {
            // Set default: Excel aktif
            excelOption.className =
                'flex items-center gap-3 p-2.5 bg-white rounded-xl border-2 border-primary cursor-pointer hover:bg-gray-50 transition-all duration-200';
            pdfOption.className =
                'flex items-center gap-3 p-2.5 bg-white rounded-xl border border-stone-300 cursor-pointer hover:bg-gray-50 transition-all duration-200';

            excelOption.addEventListener('click', function() {
                var radio = this.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
                this.className =
                    'flex items-center gap-3 p-2.5 bg-white rounded-xl border-2 border-primary cursor-pointer hover:bg-gray-50 transition-all duration-200';
                pdfOption.className =
                    'flex items-center gap-3 p-2.5 bg-white rounded-xl border border-stone-300 cursor-pointer hover:bg-gray-50 transition-all duration-200';
            });

            pdfOption.addEventListener('click', function() {
                var radio = this.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
                this.className =
                    'flex items-center gap-3 p-2.5 bg-white rounded-xl border-2 border-primary cursor-pointer hover:bg-gray-50 transition-all duration-200';
                excelOption.className =
                    'flex items-center gap-3 p-2.5 bg-white rounded-xl border border-stone-300 cursor-pointer hover:bg-gray-50 transition-all duration-200';
            });
        }
    });

    // ============================================
    // FUNGSI RESET FILTER
    // ============================================
    window.resetFilterLaporan = function() {
        var form = document.getElementById('formExportLaporan');
        if (form) {
            form.reset();

            var excelRadio = form.querySelector('input[name="format"][value="excel"]');
            if (excelRadio) excelRadio.checked = true;

            var excelOption = document.getElementById('excelOptionLaporan');
            var pdfOption = document.getElementById('pdfOptionLaporan');
            if (excelOption && pdfOption) {
                excelOption.className =
                    'flex items-center gap-3 p-2.5 bg-white rounded-xl border-2 border-primary cursor-pointer hover:bg-gray-50 transition-all duration-200';
                pdfOption.className =
                    'flex items-center gap-3 p-2.5 bg-white rounded-xl border border-stone-300 cursor-pointer hover:bg-gray-50 transition-all duration-200';
            }

            document.getElementById('searchLaporanInput').value = '';
            document.getElementById('searchLaporanResult').classList.add('hidden');
            updateTotalLaporan();
        }
    };

    // ============================================
    // EVENT LISTENER MODAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('modalExportLaporan');
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
