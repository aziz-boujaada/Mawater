@php $active = 'invoices'; @endphp
@extends('layouts.app')

@section('title', __('Create Invoice'))
@section('header', __('Billing Administration'))

@section('content')
<div class="max-w-2xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="premium-card overflow-hidden">
        <div class="p-8 border-b border-zinc-100 bg-zinc-50/50">
            <div class="w-12 h-12 rounded-2xl bg-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-200 mb-6">
                <i data-lucide="file-plus" class="text-white w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-syne font-bold text-zinc-900">{{ __('Generate New Invoice') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Select a meter reading to generate a corresponding villager invoice.') }}</p>
        </div>

        <form action="{{ route('invoices.store') }}" method="POST" class="p-8 space-y-8">
            @csrf

            <!-- Reading Selection -->
            <div class="space-y-3">
                <label for="reading_id" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Select Recent Reading') }}</label>
                <div class="relative group">
                    <select name="reading_id" id="reading_id" required class="input-field appearance-none cursor-pointer">
                        <option value="" disabled selected>{{ __('Choose a villager & reading period…') }}</option>
                        @forelse($readings->groupBy(fn($r) => $r->meter->villager->user->name) as $name => $group)
                            <optgroup label="{{ $name }}">
                                @foreach($group as $reading)
                                    <option value="{{ $reading->id }}">
                                        {{ \Carbon\Carbon::parse($reading->reading_date)->format('F Y') }} — {{ __('Consumption') }}: {{ number_format($reading->consumption, 2) }} m³
                                    </option>
                                @endforeach
                            </optgroup>
                        @empty
                            <option value="" disabled>{{ __('No pending readings available for invoicing.') }}</option>
                        @endforelse
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-zinc-400 group-hover:text-emerald-500 transition-colors">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <p class="text-[10px] text-zinc-400 italic px-1">{{ __('Note: Only readings that haven\'t been invoiced will appear here.') }}</p>
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

            <div class="pt-6 border-t border-zinc-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('invoices') }}" class="w-full sm:w-auto text-center px-6 py-2.5 rounded-xl text-sm font-bold text-zinc-500 hover:bg-zinc-100 transition-all">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="w-full sm:w-auto btn-primary px-8">
                    {{ __('Generate Invoice') }}
                    <i data-lucide="file-check" class="w-4 h-4"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
