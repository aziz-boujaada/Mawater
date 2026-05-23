@php
    $active = 'users';
    $isRtl = app()->getLocale() === 'ar';
@endphp
@extends('layouts.app')

@section('title', __('Users'))
@section('header', __('User Management'))

@section('content')
<div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-zinc-900 font-bold text-xl tracking-tight">{{ __('Access Control') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Manage system users, roles, and permissions.') }}</p>
        </div>
        <a href="{{ route('register') }}" class="btn-primary w-full sm:w-auto">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            {{ __('Add New User') }}
        </a>
    </div>

    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/50">
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h3 class="font-syne font-bold text-zinc-900 text-sm">{{ __('Active Directory') }}</h3>
                </div>

                <x-listing-filters
                    :action="route('users')"
                    :clear-url="route('users')"
                    :search-placeholder="__('Search users, email, or phone...')"
                    :filters="[
                        ['type' => 'select', 'name' => 'role', 'label' => __('Role'), 'span' => 2, 'options' => [
                            '' => __('All Roles'),
                            'admin' => __('Admin'),
                            'collector' => __('Collector'),
                            'repair_agent' => __('Repair Agent'),
                            'villager' => __('Villager'),
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
                    ]"
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full {{ $isRtl ? 'text-right' : 'text-left' }}">
                <thead class="bg-zinc-50/50 text-zinc-400 uppercase text-[10px] font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4">{{ __('User') }}</th>
                        <th class="px-6 py-4">{{ __('Contact') }}</th>
                        <th class="px-6 py-4">{{ __('Role') }}</th>
                        <th class="px-6 py-4 {{ $isRtl ? 'text-left' : 'text-right' }}">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($users as $user)
                    <tr class="group hover:bg-zinc-50 transition-all duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-bold shadow-sm shadow-emerald-200">
                                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-zinc-900">{{ $user->name }}</p>
                                    <p class="text-[10px] font-mono text-zinc-400 mt-0.5">ID: #{{ $user->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-1.5 text-xs text-zinc-600">
                                    <i data-lucide="mail" class="w-3 h-3 text-zinc-400"></i>
                                    {{ $user->email }}
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-zinc-600">
                                    <i data-lucide="phone" class="w-3 h-3 text-zinc-400"></i>
                                    {{ $user->phone ?? __('No phone') }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $roleClasses = match($user->role) {
                                    'admin' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'collector' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'repair_agent' => 'bg-purple-50 text-purple-600 border-purple-100',
                                    default => 'bg-amber-50 text-amber-600 border-amber-100'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $roleClasses }} uppercase tracking-wider">
                                {{ str_replace('_', ' ', $user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 {{ $isRtl ? 'text-left' : 'text-right' }}">
                            <div class="flex items-center {{ $isRtl ? 'justify-start' : 'justify-end' }} gap-2">
                                <a href="{{ route('user.show', $user->id) }}" class="p-2 rounded-lg text-zinc-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all" title="{{ __('View Profile') }}">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('user.edit', $user->id) }}" class="p-2 rounded-lg text-zinc-400 hover:text-blue-600 hover:bg-blue-50 transition-all" title="{{ __('Edit User') }}">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <i data-lucide="users-2" class="w-12 h-12 text-zinc-200 mx-auto mb-4"></i>
                            <h4 class="text-zinc-900 font-bold">{{ __('No users found') }}</h4>
                            <p class="text-zinc-500 text-xs mt-1">{{ __('Wait for new registrations or add users manually.') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="px-6 py-4 bg-zinc-50/50 border-t border-zinc-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
