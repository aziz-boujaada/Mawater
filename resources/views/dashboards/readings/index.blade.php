@php
    $active = 'readings';
    $isRtl = app()->getLocale() === 'ar';
@endphp
@extends('layouts.app')

@section('title', __('Readings'))
@section('header', __('Meter Readings'))

@section('content')
<div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-zinc-900 font-bold text-xl tracking-tight">{{ __('Usage Monitoring') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Track water consumption across all registered meters.') }}</p>
        </div>
          @if (Auth::user()->role == 'admin' || Auth::user()->role == 'collector')
        <a href="{{ route('reading.create') }}" class="btn-primary w-full sm:w-auto">
            <i data-lucide="plus" class="w-4 h-4"></i>
            {{ __('New Reading') }}
        </a>
        @endif
    </div>

    @if(session('error') || session('success'))
    <div id="response_messages" class="animate-in slide-in-from-top-2">
        @if(session('error'))
        <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-700 flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <p class="text-sm font-semibold">{{ session('error') }}</p>
        </div>
        @else
        <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-700 flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <p class="text-sm font-semibold">{{ session('success') }}</p>
        </div>
        @endif
    </div>
    @endif

    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/50">
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h3 class="font-syne font-bold text-zinc-900 text-sm">{{ __('Consumption Records') }}</h3>
                </div>

                <x-listing-filters
                    :action="route('readings')"
                    :clear-url="route('readings')"
                    :search-placeholder="__('Search readings by meter or villager...')"
                    :filters="[
                        ['type' => 'select', 'name' => 'date_range', 'label' => __('Date Range'), 'span' => 2, 'options' => [
                            '' => __('All Dates'),
                            'today' => __('Today'),
                            'week' => __('This Week'),
                            'month' => __('This Month'),
                            'year' => __('This Year'),
                        ]],
                        ['type' => 'date', 'name' => 'from', 'label' => __('From'), 'span' => 2],
                        ['type' => 'date', 'name' => 'to', 'label' => __('To'), 'span' => 2],
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
                        <th class="px-6 py-4 text-center">{{ __('Previous') }}</th>
                        <th class="px-6 py-4 text-center">{{ __('Current') }}</th>
                        <th class="px-6 py-4 text-center">{{ __('Consumption') }}</th>
                        <th class="px-6 py-4">{{ __('Date') }}</th>
                        <th class="px-6 py-4 {{ $isRtl ? 'text-left' : 'text-right' }}">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($readings as $reading)
                    <tr class="group hover:bg-zinc-50 transition-all duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white border border-zinc-200 flex items-center justify-center text-zinc-400 group-hover:border-emerald-200 group-hover:text-emerald-500 transition-all">
                                    <i data-lucide="gauge" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-zinc-900">{{ $reading->meter?->meter_reference ?? '—' }}</p>
                                    <p class="text-[10px] font-mono text-zinc-400 mt-0.5 uppercase tracking-tighter">#{{ $reading->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-zinc-700">
                            {{ $reading->meter?->villager?->user?->name ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-center text-sm font-medium text-zinc-500">
                            {{ number_format($reading->previous_reading, 2) }}
                        </td>
                        <td class="px-6 py-4 text-center text-sm font-bold text-zinc-900">
                            {{ number_format($reading->current_reading, 2) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2 py-1 rounded-lg bg-blue-50 text-blue-600 text-xs font-bold">
                                {{ number_format($reading->consumption, 2) }} m³
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-zinc-500">
                            {{ \Carbon\Carbon::parse($reading->reading_date)->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 {{ $isRtl ? 'text-left' : 'text-right' }}">
                            <a href="{{ route('reading.show', $reading->id) }}" class="p-2 rounded-lg text-zinc-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all inline-block" title="{{ __('View Reading') }}">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <i data-lucide="activity" class="w-12 h-12 text-zinc-200 mx-auto mb-4"></i>
                            <h4 class="text-zinc-900 font-bold">{{ __('No readings found') }}</h4>
                            <p class="text-zinc-500 text-xs mt-1">{{ __('Start by adding a new meter reading for a villager.') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($readings->hasPages())
        <div class="px-6 py-4 bg-zinc-50/50 border-t border-zinc-100">
            {{ $readings->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const responseMsg = document.getElementById('response_messages');
        if (responseMsg) {
            setTimeout(() => {
                responseMsg.classList.add('animate-out', 'fade-out', 'slide-out-to-top-2');
                setTimeout(() => responseMsg.remove(), 500);
            }, 5000);
        }
    });
</script>
@endsection
