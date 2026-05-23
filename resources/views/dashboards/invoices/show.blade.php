@php $active = 'invoices'; @endphp
@extends('layouts.app')

@section('title', __('Invoice Details'))
@section('header', __('Billing Statement'))

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <!-- Top Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('invoices') }}" class="flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            {{ __('Back to Invoices') }}
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('invoice.pdf', $invoice->id) }}" target="_blank" rel="noopener" class="btn-primary bg-zinc-900 hover:bg-zinc-800 shadow-none">
                <i data-lucide="printer" class="w-4 h-4"></i>
                {{ __('Print Invoice') }}
            </a>
            <a href="{{ route('payments.create', ['invoice_id' => $invoice->id]) }}" class="btn-primary">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                {{ __('Pay Invoice') }}
            </a>
        </div>
    </div>

    <!-- Invoice Card -->
    <div class="premium-card overflow-hidden">
        <!-- Card Header -->
        <div class="p-8 border-b border-zinc-100 bg-zinc-50/50 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-200">
                    <i data-lucide="file-text" class="text-white w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-syne font-bold text-zinc-900">{{ $invoice->invoice_reference }}</h2>
                    <p class="text-zinc-500 text-sm">{{ __('Issued for') }} {{ $invoice->billing_period }}</p>
                </div>
            </div>
            
            <div class="text-right">
                @php
                    $statusClasses = match($invoice->status) {
                        'paid' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                        'partially_paid' => 'bg-amber-50 text-amber-600 border-amber-100',
                        default => 'bg-rose-50 text-rose-600 border-rose-100'
                    };
                @endphp
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold border {{ $statusClasses }} uppercase tracking-widest">
                    {{ str_replace('_', ' ', $invoice->status) }}
                </span>
                <p class="text-[10px] text-zinc-400 font-bold uppercase tracking-tighter mt-2">ID: #{{ $invoice->id }}</p>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Left Column: Details -->
            <div class="space-y-8">
                <div>
                    <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4">{{ __('Subscriber Information') }}</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-zinc-100 flex items-center justify-center text-sm font-bold text-zinc-500">
                            {{ strtoupper(substr($invoice->reading?->meter?->villager?->user?->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-zinc-900">{{ $invoice->reading?->meter?->villager?->user?->name ?? '—' }}</p>
                            <p class="text-xs text-zinc-500">{{ $invoice->reading?->meter?->villager?->user?->email ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4">{{ __('Meter & Usage') }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-100">
                            <p class="text-[9px] font-bold text-zinc-400 uppercase mb-1">{{ __('Meter Ref') }}</p>
                            <p class="text-sm font-bold text-zinc-900">{{ $invoice->reading?->meter?->meter_reference ?? '—' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-100">
                            <p class="text-[9px] font-bold text-zinc-400 uppercase mb-1">{{ __('Consumption') }}</p>
                            <p class="text-sm font-bold text-zinc-900">{{ number_format($invoice->reading?->consumption ?? 0, 2) }} m³</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Financials -->
            <div class="bg-zinc-50 rounded-[32px] p-8 space-y-6">
                <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">{{ __('Payment Summary') }}</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-zinc-600">
                        <span class="text-sm">{{ __('Total Amount') }}</span>
                        <span class="font-bold">{{ number_format($invoice->total_amount, 2) }} DH</span>
                    </div>
                    <div class="flex justify-between items-center text-zinc-600">
                        <span class="text-sm">{{ __('Amount Paid') }}</span>
                        <span class="font-bold text-emerald-600">- {{ number_format($invoice->total_amount - $invoice->remaining_amount, 2) }} DH</span>
                    </div>
                    <div class="h-px bg-zinc-200 my-4"></div>
                    <div class="flex justify-between items-center">
                        <span class="font-syne font-bold text-zinc-900">{{ __('Remaining Balance') }}</span>
                        <span class="text-2xl font-syne font-bold text-rose-500">{{ number_format($invoice->remaining_amount, 2) }} DH</span>
                    </div>
                </div>
                
                @if($invoice->status !== 'paid')
                <div class="pt-6">
                    <p class="text-[10px] text-zinc-400 italic text-center">{{ __('Please settle the remaining balance by the end of the month.') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
