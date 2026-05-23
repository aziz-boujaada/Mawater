@php $active = 'dashboard'; @endphp
@extends('layouts.app')

@section('title', __('Villager Dashboard'))
@section('header', __('Your Water Usage'))

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- Readings -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center">
                    <i data-lucide="gauge" class="text-blue-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">{{ __('Readings') }}</span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Total Readings') }}</h3>
                <p class="text-3xl font-syne font-bold text-zinc-900 mt-1">{{ $readingsCount }}</p>
                <p class="text-xs text-zinc-400 mt-1">{{ __('Meter usage records') }}</p>
            </div>
        </div>

        <!-- Paid Status -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center">
                    <i data-lucide="check-circle" class="text-emerald-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">{{ __('Invoices') }}</span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Invoice History') }}</h3>
                <div class="flex items-center gap-4 mt-1">
                    <div>
                        <p class="text-2xl font-syne font-bold text-zinc-900">{{ $invoicesCount }}</p>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">{{ __('Total') }}</p>
                    </div>
                    <div class="w-px h-8 bg-zinc-100"></div>
                    <div>
                        <p class="text-2xl font-syne font-bold text-emerald-600">{{ $paidInvoicesCount }}</p>
                        <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">{{ __('Paid') }}</p>
                    </div>
                    <div class="w-px h-8 bg-zinc-100"></div>
                    <div>
                        <p class="text-2xl font-syne font-bold text-rose-500">{{ $unPaidInvoicesCount }}</p>
                        <p class="text-[10px] font-bold text-rose-400 uppercase tracking-wider">{{ __('Unpaid') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Summary -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center">
                    <i data-lucide="wallet" class="text-amber-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-lg">{{ __('Summary') }}</span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Balance Details') }}</h3>
                <div class="space-y-3 mt-2">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-medium text-zinc-500">{{ __('Total Paid') }}</span>
                        <span class="text-sm font-bold text-emerald-600">{{ number_format($totalAmountPaid, 2) }} DH</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-medium text-zinc-500">{{ __('Remaining') }}</span>
                        <span class="text-sm font-bold text-rose-500">{{ number_format($remainingAmount, 2) }} DH</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions / Next Steps -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="premium-card p-8 bg-emerald-600 relative overflow-hidden group">
            <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center mb-6">
                    <i data-lucide="credit-card" class="text-white w-6 h-6"></i>
                </div>
                <h3 class="text-2xl font-syne font-bold text-white mb-2">{{ __('Pay Your Invoice') }}</h3>
                <p class="text-emerald-100 text-sm mb-6 max-w-sm">{{ __('Securely pay your water bill online. We support multiple payment methods for your convenience.') }}</p>
                <a href="{{ route('payments') }}" class="inline-flex items-center gap-2 bg-white text-emerald-600 px-6 py-3 rounded-xl font-bold text-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                    {{ __('Pay Now') }}
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        <div class="premium-card p-8 bg-zinc-900 relative overflow-hidden group">
            <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center mb-6">
                    <i data-lucide="history" class="text-white w-6 h-6"></i>
                </div>
                <h3 class="text-2xl font-syne font-bold text-white mb-2">{{ __('View History') }}</h3>
                <p class="text-zinc-400 text-sm mb-6 max-w-sm">{{ __('Track your water consumption over time and view your past meter readings and payments.') }}</p>
                <a href="{{ route('readings') }}" class="inline-flex items-center gap-2 bg-white/5 text-white border border-white/10 px-6 py-3 rounded-xl font-bold text-sm hover:bg-white/10 hover:-translate-y-0.5 transition-all duration-200">
                    {{ __('See History') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
