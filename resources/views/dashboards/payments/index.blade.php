@php
    $active = 'payments';
    $isRtl = app()->getLocale() === 'ar';
@endphp
@extends('layouts.app')

@section('title', __('Payments'))
@section('header', __('Payment Transactions'))

@section('content')
<div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-zinc-900 font-bold text-xl tracking-tight">{{ __('Collection History') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Review all financial transactions and payment receipts.') }}</p>
        </div>
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'collector')
        
        <a href="{{ route('payments.create') }}" class="btn-primary w-full sm:w-auto">
            <i data-lucide="plus" class="w-4 h-4"></i>
            {{ __('New Payment') }}
        </a>
        @endif
    </div>

    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/50">
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h3 class="font-syne font-bold text-zinc-900 text-sm">{{ __('Transaction Logs') }}</h3>
                </div>

                <x-listing-filters
                    :action="route('payments')"
                    :clear-url="route('payments')"
                    :search-placeholder="__('Search payments by invoice, collector, or villager...')"
                    :filters="[
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
                    ]"
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full {{ $isRtl ? 'text-right' : 'text-left' }}">
                <thead class="bg-zinc-50/50 text-zinc-400 uppercase text-[10px] font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4">{{ __('ID') }}</th>
                        <th class="px-6 py-4">{{ __('Invoice') }}</th>
                        <th class="px-6 py-4">{{ __('Collector') }}</th>
                        <th class="px-6 py-4 {{ $isRtl ? 'text-left' : 'text-right' }}">{{ __('Amount Paid') }}</th>
                        <th class="px-6 py-4">{{ __('Date') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($payments as $payment)
                    <tr class="group hover:bg-zinc-50 transition-all duration-200">
                        <td class="px-6 py-4 font-mono text-[11px] text-zinc-400">#{{ $payment->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-zinc-900">{{ __('Inv') }} #{{ $payment->invoice?->id ?? '—' }}</span>
                                <span class="text-[10px] text-zinc-400">({{ number_format($payment->invoice?->total_amount ?? 0, 2) }} DH)</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-blue-50 flex items-center justify-center text-[10px] font-bold text-blue-600 border border-blue-100">
                                    {{ strtoupper(substr($payment->collector?->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-zinc-700">{{ $payment->collector?->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-bold">
                                <i data-lucide="check" class="w-3 h-3"></i>
                                {{ number_format($payment->amount_paid, 2) }} DH
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-zinc-500">
                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 {{ $isRtl ? 'text-left' : 'text-right' }}">
                            <a href="{{ route('payments.show', $payment->id) }}" class="p-2 rounded-lg text-zinc-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all inline-block" title="{{ __('View Details') }}">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <i data-lucide="banknote" class="w-12 h-12 text-zinc-200 mx-auto mb-4"></i>
                            <h4 class="text-zinc-900 font-bold">{{ __('No payments recorded') }}</h4>
                            <p class="text-zinc-500 text-xs mt-1">{{ __('Transaction history will appear here once payments are collected.') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($payments->hasPages())
        <div class="px-6 py-4 bg-zinc-50/50 border-t border-zinc-100">
            {{ $payments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
