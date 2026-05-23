@php $active = 'readings'; @endphp
@extends('layouts.app')

@section('title', __('Reading Details'))
@section('header', __('Consumption Record'))

@section('content')
<div class="max-w-3xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <!-- Top Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('readings') }}" class="flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            {{ __('Back to Readings') }}
        </a>
        <div class="flex items-center gap-3">
            <button class="btn-primary bg-zinc-900 hover:bg-zinc-800 shadow-none">
                <i data-lucide="printer" class="w-4 h-4"></i>
                {{ __('Print Report') }}
            </button>
        </div>
    </div>

    <!-- Reading Card -->
    <div class="premium-card overflow-hidden">
        <!-- Header -->
        <div class="p-8 border-b border-zinc-100 bg-zinc-50/50 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-200">
                    <i data-lucide="activity" class="text-white w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-syne font-bold text-zinc-900">{{ __('Reading #') }}{{ $reading->id }}</h2>
                    <p class="text-zinc-500 text-sm">{{ __('Recorded on') }} {{ \Carbon\Carbon::parse($reading->reading_date)->format('M d, Y') }}</p>
                </div>
            </div>
            
            <div class="text-right">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase tracking-widest">
                    {{ number_format($reading->consumption, 2) }} m³
                </span>
            </div>
        </div>

        <!-- Body -->
        <div class="p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Info -->
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4">{{ __('Meter & Asset') }}</p>
                        <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-100 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-zinc-500">{{ __('Reference') }}</span>
                                <span class="text-sm font-bold text-zinc-900">{{ $reading->meter?->meter_reference ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-zinc-500">{{ __('Villager') }}</span>
                                <span class="text-sm font-medium text-zinc-700">{{ $reading->meter?->villager?->user?->name ?? '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Metrics -->
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4">{{ __('Reading Metrics') }}</p>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500">{{ __('Previous Reading') }}</span>
                                <span class="text-sm font-bold text-zinc-900">{{ number_format($reading->previous_reading, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500">{{ __('Current Reading') }}</span>
                                <span class="text-sm font-bold text-emerald-600">{{ number_format($reading->current_reading, 2) }}</span>
                            </div>
                            <div class="h-px bg-zinc-100 my-2"></div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-zinc-900">{{ __('Total Consumption') }}</span>
                                <span class="text-lg font-syne font-bold text-emerald-600">{{ number_format($reading->consumption, 2) }} m³</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($reading->meter?->status == 'broken')
            <div class="rounded-2xl bg-rose-50 border border-rose-200 p-6 flex items-start gap-4 animate-in zoom-in-95">
                <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="text-rose-600 w-5 h-5"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-rose-900">{{ __('System Notice: Broken Meter') }}</h4>
                    <p class="text-xs text-rose-600 mt-1 leading-relaxed">
                        {{ __('This meter is currently flagged as broken. Consumption values might be estimated or based on historical community averages. Please schedule a repair.') }}
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
