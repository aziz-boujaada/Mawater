@php $active = 'users'; @endphp
@extends('layouts.app')

@section('title', __('User Profile'))
@section('header', __('System User'))

@section('content')
<div class="max-w-5xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <!-- Top Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('users') }}" class="flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            {{ __('Back to Directory') }}
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('user.edit', $user->id) }}" class="btn-primary">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                {{ __('Edit Profile') }}
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="premium-card p-8 flex flex-col items-center text-center">
                <div class="w-24 h-24 rounded-3xl bg-emerald-600 flex items-center justify-center text-white text-3xl font-bold shadow-2xl shadow-emerald-600/20 mb-6">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                </div>
                <h2 class="text-2xl font-syne font-bold text-zinc-900">{{ $user->name }}</h2>
                <p class="text-zinc-500 text-sm mt-1">{{ $user->email }}</p>
                
                <div class="mt-6 flex flex-wrap justify-center gap-2">
                    @php
                        $roleClasses = match($user->role) {
                            'admin' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            'collector' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'repair_agent' => 'bg-purple-50 text-purple-600 border-purple-100',
                            default => 'bg-amber-50 text-amber-600 border-amber-100'
                        };
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold border {{ $roleClasses }} uppercase tracking-widest">
                        {{ str_replace('_', ' ', $user->role) }}
                    </span>
                </div>

                <div class="w-full h-px bg-zinc-100 my-8"></div>

                <div class="w-full space-y-4 text-left">
                    <div>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">{{ __('Phone Number') }}</p>
                        <p class="text-sm font-bold text-zinc-900 flex items-center gap-2">
                            <i data-lucide="phone" class="w-4 h-4 text-zinc-400"></i>
                            {{ $user->phone ?? __('Not provided') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">{{ __('Joined Date') }}</p>
                        <p class="text-sm font-bold text-zinc-900 flex items-center gap-2">
                            <i data-lucide="calendar" class="w-4 h-4 text-zinc-400"></i>
                            {{ $user->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Specific Details -->
        <div class="lg:col-span-2 space-y-8">
            @if($user->role === 'villager' && $user->villager)
            <div class="premium-card p-8">
                <h3 class="font-syne font-bold text-lg text-zinc-900 mb-6">{{ __('Villager Information') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">{{ __('National ID (CIN)') }}</p>
                        <p class="text-sm font-bold text-zinc-900">{{ $user->villager->cin ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">{{ __('Subscription Status') }}</p>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ $user->villager->subscription_status === 'subscribed' ? 'text-emerald-600' : 'text-rose-500' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $user->villager->subscription_status === 'subscribed' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                            {{ ucfirst(str_replace('_', ' ', $user->villager->subscription_status)) }}
                        </span>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">{{ __('Primary Address') }}</p>
                        <p class="text-sm font-bold text-zinc-900">{{ $user->villager->address ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <div class="premium-card overflow-hidden">
                <div class="p-6 border-b border-zinc-100 bg-zinc-50/50">
                    <h3 class="font-syne font-bold text-zinc-900">{{ __('Linked Meters') }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-zinc-50 text-[10px] font-bold text-zinc-400 uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4">{{ __('Reference') }}</th>
                                <th class="px-6 py-4">{{ __('Status') }}</th>
                                <th class="px-6 py-4">{{ __('Last Reading') }}</th>
                                <th class="px-6 py-4 text-right">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            @forelse($user->villager->meters as $meter)
                            <tr class="group hover:bg-zinc-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-zinc-100 flex items-center justify-center text-zinc-400 group-hover:text-emerald-600 transition-colors">
                                            <i data-lucide="gauge" class="w-4 h-4"></i>
                                        </div>
                                        <span class="text-sm font-bold text-zinc-900">{{ $meter->meter_reference }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $meter->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} uppercase">
                                        {{ $meter->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php $lastReading = $meter->meterReadings->sortByDesc('reading_date')->first(); @endphp
                                    @if($lastReading)
                                        <span class="text-sm font-medium text-zinc-700">{{ number_format($lastReading->current_reading, 2) }} m³</span>
                                        <p class="text-[10px] text-zinc-400">{{ \Carbon\Carbon::parse($lastReading->reading_date)->format('M d, Y') }}</p>
                                    @else
                                        <span class="text-xs text-zinc-400 italic">{{ __('No readings') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('meter.show', $meter->id) }}" class="p-2 rounded-lg text-zinc-400 hover:text-emerald-600 transition-colors">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <p class="text-zinc-500 text-sm italic">{{ __('No meters registered to this account yet.') }}</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="premium-card p-12 text-center">
                <div class="max-w-xs mx-auto">
                    <i data-lucide="shield-check" class="w-16 h-16 text-emerald-100 mx-auto mb-6"></i>
                    <h3 class="text-xl font-syne font-bold text-zinc-900 mb-2">{{ __('Staff Account') }}</h3>
                    <p class="text-zinc-500 text-sm">{{ __('This user has administrative access level permissions and can perform system operations based on their role.') }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
