@php $active = 'readings'; @endphp
@extends('layouts.app')

@section('title', __('Add Reading'))
@section('header', __('Usage Registration'))

@section('content')
<div class="max-w-2xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="premium-card overflow-hidden">
        <div class="p-8 border-b border-zinc-100 bg-zinc-50/50">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-200 mb-6">
                <i data-lucide="gauge" class="text-white w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-syne font-bold text-zinc-900">{{ __('Record Meter Reading') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Enter current consumption data for village water meters.') }}</p>
        </div>

        <form action="{{ route('reading.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <!-- Meter Selection -->
            <div class="space-y-2">
                <label for="meterSelect" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Select Asset') }}</label>
                <div class="relative group">
                    <select name="meter_id" id="meterSelect" required class="input-field appearance-none cursor-pointer">
                        <option value="" disabled selected>{{ __('Choose a meter…') }}</option>
                        @foreach($meter_of->groupBy(fn($meter) => $meter->villager->id) as $villagerId => $meters)
                            <optgroup label="{{ $meters->first()->villager->user->name }}">
                                @foreach($meters as $meter)
                                    <option value="{{ $meter->id }}" data-status="{{ $meter->status }}">
                                        {{ __('Ref:') }} {{ $meter->meter_reference }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-zinc-400 group-hover:text-emerald-500 transition-colors">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>

                <div id="brokenMessage" class="hidden mt-4 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 text-xs font-semibold animate-in zoom-in-95">
                    <div class="flex items-center gap-2">
                        <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                        <span>{{ __('This meter is broken — consumption will be calculated using community averages.') }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Current Reading -->
                <div class="space-y-2">
                    <label for="current_reading" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Current Reading (m³)') }}</label>
                    <input type="number" step="0.01" id="current_reading" name="current_reading" required placeholder="0.00" class="input-field" />
                </div>

                <!-- Reading Date -->
                <div class="space-y-2">
                    <label for="reading_date" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Date of Record') }}</label>
                    <input type="date" id="reading_date" name="reading_date" required class="input-field" />
                </div>
            </div>

            @if ($errors->any() || session('error'))
            <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4">
                <ul class="space-y-1">
                    @if(session('error'))
                        <li class="text-rose-600 text-xs font-medium flex items-center gap-2">
                            <i data-lucide="alert-circle" class="w-3 h-3"></i>
                            {{ session('error') }}
                        </li>
                    @endif
                    @foreach ($errors->all() as $error)
                        <li class="text-rose-600 text-xs font-medium flex items-center gap-2">
                            <i data-lucide="alert-circle" class="w-3 h-3"></i>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="pt-4 border-t border-zinc-100 flex items-center justify-end gap-3">
                <a href="{{ route('readings') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-zinc-500 hover:bg-zinc-100 transition-all">{{ __('Cancel') }}</a>
                <button type="submit" class="btn-primary px-8">
                    {{ __('Save Reading') }}
                    <i data-lucide="check" class="w-4 h-4"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('meterSelect');
        const message = document.getElementById('brokenMessage');

        select.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const status = selectedOption.getAttribute('data-status');

            if (status === 'broken') {
                message.classList.remove('hidden');
            } else {
                message.classList.add('hidden');
            }
        });
    });
</script>
@endsection
