@php
    $active = 'payments';
    $isRtl = app()->getLocale() === 'ar';
    $paymentFilters = [
        ['type' => 'select', 'name' => 'status', 'label' => __('Status'), 'span' => 2, 'options' => [
            '' => __('All Statuses'),
            'unpaid' => __('Unpaid'),
            'partially_paid' => __('Partial'),
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
        ['type' => 'number', 'name' => 'min_amount', 'label' => __('Min Amount'), 'span' => 2, 'placeholder' => '0.00'],
        ['type' => 'number', 'name' => 'max_amount', 'label' => __('Max Amount'), 'span' => 2, 'placeholder' => '0.00'],
    ];
@endphp
@extends('layouts.app')

@section('title', __('Collect Payments'))
@section('header', __('Payment Collection'))

@section('content')
<div class="space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-zinc-900 font-bold text-xl tracking-tight">{{ __('Pending Invoices') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Process community payments and issue digital receipts.') }}</p>
        </div>
        <a href="{{ route('payments') }}" class="flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 transition-colors">
            <i data-lucide="history" class="w-4 h-4"></i>
            {{ __('View All Transactions') }}
        </a>
    </div>

    <div class="premium-card p-6 bg-zinc-50/50">
        <x-listing-filters
            :action="route('payments.create')"
            :clear-url="route('payments.create')"
            :search-placeholder="__('Search invoices by reference or villager...')"
            :filters="$paymentFilters"
        />
    </div>

    @if(session('error') || session('success'))
    <div id="response_messages" class="animate-in slide-in-from-top-2">
        @if(session('error'))
        <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-700 flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <p class="text-sm font-semibold">{{ session('error') }}</p>
        </div>
        @else
        <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-700 flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <p class="text-sm font-semibold">{{ session('success') }}</p>
        </div>
        @endif
    </div>
    @endif

    @forelse ($villagerGroups as $villagerGroup)
    <div class="space-y-6">
        <!-- Villager Header -->
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-zinc-900 flex items-center justify-center text-white font-bold shadow-lg">
                {{ strtoupper(substr($villagerGroup['name'] ?? 'U', 0, 1)) }}
            </div>
            <div>
                <h3 class="font-syne font-bold text-lg text-zinc-900">{{ $villagerGroup['name'] }}</h3>
                <p class="text-xs text-zinc-400 font-bold uppercase tracking-widest">{{ $villagerGroup['invoices']->count() }} {{ __('Pending Invoice(s)') }}</p>
            </div>
            <div class="flex-1 h-px bg-zinc-100 {{ $isRtl ? 'mr-4' : 'ml-4' }} hidden md:block"></div>
        </div>

        <!-- Invoices Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($villagerGroup['invoices'] as $invoice)
            @php
                $paid = $invoice->payments?->sum('amount_paid') ?? 0;
                $remaining = $invoice->remaining_amount ?? $invoice->total_amount;
                $total = $invoice->total_amount;
            @endphp
            
            <div class="premium-card flex flex-col group overflow-hidden">
                <!-- Card Top -->
                <div class="p-6 bg-zinc-50/50 border-b border-zinc-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-zinc-200 flex items-center justify-center text-zinc-400 group-hover:text-emerald-600 group-hover:border-emerald-200 transition-all shadow-sm">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-tighter">#{{ $invoice->id }}</p>
                            <h4 class="font-bold text-zinc-900">{{ $invoice->invoice_reference }}</h4>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-zinc-500">{{ __('Villager') }}</span>
                            <span class="font-bold text-zinc-700">{{ $invoice->reading?->meter?->villager->user->name }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-zinc-500">{{ __('Meter') }}</span>
                            <span class="font-mono text-zinc-700">{{ $invoice->reading?->meter?->meter_reference }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-zinc-500">{{ __('Period') }}</span>
                            <span class="font-bold text-zinc-700">{{ $invoice->billing_period }}</span>
                        </div>
                    </div>
                </div>

                <!-- Card Progress -->
                <div class="p-6 flex-1 space-y-4">
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">{{ __('Remaining') }}</p>
                            <p class="text-xl font-syne font-bold text-rose-500">{{ number_format($remaining, 2) }} <span class="text-xs">DH</span></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">{{ __('Total') }}</p>
                            <p class="text-sm font-bold text-zinc-900">{{ number_format($total, 2) }} DH</p>
                        </div>
                    </div>

                    <progress value="{{ $paid }}" max="{{ $total > 0 ? $total : 1 }}" class="w-full h-1.5 rounded-full overflow-hidden accent-emerald-500 bg-zinc-100"></progress>
                </div>

                <!-- Payment Form -->
                <div class="p-6 pt-0 mt-auto">
                    <form action="{{ route('payments.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                        @if ($remaining > 0)
                        <div class="relative group">
                            <input type="number" name="amount_paid" step="0.01" min="0" max="{{ $remaining }}" placeholder="0.00" 
                                class="input-field pr-12 text-center font-bold text-lg" required />
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-bold text-zinc-400">DH</span>
                        </div>
                        <button type="submit" class="btn-primary w-full shadow-emerald-200">
                            {{ __('Collect Payment') }}
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                        @else
                        <div class="w-full flex items-center justify-center gap-2 bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl font-bold text-sm">
                            <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                            {{ __('Fully Paid') }}
                        </div>
                        @endif
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="premium-card p-10 text-center">
        <i data-lucide="file-x" class="w-12 h-12 text-zinc-200 mx-auto mb-4"></i>
        <h4 class="text-zinc-900 font-bold">{{ __('No invoices found') }}</h4>
        <p class="text-zinc-500 text-sm mt-1">{{ __('Start by generating invoices from meter readings.') }}</p>
    </div>
    @endforelse
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
