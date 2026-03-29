<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        deep:  '#005461',
                        teal:  '#0C7779',
                        mid:   '#249E94',
                        light: '#3BC1A8',
                    },
                    fontFamily: {
                        syne: ['Syne', 'sans-serif'],
                        dm:   ['DM Sans', 'sans-serif'],
                    },
                    keyframes: {
                        fadeIn: {
                            '0%':   { opacity: '0', transform: 'translateY(12px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    },
                    animation: {
                        fadeIn: 'fadeIn 0.4s ease both',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body class="font-dm bg-gray-50 text-gray-800">

{{-- ════════════════════════════════
     LAYOUT WRAPPER
════════════════════════════════ --}}
<div class="flex min-h-screen">

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Preview</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        deep:  '#005461',
                        teal:  '#0C7779',
                        mid:   '#249E94',
                        light: '#3BC1A8',
                    },
                    fontFamily: { dm: ['DM Sans', 'sans-serif'] },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Active left bar */
        .nav-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: #3BC1A8;
            border-radius: 0 3px 3px 0;
        }
    </style>
</head>
<body class="font-dm bg-gray-100 flex">

  @include('components.side-bar')

    {{-- ───────────── MAIN CONTENT ───────────── --}}
    <div class="flex-1 flex flex-col lg:ml-64 min-w-0">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-6 py-4 flex items-center gap-4">

            {{-- Hamburger (mobile) --}}
            <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>

            {{-- Page title --}}
            <div class="flex-1 min-w-0">
                <h1 class="font-syne font-bold text-deep text-lg tracking-tight truncate">Dashboard</h1>
                <p class="text-xs text-gray-400 hidden sm:block">Welcome back, Admin 👋</p>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2 shrink-0">
                {{-- Search --}}
                <div class="hidden md:flex items-center gap-2 bg-gray-100 rounded-xl px-3 py-2 text-sm text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <span>Search…</span>
                </div>

                {{-- Notification bell --}}
                <button class="relative p-2 rounded-xl hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-light border-2 border-white"></span>
                </button>

                {{-- New meter CTA --}}
                <a href="{{ route('meter.create') ?? '#' }}"
                   class="flex items-center gap-2 bg-deep text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-teal transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    <span class="hidden sm:inline">New Meter</span>
                </a>
            </div>
        </header>

        {{-- PAGE BODY --}}
        <main class="flex-1 p-6 space-y-6 animate-fadeIn">

            {{-- ── STAT CARDS ── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                {{-- Card 1 --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-deep/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-deep" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-0.5 rounded-full">+12%</span>
                    </div>
                    <p class="text-2xl font-syne font-bold text-deep">248</p>
                    <p class="text-xs text-gray-400 mt-0.5">Total Meters</p>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-light/15 flex items-center justify-center">
                            <svg class="w-5 h-5 text-mid" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-0.5 rounded-full">+5%</span>
                    </div>
                    <p class="text-2xl font-syne font-bold text-deep">193</p>
                    <p class="text-xs text-gray-400 mt-0.5">Active Meters</p>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        </div>
                        <span class="text-xs font-semibold text-red-400 bg-red-50 px-2 py-0.5 rounded-full">-3%</span>
                    </div>
                    <p class="text-2xl font-syne font-bold text-deep">31</p>
                    <p class="text-xs text-gray-400 mt-0.5">Broken / Out of Service</p>
                </div>

                {{-- Card 4 --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-teal/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-teal" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        </div>
                        <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-0.5 rounded-full">+8%</span>
                    </div>
                    <p class="text-2xl font-syne font-bold text-deep">312</p>
                    <p class="text-xs text-gray-400 mt-0.5">Villagers</p>
                </div>
            </div>

            {{-- ── BOTTOM GRID: Table + Activity ── --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                {{-- Recent Meters Table --}}
                <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h3 class="font-syne font-bold text-deep text-sm">Recent Meters</h3>
                        <a href="#" class="text-xs text-mid font-semibold hover:underline">View all →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-[0.72rem] uppercase tracking-widest text-gray-400 font-semibold">
                                    <th class="px-6 py-3">Villager</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Installed</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($meters ?? [] as $meter)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-3.5 font-medium text-gray-700">{{ $meter->villager->name }}</td>
                                    <td class="px-6 py-3.5">
                                        @if($meter->status === 'active')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                                            </span>
                                        @elseif($meter->status === 'broken')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500 bg-red-50 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Broken
                                            </span>
                                        @elseif($meter->status === 'repaired')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-500 bg-blue-50 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> Repaired
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-500 bg-amber-50 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Out of Service
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-gray-400 text-xs">{{ $meter->installation_date }}</td>
                                    <td class="px-6 py-3.5 text-right">
                                        <a href="#" class="text-xs text-mid font-semibold hover:underline">View</a>
                                    </td>
                                </tr>
                                @empty
                                {{-- Placeholder rows when no data --}}
                                @foreach([
                                    ['Ali Bensalem','active','2024-01-15'],
                                    ['Fatima Zahra','broken','2023-11-02'],
                                    ['Omar Idrissi','repaired','2024-03-20'],
                                    ['Khadija Mouad','active','2024-05-08'],
                                    ['Youssef Alami','out_service','2023-09-14'],
                                ] as $row)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-3.5 font-medium text-gray-700">{{ $row[0] }}</td>
                                    <td class="px-6 py-3.5">
                                        @php $s = $row[1]; @endphp
                                        @if($s==='active')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Active</span>
                                        @elseif($s==='broken')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500 bg-red-50 px-2.5 py-1 rounded-full"><span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>Broken</span>
                                        @elseif($s==='repaired')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-500 bg-blue-50 px-2.5 py-1 rounded-full"><span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>Repaired</span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-500 bg-amber-50 px-2.5 py-1 rounded-full"><span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>Out of Service</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-gray-400 text-xs">{{ $row[2] }}</td>
                                    <td class="px-6 py-3.5 text-right"><a href="#" class="text-xs text-mid font-semibold hover:underline">View</a></td>
                                </tr>
                                @endforeach
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Activity Feed --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h3 class="font-syne font-bold text-deep text-sm">Recent Activity</h3>
                        <span class="w-2 h-2 rounded-full bg-light animate-pulse"></span>
                    </div>
                    <div class="px-6 py-4 space-y-5">

                        @foreach([
                            ['Meter #031 repaired','2 min ago','mid','M'],
                            ['New meter added for Ali Bensalem','18 min ago','light','N'],
                            ['Meter #019 marked broken','1 hr ago','red-400','!'],
                            ['Villager Fatima updated','3 hr ago','teal','U'],
                            ['Monthly report generated','Yesterday','deep','R'],
                        ] as $i => $act)
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-full bg-{{ $act[2] }}/15 flex items-center justify-center text-{{ $act[2] }} text-[0.65rem] font-bold shrink-0 mt-0.5">
                                {{ $act[3] }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-700 leading-snug">{{ $act[0] }}</p>
                                <p class="text-[0.7rem] text-gray-400 mt-0.5">{{ $act[1] }}</p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </main>

        {{-- FOOTER --}}
        <footer class="px-6 py-4 border-t border-gray-100 text-xs text-gray-400 text-center">
            MeterPro &copy; {{ date('Y') }} — Water Meter Management System
        </footer>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sb = document.getElementById('sidebar');
        const ov = document.getElementById('overlay');
        sb.classList.toggle('-translate-x-full');
        ov.classList.toggle('hidden');
    }
</script>

</body>
</html>