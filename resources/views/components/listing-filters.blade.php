@props([
    'action',
    'clearUrl' => null,
    'searchPlaceholder' => __('Search...'),
    'searchValue' => request('search'),
    'filters' => [],
    'submitLabel' => __('Apply Filters'),
])

@php
    $isRtl = app()->getLocale() === 'ar';
    $searchPadding = $isRtl ? 'pr-10 pl-4' : 'pl-10 pr-4';
    $searchIconOffset = $isRtl ? 'right-3' : 'left-3';
    $activeBadges = [];

    if (filled($searchValue)) {
        $activeBadges[] = [
            'label' => __('Search'),
            'value' => $searchValue,
        ];
    }

    foreach ($filters as $filter) {
        $value = request()->query($filter['name'] ?? '');

        if ($value === null || $value === '') {
            continue;
        }

        $badgeValue = $value;

        if (($filter['type'] ?? 'select') === 'select' && isset($filter['options'][$value])) {
            $badgeValue = $filter['options'][$value];
        }

        $activeBadges[] = [
            'label' => $filter['label'] ?? ucfirst((string) ($filter['name'] ?? '')),
            'value' => $badgeValue,
        ];
    }

    if (filled(request('from')) || filled(request('to'))) {
        $dateParts = [];

        if (filled(request('from'))) {
            $dateParts[] = __('From') . ': ' . request('from');
        }

        if (filled(request('to'))) {
            $dateParts[] = __('To') . ': ' . request('to');
        }

        $activeBadges[] = [
            'label' => __('Date Range'),
            'value' => implode(' · ', $dateParts),
        ];
    }

    if (filled(request('min_amount')) || filled(request('max_amount'))) {
        $amountParts = [];

        if (filled(request('min_amount'))) {
            $amountParts[] = __('Min Amount') . ': ' . request('min_amount');
        }

        if (filled(request('max_amount'))) {
            $amountParts[] = __('Max Amount') . ': ' . request('max_amount');
        }

        $activeBadges[] = [
            'label' => __('Amount Range'),
            'value' => implode(' · ', $amountParts),
        ];
    }

    $hasActiveFilters = count($activeBadges) > 0;
@endphp

<form action="{{ $action }}" method="GET" class="space-y-4">
    <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">
        <div class="xl:col-span-4">
            <label class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest {{ $isRtl ? 'mr-1 ml-0' : 'ml-1' }}">{{ __('Search') }}</label>
            <div class="relative group mt-1">
                <div class="absolute inset-y-0 {{ $searchIconOffset }} flex items-center pointer-events-none text-zinc-400 group-focus-within:text-emerald-500 transition-colors">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input
                    type="text"
                    name="search"
                    value="{{ $searchValue }}"
                    placeholder="{{ $searchPlaceholder }}"
                    class="input-field {{ $searchPadding }}"
                >
            </div>
        </div>

        @foreach ($filters as $filter)
            @php
                $type = $filter['type'] ?? 'select';
                $name = $filter['name'] ?? '';
                $value = request()->query($name);
                $span = $filter['span'] ?? 2;
            @endphp

            <div class="xl:col-span-{{ $span }}">
                <label class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest {{ $isRtl ? 'mr-1 ml-0' : 'ml-1' }}">{{ $filter['label'] ?? ucfirst($name) }}</label>

                @if ($type === 'select')
                    <select name="{{ $name }}" class="input-field appearance-none cursor-pointer mt-1">
                        @foreach ($filter['options'] ?? [] as $optionValue => $optionLabel)
                            <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                        @endforeach
                    </select>
                @elseif ($type === 'date')
                    <input type="date" name="{{ $name }}" value="{{ $value }}" class="input-field mt-1">
                @elseif ($type === 'number')
                    <input
                        type="number"
                        name="{{ $name }}"
                        value="{{ $value }}"
                        step="{{ $filter['step'] ?? '0.01' }}"
                        min="{{ $filter['min'] ?? null }}"
                        max="{{ $filter['max'] ?? null }}"
                        placeholder="{{ $filter['placeholder'] ?? '' }}"
                        class="input-field mt-1"
                    >
                @endif
            </div>
        @endforeach

        <div class="xl:col-span-2 flex items-end gap-3">
            <button type="submit" class="btn-primary w-full">
                <i data-lucide="sliders-horizontal" class="w-4 h-4"></i>
                {{ $submitLabel }}
            </button>
        </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        @if ($hasActiveFilters)
            <div class="flex flex-wrap gap-2">
                @foreach ($activeBadges as $badge)
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                        <span class="uppercase tracking-widest text-[9px] text-emerald-500">{{ $badge['label'] }}</span>
                        <span class="text-emerald-700 normal-case tracking-normal">{{ $badge['value'] }}</span>
                    </span>
                @endforeach
            </div>
        @else
            <div></div>
        @endif

        @if ($hasActiveFilters && $clearUrl)
            <a href="{{ $clearUrl }}" class="inline-flex items-center justify-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
                {{ __('Reset Filters') }}
            </a>
        @endif
    </div>
</form>