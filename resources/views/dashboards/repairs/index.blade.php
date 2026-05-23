@php
    $active = 'repairs';
    $isRtl = app()->getLocale() === 'ar';
@endphp
@extends('layouts.app')

@section('title', __('Repairs'))
@section('header', __('Maintenance Records'))

@section('content')
<div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-zinc-900 font-bold text-xl tracking-tight">{{ __('System Maintenance') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Track meter repairs, costs, and infrastructure health.') }}</p>
        </div>
        <a href="{{ route('repairs.create') }}" class="btn-primary w-full sm:w-auto">
            <i data-lucide="plus" class="w-4 h-4"></i>
            {{ __('New Repair Request') }}
        </a>
    </div>

    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/50">
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h3 class="font-syne font-bold text-zinc-900 text-sm">{{ __('All Repair Logs') }}</h3>
                </div>

                <x-listing-filters
                    :action="route('repairs')"
                    :clear-url="route('repairs')"
                    :search-placeholder="__('Search repairs by meter, villager, or agent...')"
                    :filters="[
                        ['type' => 'select', 'name' => 'status', 'label' => __('Status'), 'span' => 2, 'options' => [
                            '' => __('All Statuses'),
                            'in progress' => __('In Progress'),
                            'repaired' => __('Repaired'),
                        ]],
                        ['type' => 'select', 'name' => 'date_range', 'label' => __('Date Range'), 'span' => 2, 'options' => [
                            '' => __('All Dates'),
                            'today' => __('Today'),
                            'week' => __('This Week'),
                            'month' => __('This Month'),
                            'year' => __('This Year'),
                        ]],
                        ['type' => 'date', 'name' => 'from', 'label' => __('From'), 'span' => 2],
                        ['type' => 'date', 'name' => 'to', 'label' => __('To'), 'span' => 2],
                        ['type' => 'number', 'name' => 'min_amount', 'label' => __('Min Amount'), 'span' => 2, 'placeholder' => '0.00'],
                        ['type' => 'number', 'name' => 'max_amount', 'label' => __('Max Amount'), 'span' => 2, 'placeholder' => '0.00'],
                    ]"
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full {{ $isRtl ? 'text-right' : 'text-left' }}">
                <thead class="bg-zinc-50/50 text-zinc-400 uppercase text-[10px] font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4">{{ __('Meter') }}</th>
                        <th class="px-6 py-4">{{ __('Villager') }}</th>
                        <th class="px-6 py-4">{{ __('Agent') }}</th>
                        <th class="px-6 py-4">{{ __('Status') }}</th>
                        <th class="px-6 py-4">{{ __('Cost') }}</th>
                        <th class="px-6 py-4">{{ __('Date') }}</th>
                        <th class="px-6 py-4 {{ $isRtl ? 'text-left' : 'text-right' }}">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($repairs as $repair)
                    <tr class="group hover:bg-zinc-50 transition-all duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white border border-zinc-200 flex items-center justify-center text-zinc-400 group-hover:border-emerald-200 group-hover:text-emerald-500 transition-all">
                                    <i data-lucide="wrench" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-zinc-900">{{ $repair->meter?->meter_reference ?? '—' }}</p>
                                    <p class="text-[10px] font-mono text-zinc-400 mt-0.5 uppercase tracking-tighter">#{{ $repair->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-zinc-700">
                            {{ $repair->meter?->villager?->user?->name ?? '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-indigo-50 flex items-center justify-center text-[10px] font-bold text-indigo-600 border border-indigo-100">
                                    {{ strtoupper(substr($repair->repair_agent?->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="text-xs font-semibold text-zinc-600">{{ $repair->repair_agent?->name ?? __('Unassigned') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusClasses = match($repair->status) {
                                    'repaired' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'in_progress' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    default => 'bg-rose-50 text-rose-600 border-rose-100'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $roleClasses ?? $statusClasses }} uppercase tracking-wider">
                                {{ str_replace('_', ' ', $repair->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-zinc-900">{{ number_format($repair->repair_cost, 2) }} DH</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-zinc-500">
                            {{ \Carbon\Carbon::parse($repair->repair_date)->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 {{ $isRtl ? 'text-left' : 'text-right' }}">
                            <a href="{{ route('repairs.show', $repair->id) }}" class="p-2 rounded-lg text-zinc-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all inline-block" title="{{ __('View Details') }}">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <i data-lucide="wrench" class="w-12 h-12 text-zinc-200 mx-auto mb-4"></i>
                            <h4 class="text-zinc-900 font-bold">{{ __('No repairs found') }}</h4>
                            <p class="text-zinc-500 text-xs mt-1">{{ __('Maintenance logs will appear here once repairs are logged.') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($repairs->hasPages())
        <div class="px-6 py-4 bg-zinc-50/50 border-t border-zinc-100">
            {{ $repairs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
