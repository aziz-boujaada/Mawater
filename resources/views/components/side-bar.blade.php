<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        deep: '#005461',
                        teal: '#0C7779',
                        mid: '#249E94',
                        light: '#3BC1A8',
                    },
                    fontFamily: {
                        syne: ['Syne', 'sans-serif'],
                        dm: ['DM Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>
{{--
    SIDEBAR COMPONENT
    Usage: @include('components.sidebar', ['active' => 'dashboard'])
    Active options: dashboard | meters | villagers | reports | readings | invoices | settings
--}}

<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-56 bg-deep flex flex-col py-5 transition-transform duration-300"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 mb-6 shrink-0">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-mid to-light flex items-center justify-center shadow-lg shadow-light/25 shrink-0">
            <i class="fa-solid fa-gauge text-white text-sm"></i>
        </div>
        <span class="font-syne font-bold text-white text-base tracking-tight">MeterPro</span>
    </div>

    <div class="mx-5 h-px bg-white/10 mb-4 shrink-0"></div>

    {{-- Nav --}}
    <nav class="flex-1 flex flex-col gap-0.5 px-3 overflow-y-auto">

        @php
        $dashboardRoute = auth()->user()->role === 'admin'
        ? 'dashboard.admin'
        : 'dashboard.collector';

        $links = [
        ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'fa-table-cells-large', 'route' => $dashboardRoute],
        ['key' => 'users', 'label' => 'users', 'icon' => 'fa-users', 'route' => 'users'],
        ['key' => 'meters', 'label' => 'Meters', 'icon' => 'fa-gauge', 'route' => 'meters'],
        ['key' => 'readings', 'label' => 'Readings', 'icon' => 'fa-wave-square', 'route' => 'readings'],
        ['key' => 'invoices', 'label' => 'Invoices', 'icon' => 'fa-receipt', 'route' => 'invoices'],
        ['key' => 'payments', 'label' => 'payments', 'icon' => 'fa-receipt', 'route' => 'payments'],

        ];
        @endphp

        @foreach($links as $link)
        @php $isActive = ($active ?? '') === $link['key']; @endphp
        <a href="{{ route($link['route']) }}"
            class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors
                      {{ $isActive
                          ? 'bg-white/12 text-white font-medium'
                          : 'text-white/50 hover:text-white hover:bg-white/8' }}">
            @if($isActive)
            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-light rounded-r-full"></span>
            @endif
            <i class="fa-solid {{ $link['icon'] }} w-4 text-center shrink-0 {{ $isActive ? 'text-light' : '' }}"></i>
            {{ $link['label'] }}
        </a>
        @endforeach

    </nav>

    {{-- Footer: user + logout --}}
    <div class="mx-3 mt-4 shrink-0">
        <div class="h-px bg-white/10 mb-3"></div>
        <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-mid to-light flex items-center justify-center text-white text-xs font-bold shrink-0">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-white/40 text-[0.68rem] truncate">{{ auth()->user()->email ?? 'admin@meterpro.com' }}</p>
            </div>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="p-1.5 rounded-lg text-white/30 hover:text-red-400 hover:bg-white/8 transition-colors shrink-0"
                title="Logout">
                <i class="fa-solid fa-right-from-bracket text-sm"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </div>

</aside>

{{-- Mobile overlay --}}
<div id="sidebar-overlay"
    class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"
    onclick="toggleSidebar()"></div>

</html>