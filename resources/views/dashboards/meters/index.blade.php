@php
    $active = 'meters';
    $isRtl = app()->getLocale() === 'ar';
@endphp
@extends('layouts.app')

@section('title', __('Meters'))
@section('header', __('Meter Management'))

@section('content')
<div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <!-- Top Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-zinc-900 font-bold text-xl tracking-tight">{{ __('Infrastructure') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Manage and monitor all villager water meters.') }}</p>
        </div>
        <a href="{{ route('meter.create') }}" class="btn-primary w-full sm:w-auto">
            <i data-lucide="plus" class="w-4 h-4"></i>
            {{ __('New Meter') }}
        </a>
    </div>

    <!-- Feedback Messages -->
    <div id="response_messages">
        @if(session('error'))
        <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-700 flex items-center gap-3 animate-in slide-in-from-top-2">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <p class="text-sm font-semibold">{{ session('error') }}</p>
        </div>
        @elseif(session('success'))
        <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-700 flex items-center gap-3 animate-in slide-in-from-top-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <p class="text-sm font-semibold">{{ session('success') }}</p>
        </div>
        @endif
    </div>

    <!-- Main Table Card -->
    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/50">
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h3 class="font-syne font-bold text-zinc-900 text-sm">{{ __('All Registered Meters') }}</h3>
                </div>

                <x-listing-filters
                    :action="route('meters')"
                    :clear-url="route('meters')"
                    :search-placeholder="__('Search meters, references, or villager names...')"
                    :filters="[
                        ['type' => 'select', 'name' => 'status', 'label' => __('Status'), 'span' => 2, 'options' => [
                            '' => __('All Statuses'),
                            'active' => __('Active'),
                            'broken' => __('Broken'),
                            'repaired' => __('Repaired'),
                            'out_service' => __('Out of Service'),
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
                    ]"
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full {{ $isRtl ? 'text-right' : 'text-left' }}">
                <thead class="bg-zinc-50/50 text-zinc-400 uppercase text-[10px] font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4">{{ __('Reference') }}</th>
                        <th class="px-6 py-4">{{ __('Villager') }}</th>
                        <th class="px-6 py-4">{{ __('Installation') }}</th>
                        <th class="px-6 py-4">{{ __('Status') }}</th>
                        <th class="px-6 py-4 {{ $isRtl ? 'text-left' : 'text-right' }}">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($meters as $meter)
                    <tr class="group hover:bg-zinc-50 transition-all duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white border border-zinc-200 flex items-center justify-center text-zinc-400 group-hover:border-emerald-200 group-hover:text-emerald-500 group-hover:bg-emerald-50 transition-all">
                                    <i data-lucide="gauge" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-zinc-900">{{ $meter->meter_reference ?? 'N/A' }}</p>
                                    <p class="text-[10px] font-mono text-zinc-400 mt-0.5 uppercase tracking-tighter">#{{ $meter->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-zinc-100 flex items-center justify-center text-[10px] font-bold text-zinc-500 border border-white">
                                    {{ strtoupper(substr($meter->villager?->user?->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-zinc-700">{{ $meter->villager?->user?->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-semibold text-zinc-500">{{ \Carbon\Carbon::parse($meter->installation_date)->format('M d, Y') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusClasses = match($meter->status) {
                                    'active' => 'bg-emerald-50 text-emerald-600',
                                    'broken' => 'bg-rose-50 text-rose-600',
                                    'repaired' => 'bg-blue-50 text-blue-600',
                                    default => 'bg-amber-50 text-amber-600'
                                };
                                $statusDot = match($meter->status) {
                                    'active' => 'bg-emerald-500',
                                    'broken' => 'bg-rose-500',
                                    'repaired' => 'bg-blue-500',
                                    default => 'bg-amber-500'
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold {{ $statusClasses }} capitalize">
                                <span class="w-1.5 h-1.5 rounded-full {{ $statusDot }}"></span>
                                {{ $meter->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 {{ $isRtl ? 'text-left' : 'text-right' }}">
                            <div class="flex items-center {{ $isRtl ? 'justify-start' : 'justify-end' }} gap-2">
                                <a href="{{ route('meter.show', $meter->id) }}" class="p-2 rounded-lg text-zinc-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all" title="{{ __('View Details') }}">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('meter.edit', $meter->id) }}" class="p-2 rounded-lg text-zinc-400 hover:text-blue-600 hover:bg-blue-50 transition-all" title="{{ __('Edit Meter') }}">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center max-w-xs mx-auto">
                                <div class="w-16 h-16 rounded-3xl bg-zinc-50 flex items-center justify-center mb-4">
                                    <i data-lucide="gauge-circle" class="w-8 h-8 text-zinc-300"></i>
                                </div>
                                <h4 class="text-zinc-900 font-bold">{{ __('No meters found') }}</h4>
                                <p class="text-zinc-500 text-xs mt-1">{{ __('There are currently no meters registered in the system.') }}</p>
                                <a href="{{ route('meter.create') }}" class="mt-6 text-sm font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-2">
                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                    {{ __('Register your first meter') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($meters->hasPages())
        <div class="px-6 py-4 bg-zinc-50/50 border-t border-zinc-100">
            {{ $meters->links() }}
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
