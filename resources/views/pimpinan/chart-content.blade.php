<div class="relative h-64">
    @php
        $hasData = $hasData ?? false;
        $nteTrend = $nteTrend ?? [];
        $maxNte = $maxNte ?? 1;
        $months = $months ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $satuan = $satuan ?? '';
        $selectedYear = $selectedYear ?? now()->year;

        $actualMax = max($nteTrend) > 0 ? max($nteTrend) : 1;
        $maxHeight = 85;
    @endphp

    @if ($hasData)
        {{-- Container Flex untuk Label Y + Chart --}}
        <div class="absolute inset-0 flex" style="padding-bottom: 20px;">
            {{-- Label Y di kiri --}}
            <div class="flex flex-col justify-between text-[10px] text-neutral-400 pr-2"
                style="height: 100%; padding: 0; width: 50px; flex-shrink: 0;">
                @php
                    $roundedMax = ceil($actualMax / 10) * 10;
                    if ($roundedMax < 10) {
                        $roundedMax = 10;
                    }

                    $labelMax =
                        $satuan === 'Jt'
                            ? number_format($roundedMax, 1) . 'Jt'
                            : ($satuan === 'K'
                                ? number_format($roundedMax, 1) . 'K'
                                : number_format($roundedMax, 0, ',', '.'));
                    $label75 =
                        $satuan === 'Jt'
                            ? number_format($roundedMax * 0.75, 1) . 'Jt'
                            : ($satuan === 'K'
                                ? number_format($roundedMax * 0.75, 1) . 'K'
                                : number_format($roundedMax * 0.75, 0, ',', '.'));
                    $label50 =
                        $satuan === 'Jt'
                            ? number_format($roundedMax * 0.5, 1) . 'Jt'
                            : ($satuan === 'K'
                                ? number_format($roundedMax * 0.5, 1) . 'K'
                                : number_format($roundedMax * 0.5, 0, ',', '.'));
                    $label25 =
                        $satuan === 'Jt'
                            ? number_format($roundedMax * 0.25, 1) . 'Jt'
                            : ($satuan === 'K'
                                ? number_format($roundedMax * 0.25, 1) . 'K'
                                : number_format($roundedMax * 0.25, 0, ',', '.'));
                @endphp
                <span>{{ $labelMax }}</span>
                <span>{{ $label75 }}</span>
                <span>{{ $label50 }}</span>
                <span>{{ $label25 }}</span>
                <span>0</span>
            </div>

            {{-- Area Chart --}}
            <div class="flex-1 flex items-end justify-between px-2" style="height: 100%;">
                @foreach ($months as $index => $month)
                    @php
                        $value = $nteTrend[$index] ?? 0;
                        $height = $actualMax > 0 ? ($value / $actualMax) * $maxHeight : 0;
                        $height = max(2, $height);
                        $isZero = $value == 0;

                        $displayValue = $value;
                        if ($satuan === 'Jt') {
                            $displayValue = number_format($value, 1) . 'Jt';
                        } elseif ($satuan === 'K') {
                            $displayValue = number_format($value, 1) . 'K';
                        } else {
                            $displayValue = number_format($value, 0, ',', '.');
                        }
                    @endphp
                    <div class="flex flex-col items-center"
                        style="width: 8.33%; height: 100%; justify-content: flex-end;">
                        @if ($value > 0)
                            <span class="text-[9px] font-bold text-emerald-900 mb-1">{{ $displayValue }}</span>
                        @else
                            <span class="text-[9px] text-gray-300 mb-1">-</span>
                        @endif

                        <div class="w-8 rounded-t-lg transition-all duration-500 hover:opacity-80 cursor-pointer relative group"
                            style="height: {{ $height }}%; min-height: {{ $value > 0 ? '6px' : '4px' }}; 
                            background: {{ $isZero ? '#f3f4f6' : '#2B644A' }};">
                            @if ($value > 0)
                                <div
                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-1.5 bg-zinc-800 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap pointer-events-none z-10 shadow-lg">
                                    <span class="font-bold">{{ $month }} {{ $selectedYear }}</span><br>
                                    Rp
                                    {{ number_format($value * ($satuan === 'Jt' ? 1000000 : ($satuan === 'K' ? 1000 : 1)), 0, ',', '.') }}
                                </div>
                            @endif
                        </div>

                        <span class="text-neutral-500 text-[10px] font-medium mt-1.5">{{ $month }}</span>
                    </div>
                @endforeach
            </div>
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
</div>
