@php $active = 'repairs'; @endphp
@extends('layouts.app')

@section('title', __('Repair Details'))
@section('header', __('Maintenance Record'))

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <!-- Top Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('repairs') }}" class="flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            {{ __('Back to Repairs') }}
        </a>
        <div class="flex items-center gap-3">
            <button class="btn-primary bg-zinc-900 hover:bg-zinc-800 shadow-none">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                {{ __('Update Status') }}
            </button>
        </div>
    </div>

    <!-- Repair Detail Card -->
    <div class="premium-card overflow-hidden">
        <!-- Header -->
        <div class="p-8 border-b border-zinc-100 bg-zinc-50/50 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-200">
                    <i data-lucide="wrench" class="text-white w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-syne font-bold text-zinc-900">{{ __('Repair Log #') }}{{ $repair->id }}</h2>
                    <p class="text-zinc-500 text-sm">{{ __('Log entry for') }} {{ \Carbon\Carbon::parse($repair->repair_date)->format('M d, Y') }}</p>
                </div>
            </div>
            
            <div class="text-right">
                @php
                    $statusClasses = match($repair->status) {
                        'repaired' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                        'in progress' => 'bg-amber-50 text-amber-600 border-amber-100',
                        default => 'bg-rose-50 text-rose-600 border-rose-100'
                    };
                @endphp
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold border {{ $statusClasses }} uppercase tracking-widest">
                    {{ $repair->status }}
                </span>
            </div>
        </div>

        <!-- Body -->
        <div class="p-8 space-y-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Asset Info -->
                <div class="space-y-8">
                    <div>
                        <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4">{{ __('Infrastructure Detail') }}</h3>
                        <div class="p-5 rounded-[24px] bg-zinc-50 border border-zinc-100 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-zinc-500 font-medium">{{ __('Meter Reference') }}</span>
                                <span class="text-sm font-bold text-zinc-900">{{ $repair->meter?->meter_reference ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-zinc-500 font-medium">{{ __('Villager') }}</span>
                                <span class="text-sm font-bold text-zinc-900">{{ $repair->meter?->villager?->user?->name ?? '—' }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4">{{ __('Assigned Personnel') }}</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                {{ strtoupper(substr($repair->repair_agent?->name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-zinc-900">{{ $repair->repair_agent?->name ?? __('System Assigned') }}</p>
                                <p class="text-[10px] text-zinc-400 font-bold uppercase">{{ __('Maintenance Specialist') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Problem & Cost -->
                <div class="space-y-8">
                    <div>
                        <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4">{{ __('Problem Description') }}</h3>
                        <div class="p-6 rounded-[24px] bg-white border border-zinc-200 shadow-sm min-h-[100px]">
                            <p class="text-zinc-600 text-sm leading-relaxed italic">
                                "{{ $repair->problem_description }}"
                            </p>
                        </div>
                    </div>

                    <div class="p-8 rounded-[32px] bg-zinc-900 text-white relative overflow-hidden">
                        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl"></div>
                        <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">{{ __('Repair Valuation') }}</h3>
                        <div class="flex items-baseline gap-2">
                            <p class="text-3xl font-syne font-bold text-emerald-400">{{ number_format($repair->repair_cost, 2) }}</p>
                            <span class="text-sm font-bold text-zinc-500">DH</span>
                        </div>
                        <p class="text-[10px] text-zinc-500 mt-4 leading-relaxed">{{ __('Financial loss attributed to infrastructure damage.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
