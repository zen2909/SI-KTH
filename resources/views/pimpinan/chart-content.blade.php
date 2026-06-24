@php
    $hasData = $hasData ?? false;
    $nteTrend = $nteTrend ?? [];
    $maxNte = $maxNte ?? 1;
    $months = $months ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $satuan = $satuan ?? '';
    $selectedYear = $selectedYear ?? now()->year;
@endphp

@if ($hasData)
    <div class="flex items-end justify-between px-2 pb-6 h-full">
        @foreach ($months as $index => $month)
            @php
                $value = $nteTrend[$index] ?? 0;
                $height = $maxNte > 0 ? max(8, ($value / $maxNte) * 85) : 0;
                $isZero = $value == 0;

                // Format nilai untuk tampilan di atas batang
                $displayValue = $value;
                if ($satuan === 'Jt') {
                    $displayValue = number_format($value, 1) . 'Jt';
                } elseif ($satuan === 'K') {
                    $displayValue = number_format($value, 1) . 'K';
                } else {
                    $displayValue = number_format($value, 0, ',', '.');
                }
            @endphp
            <div class="flex flex-col items-center" style="width: 8.33%;">
                {{-- Nilai di atas batang --}}
                @if ($value > 0)
                    <span class="text-[9px] font-bold text-emerald-900 mb-1">
                        {{ $displayValue }}
                    </span>
                @else
                    <span class="text-[9px] text-gray-300 mb-1">-</span>
                @endif

                {{-- Batang dengan tooltip --}}
                <div class="w-8 rounded-t-lg transition-all duration-500 hover:opacity-80 cursor-pointer relative group"
                    style="height: {{ $height }}%; min-height: {{ $value > 0 ? '6px' : '4px' }}; 
                    background: {{ $isZero ? '#f3f4f6' : 'linear-gradient(180deg, #0E4C34 0%, #1a7a4a 100%)' }};">

                    {{-- Tooltip hover --}}
                    @if ($value > 0)
                        <div
                            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-1.5 bg-zinc-800 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap pointer-events-none z-10 shadow-lg">
                            <span class="font-bold">{{ $month }} {{ $selectedYear }}</span><br>
                            Rp
                            {{ number_format($value * ($satuan === 'Jt' ? 1000000 : ($satuan === 'K' ? 1000 : 1)), 0, ',', '.') }}
                        </div>
                    @endif
                </div>

                {{-- Label bulan --}}
                <span class="text-neutral-500 text-[10px] font-medium mt-1.5">{{ $month }}</span>
            </div>
        @endforeach
    </div>

    {{-- Label sumbu Y dengan satuan --}}
    <div
        class="absolute left-0 top-0 flex flex-col justify-between h-full text-[10px] text-neutral-400 pb-6 pointer-events-none">
        @php
            $roundedMax = ceil($maxNte / 10) * 10;
            if ($roundedMax < 10) {
                $roundedMax = 10;
            }

            // Format label sumbu Y dengan satuan
            $labelMax = $roundedMax;
            if ($satuan === 'Jt') {
                $labelMax = number_format($roundedMax, 1) . 'Jt';
            } elseif ($satuan === 'K') {
                $labelMax = number_format($roundedMax, 1) . 'K';
            } else {
                $labelMax = number_format($roundedMax, 0, ',', '.');
            }

            $label75 = $roundedMax * 0.75;
            if ($satuan === 'Jt') {
                $label75 = number_format($label75, 1) . 'Jt';
            } elseif ($satuan === 'K') {
                $label75 = number_format($label75, 1) . 'K';
            } else {
                $label75 = number_format($label75, 0, ',', '.');
            }

            $label50 = $roundedMax * 0.5;
            if ($satuan === 'Jt') {
                $label50 = number_format($label50, 1) . 'Jt';
            } elseif ($satuan === 'K') {
                $label50 = number_format($label50, 1) . 'K';
            } else {
                $label50 = number_format($label50, 0, ',', '.');
            }

            $label25 = $roundedMax * 0.25;
            if ($satuan === 'Jt') {
                $label25 = number_format($label25, 1) . 'Jt';
            } elseif ($satuan === 'K') {
                $label25 = number_format($label25, 1) . 'K';
            } else {
                $label25 = number_format($label25, 0, ',', '.');
            }
        @endphp
        <span>{{ $labelMax }}</span>
        <span>{{ $label75 }}</span>
        <span>{{ $label50 }}</span>
        <span>{{ $label25 }}</span>
        <span>0</span>
    </div>
@else
    {{-- Tampilan jika tidak ada data --}}
    <div class="flex flex-col items-center justify-center h-full">
        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <p class="text-neutral-500 text-sm font-medium">Belum ada data NTE untuk tahun {{ $selectedYear }}</p>
        <p class="text-neutral-400 text-xs mt-1">Pilih tahun lain untuk melihat data</p>
    </div>
@endif
