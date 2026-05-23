@php
    $active = 'invoices';
    $isRtl = app()->getLocale() === 'ar';
@endphp
@extends('layouts.app')

@section('title', __('Invoices'))
@section('header', __('Billing & Invoices'))

@section('content')
<div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-zinc-900 font-bold text-xl tracking-tight">{{ __('Revenue Records') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Manage billing periods and village invoices.') }}</p>
        </div>
          @if (Auth::user()->role == 'admin' || Auth::user()->role == 'collector')
        <a href="{{ route('invoices.create') }}" class="btn-primary w-full sm:w-auto">
            <i data-lucide="plus" class="w-4 h-4"></i>
            {{ __('New Invoice') }}
        </a>
        @endif
    </div>

    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/50">
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h3 class="font-syne font-bold text-zinc-900 text-sm">{{ __('Invoice List') }}</h3>
                </div>

                <x-listing-filters
                    :action="route('invoices')"
                    :clear-url="route('invoices')"
                    :search-placeholder="__('Search invoices by reference or villager...')"
                    :filters="[
                        ['type' => 'select', 'name' => 'status', 'label' => __('Status'), 'span' => 2, 'options' => [
                            '' => __('All Statuses'),
                            'paid' => __('Paid'),
                            'partially_paid' => __('Partial'),
                            'unpaid' => __('Unpaid'),
                            'cancelled' => __('Cancelled'),
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
                    ]"
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full {{ $isRtl ? 'text-right' : 'text-left' }}">
                <thead class="bg-zinc-50/50 text-zinc-400 uppercase text-[10px] font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4">{{ __('Reference') }}</th>
                        <th class="px-6 py-4">{{ __('Villager') }}</th>
                        <th class="px-6 py-4">{{ __('Amount') }}</th>
                        <th class="px-6 py-4">{{ __('Status') }}</th>
                        <th class="px-6 py-4">{{ __('Period') }}</th>
                        <th class="px-6 py-4 {{ $isRtl ? 'text-left' : 'text-right' }}">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($invoices as $invoice)
                    <tr class="group hover:bg-zinc-50 transition-all duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white border border-zinc-200 flex items-center justify-center text-zinc-400 group-hover:border-emerald-200 group-hover:text-emerald-500 transition-all">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-zinc-900">{{ $invoice->invoice_reference }}</p>
                                    <p class="text-[10px] font-mono text-zinc-400 mt-0.5 uppercase tracking-tighter">#{{ $invoice->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center text-[10px] font-bold text-emerald-600">
                                    {{ strtoupper(substr($invoice->reading?->meter?->villager?->user?->name ?? 'U', 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-zinc-700">{{ $invoice->reading?->meter?->villager?->user?->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-bold text-zinc-900">{{ number_format($invoice->total_amount, 2) }} DH</p>
                                @if($invoice->remaining_amount > 0)
                                <p class="text-[10px] font-bold text-rose-500 mt-0.5">{{ __('Due:') }} {{ number_format($invoice->remaining_amount, 2) }} DH</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusClasses = match($invoice->status) {
                                    'paid' => 'bg-emerald-50 text-emerald-600',
                                    'partially_paid' => 'bg-amber-50 text-amber-600',
                                    default => 'bg-rose-50 text-rose-600'
                                };
                                $statusLabel = match($invoice->status) {
                                    'paid' => __('Paid'),
                                    'partially_paid' => __('Partial'),
                                    'cancelled' => __('Cancelled'),
                                    default => __('Unpaid')
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold {{ $statusClasses }} uppercase tracking-wider">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-zinc-500">
                            {{ $invoice->billing_period }}
                        </td>
                        <td class="px-6 py-4 {{ $isRtl ? 'text-left' : 'text-right' }}">
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="p-2 rounded-lg text-zinc-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all inline-block" title="{{ __('View Invoice') }}">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <i data-lucide="file-x" class="w-12 h-12 text-zinc-200 mx-auto mb-4"></i>
                            <h4 class="text-zinc-900 font-bold">{{ __('No invoices found') }}</h4>
                            <p class="text-zinc-500 text-xs mt-1">{{ __('Start by generating invoices from meter readings.') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($invoices->hasPages())
        <div class="px-6 py-4 bg-zinc-50/50 border-t border-zinc-100">
            {{ $invoices->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
