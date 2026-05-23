@php $active = 'dashboard'; @endphp
@extends('layouts.app')

@section('title', __('Dashboard'))
@section('header', __('Dashboard Overview'))

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center">
                    <i data-lucide="users" class="text-emerald-600 w-6 h-6"></i>
                </div>
                    <span class="flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">
                    <i data-lucide="trending-up" class="w-3 h-3"></i>
                    +12%
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Total Users') }}</h3>
                <p class="text-3xl font-syne font-bold text-zinc-900 mt-1">{{ $total_users }}</p>
            </div>
        </div>

        <!-- Total Budget -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center">
                    <i data-lucide="wallet" class="text-blue-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">
                    {{ __('Paid') }} {{ number_format($paidPercentage, 1) }}%
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Total Budget') }}</h3>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-syne font-bold text-zinc-900 mt-1">{{ number_format($total_budget, 0) }}</p>
                    <span class="text-sm font-bold text-zinc-400">DH</span>
                </div>
                <div class="mt-3 flex flex-col gap-1.5">
                    <div class="flex justify-between text-[10px] font-bold uppercase tracking-wider">
                        <span class="text-emerald-600">{{ __('Paid:') }} {{ number_format($total_paid, 0) }} DH</span>
                        <span class="text-rose-500">{{ __('Unpaid:') }} {{ number_format($unpaid_payment, 0) }} DH</span>
                    </div>
                    <div class="h-1.5 w-full bg-zinc-100 rounded-full overflow-hidden flex">
                        <div class="bg-emerald-500 h-full" style="width: {{ $paidPercentage }}%"></div>
                        <div class="bg-rose-400 h-full" style="width: {{ 100 - $paidPercentage }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Repair Losses -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center">
                    <i data-lucide="alert-circle" class="text-rose-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-1 rounded-lg">
                    {{ __('Loss') }} {{ number_format($lossPercentage, 1) }}%
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Repair Losses') }}</h3>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-syne font-bold text-zinc-900 mt-1">{{ number_format($repairLoseAmount, 0) }}</p>
                    <span class="text-sm font-bold text-zinc-400">DH</span>
                </div>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center">
                    <i data-lucide="bar-chart-3" class="text-amber-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-lg">
                    {{ __('Margin') }} {{ number_format($profitMargin, 1) }}%
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Net Profit') }}</h3>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-syne font-bold text-emerald-600 mt-1">{{ number_format($netProfit, 0) }}</p>
                    <span class="text-sm font-bold text-emerald-600/50">DH</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics & Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Chart Card -->
        <div class="lg:col-span-2 premium-card overflow-hidden">
            <div class="p-6 border-b border-zinc-100 flex items-center justify-between bg-zinc-50/50">
                <div>
                    <h2 class="font-syne font-bold text-zinc-900">{{ __('Revenue Analytics') }}</h2>
                    <p class="text-xs text-zinc-500">{{ __('Monthly payment collection performance') }}</p>
                </div>
                <div class="flex gap-2">
                    <button class="p-2 rounded-lg hover:bg-white border border-transparent hover:border-zinc-200 transition-all">
                        <i data-lucide="download" class="w-4 h-4 text-zinc-500"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <canvas id="paymentsChart" height="280"></canvas>
            </div>
        </div>

        <!-- Meter Status Card -->
        <div class="premium-card flex flex-col">
            <div class="p-6 border-b border-zinc-100 bg-zinc-50/50">
                <h2 class="font-syne font-bold text-zinc-900">{{ __('Meter Status') }}</h2>
                <p class="text-xs text-zinc-500">{{ __('Current infrastructure health') }}</p>
            </div>
            <div class="p-6 flex-1 space-y-6">
                <!-- Active -->
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                        <i data-lucide="check-circle" class="text-emerald-600 w-5 h-5"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-semibold text-zinc-700">{{ __('Active Meters') }}</span>
                            <span class="text-sm font-bold text-zinc-900">{{ $activ_meters }}</span>
                        </div>
                        <div class="h-1.5 w-full bg-zinc-100 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full" style="width: 85%"></div>
                        </div>
                    </div>
                </div>

                <!-- Broken -->
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center shrink-0">
                        <i data-lucide="alert-triangle" class="text-rose-600 w-5 h-5"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-semibold text-zinc-700">{{ __('Broken') }} / {{ __('Out of Service') }}</span>
                            <span class="text-sm font-bold text-zinc-900">{{ $broken_and_outService_meters }}</span>
                        </div>
                        <div class="h-1.5 w-full bg-zinc-100 rounded-full overflow-hidden">
                            <div class="bg-rose-500 h-full" style="width: 15%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-zinc-100">
                    <h3 class="text-xs font-bold text-zinc-400 uppercase tracking-widest mb-4">{{ __('Villager Enrollment') }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-100">
                            <p class="text-[10px] font-bold text-zinc-400 uppercase mb-1">{{ __('Subscribed') }}</p>
                            <p class="text-xl font-syne font-bold text-emerald-600">{{ $subscriberd_villagers }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-100">
                            <p class="text-[10px] font-bold text-zinc-400 uppercase mb-1">{{ __('Unsubscribed') }}</p>
                            <p class="text-xl font-syne font-bold text-rose-500">{{ $unsubscriberd_villagers }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Breakdown Table -->
    <div class="premium-card overflow-hidden">
        <div class="p-6 border-b border-zinc-100 flex items-center justify-between bg-zinc-50/50">
            <div>
                <h2 class="font-syne font-bold text-zinc-900">{{ __('Monthly Breakdown') }}</h2>
                <p class="text-xs text-zinc-500">{{ __('Detailed revenue history') }}</p>
            </div>
            <a href="#" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 transition-colors">
                {{ __('View All') }} <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-zinc-50/50 text-zinc-400 uppercase text-[10px] font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4">{{ __('Month') }}</th>
                        <th class="px-6 py-4">{{ __('Status') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Collection') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach($monthlyPayments as $monthPayment)
                    <tr class="group hover:bg-zinc-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white border border-zinc-200 flex items-center justify-center text-zinc-400 group-hover:border-emerald-200 group-hover:text-emerald-500 transition-all">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                </div>
                                <span class="text-sm font-semibold text-zinc-700">{{ $monthPayment->month }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ __('Collected') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-bold text-zinc-900">{{ number_format($monthPayment->total, 2) }} DH</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('paymentsChart');
        const chartData = @json($monthlyPayments);
        
        const labels = chartData.map(i => i.month);
        const data = chartData.map(i => Number(i.total));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: '{{ __('Revenue (DH)') }}',
                    data,
                    backgroundColor: '#10b981', // emerald-500
                    borderRadius: 8,
                    hoverBackgroundColor: '#059669', // emerald-600
                    barThickness: 32,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#18181b',
                        padding: 12,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        cornerRadius: 12,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f4f4f5' },
                        border: { display: false },
                        ticks: { font: { size: 11 }, color: '#a1a1aa' }
                    },
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: { font: { size: 11 }, color: '#a1a1aa' }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection



