@php $active = 'payments'; @endphp
@extends('layouts.app')

@section('title', __('Payment Receipt'))
@section('header', __('Transaction Details'))

@section('content')
<div class="max-w-3xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <!-- Top Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('payments') }}" class="flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            {{ __('Back to Payments') }}
        </a>
        <button class="btn-primary bg-zinc-900 hover:bg-zinc-800 shadow-none">
            <i data-lucide="download" class="w-4 h-4"></i>
            {{ __('Download PDF') }}
        </button>
    </div>

    <!-- Receipt Card -->
    <div class="premium-card overflow-hidden">
        <!-- Success Header -->
        <div class="p-12 bg-emerald-600 flex flex-col items-center text-center text-white relative overflow-hidden">
            <div class="absolute -top-12 -left-12 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
            
            <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center mb-6 border border-white/20 backdrop-blur-sm">
                <i data-lucide="check" class="w-10 h-10 text-white"></i>
            </div>
            <h2 class="text-3xl font-syne font-bold">{{ __('Payment Confirmed') }}</h2>
            <p class="text-emerald-100 mt-2">{{ __('Transaction completed successfully on') }} {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</p>
            <div class="mt-8 px-6 py-2 rounded-full bg-white/10 border border-white/10 text-sm font-bold tracking-widest uppercase">
                {{ __('Receipt') }} #TRX-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
            </div>
        </div>

        <!-- Receipt Body -->
        <div class="p-12 space-y-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Transaction Info -->
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">{{ __('Billing Details') }}</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-center">
                                <i data-lucide="file-text" class="w-5 h-5 text-zinc-400"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-zinc-900">{{ __('Invoice') }} #{{ $payment->invoice?->id ?? '—' }}</p>
                                <p class="text-xs text-zinc-500">{{ $payment->invoice?->invoice_reference }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">{{ __('Collected By') }}</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-center">
                                <i data-lucide="user" class="w-5 h-5 text-zinc-400"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-zinc-900">{{ $payment->collector?->name ?? 'System' }}</p>
                                <p class="text-xs text-zinc-500">{{ __('Official Agent') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Summary -->
                <div class="bg-zinc-50 rounded-3xl p-8 space-y-4">
                    <div class="flex justify-between items-center text-zinc-600">
                        <span class="text-sm">{{ __('Payment Method') }}</span>
                        <span class="text-sm font-bold text-zinc-900">{{ __('Cash / Manual') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-zinc-600">
                        <span class="text-sm">{{ __('Status') }}</span>
                        <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">{{ __('Successful') }}</span>
                    </div>
                    <div class="h-px bg-zinc-200 my-4"></div>
                    <div class="flex justify-between items-center">
                        <span class="font-syne font-bold text-zinc-900">{{ __('Amount Paid') }}</span>
                        <span class="text-2xl font-syne font-bold text-emerald-600">{{ number_format($payment->amount_paid, 2) }} DH</span>
                    </div>
                </div>
            </div>

            <!-- Note Footer -->
            <div class="text-center pt-8 border-t border-zinc-100">
                <p class="text-[11px] text-zinc-400 max-w-sm mx-auto leading-relaxed">
                    {{ __('This is an automated system generated receipt. For any discrepancies, please contact Ayt Daoud Association support.') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
