@php $active = 'meters'; @endphp
@extends('layouts.app')

@section('title', __('Update Meter'))
@section('header', __('Infrastructure Maintenance'))

@section('content')
<div class="max-w-2xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="premium-card overflow-hidden">
        <div class="p-8 border-b border-zinc-100 bg-zinc-50/50">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-200 mb-6">
                <i data-lucide="refresh-cw" class="text-white w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-syne font-bold text-zinc-900">{{ __('Update Meter Status') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Modify the operational state of meter #') }}{{ $id }}.</p>
        </div>

        <form action="{{ route('meter.update', $id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label for="status" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Meter Status') }}</label>
                <div class="relative group">
                    <select name="status" id="status" required class="input-field appearance-none cursor-pointer">
                        <option value="" disabled>{{ __('Select a status…') }}</option>
                        <option value="active">✅ {{ __('Active') }}</option>
                        <option value="broken">🔴 {{ __('Broken') }}</option>
                        <option value="repaired">🔧 {{ __('Repaired') }}</option>
                        <option value="out_service">⚠️ {{ __('Out of Service') }}</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-zinc-400 group-hover:text-emerald-500 transition-colors">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
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
                    {{ __('Update Meter') }}
                    <i data-lucide="save" class="w-4 h-4"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
