@php $active = 'repairs'; @endphp
@extends('layouts.app')

@section('title', __('Log Repair'))
@section('header', __('Maintenance Management'))

@section('content')
<div class="max-w-2xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="premium-card overflow-hidden">
        <div class="p-8 border-b border-zinc-100 bg-zinc-50/50">
            <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-200 mb-6">
                <i data-lucide="wrench" class="text-white w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-syne font-bold text-zinc-900">{{ __('Log New Repair') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Submit a repair request for a damaged or malfunctioning meter.') }}</p>
        </div>

        <form action="{{ route('repairs.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <!-- Meter Selection -->
            <div class="space-y-2">
                <label class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Assigned Meter') }}</label>
                <select name="meter_id" required class="input-field appearance-none cursor-pointer">
                    <option value="" disabled selected>{{ __('Select a villager & meter') }}</option>
                    @foreach($meters->groupBy(fn($meter) => $meter->villager->id) as $villagerId => $metersGroup)
                        <optgroup label="{{ $metersGroup->first()->villager->user->name }}">
                            @foreach($metersGroup as $meter)
                                <option value="{{ $meter->id }}">
                                    {{ __('Ref:') }} {{ $meter->meter_reference }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <!-- Problem Description -->
            <div class="space-y-2">
                <label for="problem_description" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Issue Description') }}</label>
                <textarea name="problem_description" id="problem_description" rows="3" required placeholder="{{ __('Describe the problem in detail...') }}" class="input-field"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Repair Cost -->
                <div class="space-y-2">
                    <label for="repair_cost" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Estimated Cost (DH)') }}</label>
                    <div class="relative">
                        <input type="number" step="0.01" name="repair_cost" id="repair_cost" placeholder="0.00" class="input-field pr-12" />
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-bold text-zinc-400">DH</span>
                    </div>
                </div>

                <!-- Status -->
                <div class="space-y-2">
                        <label for="status" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Repair Status') }}</label>
                    <select name="status" id="status" required class="input-field appearance-none cursor-pointer">
                            <option value="in progress">{{ __('In Progress') }}</option>
                            <option value="repaired">{{ __('Repaired') }}</option>
                    </select>
                </div>
            </div>

            @if ($errors->any())
            <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4">
                <ul class="space-y-1">
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
                <a href="{{ route('repairs') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-zinc-500 hover:bg-zinc-100 transition-all">{{ __('Cancel') }}</a>
                <button type="submit" class="btn-primary bg-indigo-600 hover:bg-indigo-700 shadow-indigo-200/50 px-8">
                    {{ __('Log Repair') }}
                    <i data-lucide="check" class="w-4 h-4"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
