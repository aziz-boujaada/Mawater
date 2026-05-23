@php $active = 'meters'; @endphp
@extends('layouts.app')

@section('title', __('Create Meter'))
@section('header', __('Infrastructure Registration'))

@section('content')
<div class="max-w-2xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="premium-card overflow-hidden">
        <div class="p-8 border-b border-zinc-100 bg-zinc-50/50">
            <div class="w-12 h-12 rounded-2xl bg-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-200 mb-6">
                <i data-lucide="gauge" class="text-white w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-syne font-bold text-zinc-900">{{ __('Register New Meter') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Add a new water meter to the system and assign it to a villager.') }}</p>
        </div>

        <form action="{{ route('meter.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Villager -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Villager') }}</label>
                    <select name="villager_id" required class="input-field appearance-none cursor-pointer">
                        <option value="" disabled selected>{{ __('Select a villager') }}</option>
                        @foreach($villagers as $villager)
                            <option value="{{ $villager->id }}">{{ $villager->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Initial Status') }}</label>
                    <select name="status" required class="input-field appearance-none cursor-pointer">
                        <option value="active">{{ __('Active') }}</option>
                        <option value="broken">{{ __('Broken') }}</option>
                    </select>
                </div>

                <!-- Installation Date -->
                <div class="space-y-2">
                    <label for="installation_date" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Installation Date') }}</label>
                    <input type="date" id="installation_date" name="installation_date" required class="input-field" />
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
                <a href="{{ route('meters') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-zinc-500 hover:bg-zinc-100 transition-all">{{ __('Cancel') }}</a>
                <button type="submit" class="btn-primary px-8">
                    {{ __('Create Meter') }}
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
