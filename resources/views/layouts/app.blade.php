<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MeterPro') }} - @yield('title', 'Water Management')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CDN (Fallback/Immediate Styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10b981',
                        'primary-hover': '#059669',
                        surface: '#fafafa',
                        border: '#e4e4e7',
                        'text-main': '#09090b',
                        // Original palette for compatibility
                        deep: '#005461',
                        teal: '#0C7779',
                        mid: '#249E94',
                        light: '#3BC1A8',
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                        syne: ['Syne', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style type="text/tailwindcss">
        @layer components {
            .premium-card {
                @apply bg-white border border-zinc-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300;
            }
            .btn-primary {
                @apply bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-sm shadow-emerald-200/50 cursor-pointer;
            }
            .input-field {
                @apply w-full bg-white border border-zinc-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 text-zinc-900 placeholder-zinc-400;
            }
            .sidebar-link {
                @apply flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200;
            }
            .sidebar-link-active {
                @apply bg-white/10 text-white font-medium shadow-sm;
            }
            .sidebar-link-inactive {
                @apply text-zinc-400 hover:text-white hover:bg-white/5;
            }
        }
        
        [dir="rtl"] .font-syne, [dir="rtl"] .font-sans {
            font-family: 'Syne', 'Instrument Sans', sans-serif !important;
        }

        [dir="rtl"] .ml-auto {
            margin-left: 0;
            margin-right: auto;
        }

        [dir="rtl"] .mr-2 {
            margin-right: 0;
            margin-left: 0.5rem;
        }
    </style>

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-zinc-50 text-zinc-900 transition-all duration-300">
    @php $isRtl = app()->getLocale() === 'ar'; @endphp
    <div class="min-h-screen flex relative">
        <!-- Sidebar -->
        @include('components.side-bar', ['active' => $active ?? ''])

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 {{ $isRtl ? 'lg:pr-64' : 'lg:pl-64' }}">
            <!-- Topbar -->
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-zinc-200 px-4 sm:px-6 py-4">
                <div class="flex items-center justify-between gap-4">
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl hover:bg-zinc-100 transition-colors">
                        <i data-lucide="menu" class="w-5 h-5 text-zinc-600"></i>
                    </button>

                    <!-- Page Info -->
                    <div class="flex-1 min-w-0">
                        <h1 class="font-syne font-bold text-zinc-900 text-lg tracking-tight truncate">
                            @yield('header', __('Dashboard'))
                        </h1>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-3">
                        <!-- Language Switcher -->
                        <div class="relative group {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                            <button class="flex items-center gap-2 bg-zinc-100 border border-zinc-200 rounded-xl px-3 py-1.5 text-xs font-bold text-zinc-600 hover:bg-zinc-200 transition-colors">
                                <i data-lucide="languages" class="w-4 h-4"></i>
                                <span class="uppercase">{{ app()->getLocale() }}</span>
                            </button>
                            <div class="absolute {{ $isRtl ? 'left-0' : 'right-0' }} top-full mt-2 w-32 bg-white border border-zinc-200 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 overflow-hidden">
                                <a href="{{ route('lang.switch', 'ar') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-zinc-600 hover:bg-zinc-50 hover:text-emerald-600 transition-colors">
                                    <span class="w-5 text-center">🇲🇦</span> {{ __('Arabic') }}
                                </a>
                                <a href="{{ route('lang.switch', 'fr') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-zinc-600 hover:bg-zinc-50 hover:text-emerald-600 transition-colors border-t border-zinc-100">
                                    <span class="w-5 text-center">🇫🇷</span> {{ __('French') }}
                                </a>
                                <a href="{{ route('lang.switch', 'en') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-zinc-600 hover:bg-zinc-50 hover:text-emerald-600 transition-colors border-t border-zinc-100">
                                    <span class="w-5 text-center">🇺🇸</span> {{ __('English') }}
                                </a>
                            </div>
                        </div>

                        <button class="hidden md:flex items-center gap-2 bg-zinc-100 border border-zinc-200 rounded-xl px-3 py-1.5 text-sm text-zinc-500 hover:bg-zinc-200 transition-colors">
                            <i data-lucide="search" class="w-4 h-4"></i>
                            <span>{{ __('Search...') }}</span>
                            <span class="text-[10px] bg-white border border-zinc-200 rounded px-1 {{ $isRtl ? 'mr-2' : 'ml-2' }}">⌘K</span>
                        </button>

                        <button class="relative p-2 rounded-xl hover:bg-zinc-100 transition-colors group">
                            <i data-lucide="bell" class="w-5 h-5 text-zinc-500 group-hover:text-zinc-900 transition-colors"></i>
                            <span class="absolute top-2 {{ $isRtl ? 'left-2' : 'right-2' }} w-2 h-2 rounded-full bg-emerald-500 border-2 border-white"></span>
                        </button>

                        <div class="h-8 w-px bg-zinc-200 mx-1 hidden sm:block"></div>

                        <!-- User Profile -->
                        <div class="flex items-center gap-3 {{ $isRtl ? 'pr-1' : 'pl-1' }}">
                            <div class="hidden sm:block {{ $isRtl ? 'text-left' : 'text-right' }}">
                                <p class="text-sm font-semibold text-zinc-900 leading-none">{{ auth()->user()->name }}</p>
                                <p class="text-[11px] text-zinc-500 mt-1 capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-bold shadow-sm shadow-emerald-200">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="px-6 py-4 border-t border-zinc-200 text-xs text-zinc-400 text-center">
                &copy; {{ date('Y') }} {{ __('Official Water Management System') }}.
            </footer>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const isRtl = document.documentElement.dir === 'rtl';
            
            if (isRtl) {
                sidebar.classList.toggle('translate-x-full');
            } else {
                sidebar.classList.toggle('-translate-x-full');
            }
            overlay.classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>
