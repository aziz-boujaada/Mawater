@php $active = 'dashboard'; @endphp
@extends('layouts.app')

@section('title', __('Collector Dashboard'))
@section('header', __('Collection Overview'))

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <!-- Readings -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-teal-50 flex items-center justify-center">
                    <i data-lucide="activity" class="text-teal-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-teal-600 bg-teal-50 px-2 py-1 rounded-lg">{{ __('Readings') }}</span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Total Readings') }}</h3>
                <p class="text-3xl font-syne font-bold text-zinc-900 mt-1">{{ $readingsCount }}</p>
            </div>
        </div>

        <!-- Invoices -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center">
                    <i data-lucide="file-text" class="text-indigo-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg">{{ __('Invoices') }}</span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Total Invoices') }}</h3>
                <p class="text-3xl font-syne font-bold text-zinc-900 mt-1">{{ $invoicesCount }}</p>
            </div>
        </div>

        <!-- Payments -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center">
                    <i data-lucide="credit-card" class="text-amber-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-lg">{{ __('Payments') }}</span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Total Payments') }}</h3>
                <p class="text-3xl font-syne font-bold text-zinc-900 mt-1">{{ $paymentsCount }}</p>
            </div>
        </div>

        <!-- Collected -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center">
                    <i data-lucide="banknote" class="text-emerald-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">{{ __('Collected') }}</span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Total Collected') }}</h3>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-syne font-bold text-emerald-600 mt-1">{{ number_format($totalCollected, 0) }}</p>
                    <span class="text-sm font-bold text-emerald-600/50">DH</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Tabs -->
    <div class="premium-card overflow-hidden">
        <div class="border-b border-zinc-100 bg-zinc-50/50">
            <div class="flex p-1 gap-1">
                <button onclick="switchTab('readings')" id="tab-readings" class="tab-btn flex items-center gap-2 px-6 py-3 text-sm font-bold rounded-xl transition-all duration-200 bg-white text-emerald-600 shadow-sm border border-zinc-200">
                    <i data-lucide="activity" class="w-4 h-4"></i>
                    {{ __('Recent Readings') }}
                </button>
                <button onclick="switchTab('invoices')" id="tab-invoices" class="tab-btn flex items-center gap-2 px-6 py-3 text-sm font-bold rounded-xl transition-all duration-200 text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    {{ __('Pending Invoices') }}
                </button>
                <button onclick="switchTab('payments')" id="tab-payments" class="tab-btn flex items-center gap-2 px-6 py-3 text-sm font-bold rounded-xl transition-all duration-200 text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                    {{ __('Recent Payments') }}
                </button>
            </div>
        </div>

        <div class="p-6">
            <div id="panel-readings" class="tab-panel animate-in fade-in duration-500">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-syne font-bold text-zinc-900">{{ __('Latest Meter Readings') }}</h3>
                    <a href="{{ route('readings') }}" class="text-xs font-bold text-emerald-600 hover:underline">{{ __('View All') }}</a>
                </div>
                <div class="bg-zinc-50 rounded-2xl p-8 text-center border border-dashed border-zinc-200">
                    <p class="text-zinc-400 text-sm italic">{{ __('Readings detailed view will be implemented in the Readings module.') }}</p>
                </div>
            </div>

            <div id="panel-invoices" class="tab-panel hidden animate-in fade-in duration-500">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-syne font-bold text-zinc-900">{{ __('Pending Invoices') }}</h3>
                    <a href="{{ route('invoices') }}" class="text-xs font-bold text-emerald-600 hover:underline">{{ __('View All') }}</a>
                </div>
                <div class="bg-zinc-50 rounded-2xl p-8 text-center border border-dashed border-zinc-200">
                    <p class="text-zinc-400 text-sm italic">{{ __('Invoices detailed view will be implemented in the Invoices module.') }}</p>
                </div>
            </div>

            <div id="panel-payments" class="tab-panel hidden animate-in fade-in duration-500">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-syne font-bold text-zinc-900">{{ __('Recent Payments') }}</h3>
                    <a href="{{ route('payments') }}" class="text-xs font-bold text-emerald-600 hover:underline">{{ __('View All') }}</a>
                </div>
                <div class="bg-zinc-50 rounded-2xl p-8 text-center border border-dashed border-zinc-200">
                    <p class="text-zinc-400 text-sm italic">{{ __('Payments detailed view will be implemented in the Payments module.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchTab(tab) {
        // Hide all panels
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
        // Reset all buttons
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('bg-white', 'text-emerald-600', 'shadow-sm', 'border-zinc-200');
            b.classList.add('text-zinc-400', 'hover:text-zinc-600', 'hover:bg-zinc-100');
        });
        // Show selected panel
        document.getElementById('panel-' + tab).classList.remove('hidden');
        // Activate selected button
        const btn = document.getElementById('tab-' + tab);
        btn.classList.add('bg-white', 'text-emerald-600', 'shadow-sm', 'border-zinc-200');
        btn.classList.remove('text-zinc-400', 'hover:text-zinc-600', 'hover:bg-zinc-100');
    }
</script>
@endpush
@endsection
