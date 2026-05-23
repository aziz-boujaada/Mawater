@php $active = 'meters'; @endphp
@extends('layouts.app')

@section('title', __('Meter Details'))
@section('header', __('Infrastructure Asset'))

@section('content')
<div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('meters') }}" class="flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            {{ __('Back to List') }}
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('meter.edit', $meter->id) }}" class="btn-primary bg-zinc-900 hover:bg-zinc-800 shadow-none">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                {{ __('Edit Meter') }}
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Stats Card -->
        <div class="lg:col-span-2 space-y-8">
            <div class="premium-card p-8">
                <div class="flex items-start gap-6">
                    <div class="w-20 h-20 rounded-3xl bg-emerald-600 flex items-center justify-center shadow-2xl shadow-emerald-600/20">
                        <i data-lucide="gauge" class="text-white w-10 h-10"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <h2 class="text-3xl font-syne font-bold text-zinc-900">{{ $meter->meter_reference ?? 'N/A' }}</h2>
                            @php
                                $statusClasses = match($meter->status) {
                                    'active' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'broken' => 'bg-rose-50 text-rose-600 border-rose-100',
                                    'repaired' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    default => 'bg-amber-50 text-amber-600 border-amber-100'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold border {{ $statusClasses }} uppercase tracking-wider">
                                {{ $meter->status }}
                            </span>
                        </div>
                        <p class="text-zinc-500 font-medium">{{ __('Internal ID:') }} <span class="font-mono">#{{ $meter->id }}</span></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-8 mt-12 pt-8 border-t border-zinc-100">
                    <div>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">{{ __('Installation Date') }}</p>
                        <p class="text-sm font-bold text-zinc-900">{{ \Carbon\Carbon::parse($meter->installation_date)->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">{{ __('Villager Name') }}</p>
                        <p class="text-sm font-bold text-zinc-900">{{ $meter->villager?->user?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">{{ __('Phone Number') }}</p>
                        <p class="text-sm font-bold text-zinc-900">{{ $meter->villager?->user?->phone ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Readings -->
            <div class="premium-card overflow-hidden">
                <div class="p-6 border-b border-zinc-100 bg-zinc-50/50 flex items-center justify-between">
                    <h3 class="font-syne font-bold text-zinc-900">{{ __('Recent Readings') }}</h3>
                    <a href="{{ route('readings') }}" class="text-xs font-bold text-emerald-600 hover:underline">{{ __('View All') }}</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-zinc-50 text-[10px] font-bold text-zinc-400 uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4">{{ __('Date') }}</th>
                                <th class="px-6 py-4 text-center">{{ __('Reading') }}</th>
                                <th class="px-6 py-4 text-center">{{ __('Consumption') }}</th>
                                <th class="px-6 py-4 text-right">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            @forelse($meter->meterReadings->sortByDesc('reading_date')->take(5) as $reading)
                            <tr class="group hover:bg-zinc-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-zinc-700">{{ \Carbon\Carbon::parse($reading->reading_date)->format('M d, Y') }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-bold text-zinc-900">{{ number_format($reading->current_reading, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-bold">
                                        {{ number_format($reading->consumption, 2) }} m³
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('reading.show', $reading->id) }}" class="p-2 rounded-lg text-zinc-400 hover:text-emerald-600 transition-colors">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-zinc-500 italic text-sm">
                                    {{ __('No reading history found for this meter.') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="premium-card p-6 bg-zinc-900 text-white">
                <h3 class="font-syne font-bold text-lg mb-4">{{ __('Quick Actions') }}</h3>
                <div class="space-y-3">
                    <a href="{{ route('reading.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/5 transition-all group">
                        <i data-lucide="plus-circle" class="w-5 h-5 text-emerald-400"></i>
                        <span class="text-sm font-semibold">{{ __('New Reading') }}</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-all"></i>
                    </a>
                    <a href="{{ route('repairs.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/5 transition-all group">
                        <i data-lucide="wrench" class="w-5 h-5 text-blue-400"></i>
                        <span class="text-sm font-semibold">{{ __('Report Issue') }}</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-all"></i>
                    </a>
                </div>
            </div>

            <div class="premium-card p-6 border-emerald-100">
                <h3 class="font-syne font-bold text-zinc-900 mb-4">{{ __('Support Notes') }}</h3>
                <p class="text-xs text-zinc-500 leading-relaxed">
                    {{ __('If this meter is showing irregular readings, please schedule a maintenance check with a repair agent immediately.') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
