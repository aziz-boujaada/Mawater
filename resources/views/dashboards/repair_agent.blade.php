@php $active = 'dashboard'; @endphp
@extends('layouts.app')

@section('title', __('Repair Agent Dashboard'))
@section('header', __('Maintenance Overview'))

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <!-- Repairs -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center">
                    <i data-lucide="wrench" class="text-indigo-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg">{{ __('Repairs') }}</span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Total Repairs') }}</h3>
                <p class="text-3xl font-syne font-bold text-zinc-900 mt-1">{{ $repairsCount }}</p>
            </div>
        </div>

        <!-- Loss Cost -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="text-rose-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-1 rounded-lg">{{ __('Loss Cost') }}</span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Total Losses') }}</h3>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-syne font-bold text-zinc-900 mt-1">{{ number_format($repairsAmountLose, 0) }}</p>
                    <span class="text-sm font-bold text-zinc-400">DH</span>
                </div>
            </div>
        </div>

        <!-- Average Cost -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center">
                    <i data-lucide="bar-chart-2" class="text-blue-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">{{ __('Average') }}</span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Average Repair Cost') }}</h3>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-syne font-bold text-zinc-900 mt-1">{{ number_format($moyenCost, 0) }}</p>
                    <span class="text-sm font-bold text-zinc-400">DH</span>
                </div>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="premium-card p-6">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center">
                    <i data-lucide="check-circle" class="text-emerald-600 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">{{ __('Success') }}</span>
            </div>
            <div class="mt-4">
                <h3 class="text-zinc-500 text-sm font-medium">{{ __('Completion Rate') }}</h3>
                <p class="text-3xl font-syne font-bold text-emerald-600 mt-1">{{ number_format($completionRate, 1) }}%</p>
                <div class="mt-2 h-1.5 w-full bg-zinc-100 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-full" style="width: {{ $completionRate }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Status Chart -->
        <div class="premium-card p-6 flex flex-col items-center justify-center text-center">
            <h3 class="font-syne font-bold text-zinc-900 mb-6 w-full text-left">{{ __('Status Distribution') }}</h3>
            <div class="relative w-48 h-48 mb-6">
                <canvas id="repairChart"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-4 w-full">
                <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-100">
                    <p class="text-[10px] font-bold text-emerald-600 uppercase">{{ __('Repaired') }}</p>
                    <p class="text-lg font-bold text-emerald-700">{{ $completedRepairs }}</p>
                </div>
                <div class="p-3 rounded-2xl bg-rose-50 border border-rose-100">
                    <p class="text-[10px] font-bold text-rose-600 uppercase">{{ __('In Progress') }}</p>
                    <p class="text-lg font-bold text-rose-700">{{ $inProgressRepairs }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Activity / Placeholder -->
        <div class="lg:col-span-2 premium-card">
            <div class="p-6 border-b border-zinc-100 bg-zinc-50/50 flex justify-between items-center">
                <h3 class="font-syne font-bold text-zinc-900">{{ __('Recent Assignments') }}</h3>
                <a href="{{ route('repairs') }}" class="text-xs font-bold text-emerald-600 hover:underline">{{ __('View All') }}</a>
            </div>
            <div class="p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-zinc-50 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="clipboard-list" class="w-8 h-8 text-zinc-300"></i>
                </div>
                <h4 class="text-zinc-900 font-bold">{{ __('No active assignments') }}</h4>
                <p class="text-zinc-500 text-sm mt-1">{{ __("You're all caught up! New repair requests will appear here.") }}</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('repairChart');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['{{ __('Repaired') }}', '{{ __('In Progress') }}'],
                datasets: [{
                    data: [{{ $completedRepairs }}, {{ $inProgressRepairs }}],
                    backgroundColor: ['#10b981', '#f43f5e'],
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: { display: false }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endpush
@endsection
