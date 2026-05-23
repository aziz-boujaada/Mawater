@php $active = 'users'; @endphp
@extends('layouts.app')

@section('title', __('Update Profile'))
@section('header', __('User Management'))

@section('content')
<div class="max-w-3xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="premium-card overflow-hidden">
        <div class="p-8 border-b border-zinc-100 bg-zinc-50/50">
            <div class="w-12 h-12 rounded-2xl bg-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-200 mb-6">
                <i data-lucide="user-cog" class="text-white w-6 h-6"></i>
            </div>
            <h2 class="text-2xl font-syne font-bold text-zinc-900">{{ __('Update User Profile') }}</h2>
            <p class="text-zinc-500 text-sm mt-1">{{ __('Modify account details and permissions for') }} {{ $user->name }}.</p>
        </div>

        <form action="{{ route('user.update', $user->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Full Name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="input-field" />
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Email Address') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="input-field" />
                </div>

                <!-- Phone -->
                <div class="space-y-2">
                    <label for="phone" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Phone Number') }}</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="input-field" />
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label for="role" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Account Role') }}</label>
                    <div class="relative group">
                        <select id="role" name="role" required class="input-field appearance-none cursor-pointer" onchange="toggleVillagerFields()">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                            <option value="repair_agent" {{ old('role', $user->role) == 'repair_agent' ? 'selected' : '' }}>{{ __('Repair Agent') }}</option>
                            <option value="collector" {{ old('role', $user->role) == 'collector' ? 'selected' : '' }}>{{ __('Collector') }}</option>
                            <option value="villager" {{ old('role', $user->role) == 'villager' ? 'selected' : '' }}>{{ __('Villager') }}</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-zinc-400 group-hover:text-emerald-500 transition-colors">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Villager Fields (Conditional) -->
            <div id="villagerFields" class="space-y-6 pt-6 border-t border-zinc-100 {{ old('role', $user->role) !== 'villager' ? 'hidden' : '' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="cin" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('National ID (CIN)') }}</label>
                        <input type="text" name="cin" id="cin" value="{{ old('cin', $user->villager?->cin) }}" class="input-field" />
                    </div>
                    <div class="space-y-2">
                        <label for="subscription_status" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Subscription') }}</label>
                        <div class="relative group">
                            <select name="subscription_status" id="subscription_status" class="input-field appearance-none cursor-pointer">
                                <option value="subscribed" {{ old('subscription_status', $user->villager?->subscription_status) == 'subscribed' ? 'selected' : '' }}>{{ __('Subscribed') }}</option>
                                <option value="not_subscribed" {{ old('subscription_status', $user->villager?->subscription_status) == 'not_subscribed' ? 'selected' : '' }}>{{ __('Not Subscribed') }}</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-zinc-400 group-hover:text-emerald-500 transition-colors">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="address" class="text-xs font-bold text-zinc-400 uppercase tracking-widest ml-1">{{ __('Primary Address') }}</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $user->villager?->address) }}" class="input-field" />
                </div>
            </div>

            @if ($errors->any())
            <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-rose-600 text-xs font-medium flex items-center gap-2">
                            <i data-lucide="alert-circle" class="w-3 h-3"></i>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="pt-4 border-t border-zinc-100 flex items-center justify-end gap-3">
                <a href="{{ route('users') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-zinc-500 hover:bg-zinc-100 transition-all">{{ __('Cancel') }}</a>
                <button type="submit" class="btn-primary px-8">
                    {{ __('Save Changes') }}
                    <i data-lucide="save" class="w-4 h-4"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleVillagerFields() {
        const role = document.getElementById("role").value;
        const fields = document.getElementById("villagerFields");
        const isVillager = role === "villager";

        if (isVillager) {
            fields.classList.remove("hidden");
        } else {
            fields.classList.add("hidden");
        }

        const villagerInputs = document.querySelectorAll('#villagerFields input, #villagerFields select');
        villagerInputs.forEach((el) => {
            el.disabled = !isVillager;
        });
    }
</script>
@endsection
