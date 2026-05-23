@php
    $role = auth()->user()->role;
    $dashboardRoute = match ($role) {
        'admin' => 'dashboard.admin',
        'collector' => 'dashboard.collector',
        'repair_agent' => 'dashboard.repair_agent',
        'villager' => 'dashboard.villager'
    };

    $allLinks = [
        'admin' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'route' => $dashboardRoute],
            ['key' => 'users', 'label' => 'Users', 'icon' => 'users', 'route' => 'users'],
            ['key' => 'meters', 'label' => 'Meters', 'icon' => 'gauge', 'route' => 'meters'],
            ['key' => 'readings', 'label' => 'Readings', 'icon' => 'activity', 'route' => 'readings'],
            ['key' => 'invoices', 'label' => 'Invoices', 'icon' => 'file-text', 'route' => 'invoices'],
            ['key' => 'payments', 'label' => 'Payments', 'icon' => 'credit-card', 'route' => 'payments'],
            ['key' => 'repairs', 'label' => 'Repairs', 'icon' => 'wrench', 'route' => 'repairs'],
        ],
        'repair_agent' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'route' => $dashboardRoute],
            ['key' => 'repairs', 'label' => 'Repairs', 'icon' => 'wrench', 'route' => 'repairs'],
        ],
        'collector' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'route' => $dashboardRoute],
            ['key' => 'readings', 'label' => 'Readings', 'icon' => 'activity', 'route' => 'readings'],
            ['key' => 'invoices', 'label' => 'Invoices', 'icon' => 'file-text', 'route' => 'invoices'],
            ['key' => 'payments', 'label' => 'Payments', 'icon' => 'credit-card', 'route' => 'payments'],
        ],
        'villager' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'route' => $dashboardRoute],
            ['key' => 'readings', 'label' => 'Readings', 'icon' => 'activity', 'route' => 'readings'],
            ['key' => 'invoices', 'label' => 'Invoices', 'icon' => 'file-text', 'route' => 'invoices'],
            ['key' => 'payments', 'label' => 'Payments', 'icon' => 'credit-card', 'route' => 'payments'],
        ],
    ];

    $links = $allLinks[$role] ?? [];
@endphp

<aside id="sidebar" class="fixed inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} z-40 w-64 bg-zinc-950 flex flex-col transition-transform duration-300 {{ app()->getLocale() === 'ar' ? 'translate-x-full lg:translate-x-0' : '-translate-x-full lg:translate-x-0' }} border-r border-white/5 shadow-2xl">
    <!-- Logo Section -->
    <div class="p-6 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
            <i data-lucide="droplets" class="text-white w-6 h-6"></i>
        </div>
        <div>
            <span class="font-syne font-bold text-white text-lg tracking-tight block leading-none">{{ __('Ait Daoud') }}</span>
            <span class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest mt-1 block">{{ __('Association Rural') }}</span>
        </div>
    </div>

    <!-- Navigation Section -->
    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        @foreach($links as $link)
            @php $isActive = ($active ?? '') === $link['key']; @endphp
            <a href="{{ route($link['route']) }}" 
               class="sidebar-link {{ $isActive ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
                <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5"></i>
                <span class="font-medium">{{ __($link['label']) }}</span>
                @if($isActive)
                    <div class="ml-auto w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></div>
                @endif
            </a>
        @endforeach
    </nav>

    <!-- Bottom Actions -->
    <div class="p-4 bg-zinc-900/50 border-t border-white/5 space-y-2">
        <div class="px-2 py-3 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="text-zinc-500 text-[10px] truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 transition-all duration-200">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span class="font-medium">{{ __('Sign Out') }}</span>
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>
