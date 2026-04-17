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
                        deep: '#005461',
                        teal: '#0C7779',
                        mid: '#249E94',
                        light: '#3BC1A8',
                    },
                    fontFamily: {
                        syne: ['Syne', 'sans-serif'],
                        dm: ['DM Sans', 'sans-serif'],
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(12px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
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

    @include('components.side-bar')

    {{-- ───────────── MAIN CONTENT ───────────── --}}
    <div class="flex-1 flex flex-col lg:ml-64 min-w-0">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-6 py-4 flex items-center gap-4">

            {{-- Hamburger (mobile) --}}
            <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
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
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <span>Search…</span>
                </div>

                {{-- Notification bell --}}
                <button class="relative p-2 rounded-xl hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-light border-2 border-white"></span>
                </button>

                {{-- New meter CTA --}}
                <a href="{{ route('meter.create') ?? '#' }}"
                    class="flex items-center gap-2 bg-deep text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-teal transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    <span class="hidden sm:inline">New Meter</span>
                </a>
            </div>
        </header>

        {{-- PAGE BODY --}}
        <main class="flex-1 p-6 space-y-6 animate-fadeIn">

            {{-- ── mo$monthPayment CARDS ── --}}
            {{-- ── mo$monthPayment CARDS ── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                {{-- Total Users --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-deep/10 flex items-center justify-center">
                            <i class="fa-solid fa-users text-deep"></i>
                        </div>
                        <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-0.5 rounded-full">+12%</span>
                    </div>
                    <p class="text-2xl font-syne font-bold text-deep">{{ $total_users }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Total Users</p>
                </div>

                {{-- Total Budget --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                            <i class="fa-solid fa-wallet text-green-500"></i>
                        </div>
                        <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-0.5 rounded-full">Paid {{number_format($paidPercentage,2)}} %</span>
                    </div>
                    <p class="text-2xl font-syne font-bold text-green-500">{{ $total_budget }} DH</p>
                    <p class="text-xs text-gray-400 mt-0.5">Total Budget of invoices</p>
                    <div class="flex items-center gap-2 text-xs  ">
                        <div class="bg-green-50 text-green-500 font-syne p-2 rounded-2xl">Paid Budget {{ $total_paid }} DH</div>
                        <div class="bg-red-50 text-red-500 font-syne p-2 rounded-2xl">Unpaid Budget {{ $unpaid_payment }} DH</div>
                    </div>
                </div>

                {{-- Unpaid Payments --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                            <i class="fa-solid fa-money-bill-wave text-red-500"></i>
                        </div>
                        <span class="text-xs font-semibold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">Lost Percentag {{number_format($lossPercentage,2)}}%</span>
                    </div>
                    <p class="text-2xl font-syne font-bold text-yellow-600">{{ $repairLoseAmount }} DH</p>
                    <p class="text-xs text-gray-400 mt-0.5">Amount loses In Repairs</p>
                </div>

                {{-- Profit  Budget --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                            <i class="fa-solid fa-money-bill-wave text-blue-500"></i>
                        </div>
                        <span class="text-xs font-semibold text-blue-500 bg-blue-50 px-2 py-0.5 rounded-full">profit Margin {{number_format($profitMargin , 2) }} %</span>
                    </div>
                    <p class="text-2xl font-syne font-bold text-blue-600">{{ $netProfit }} DH</p>
                    <p class="text-xs text-gray-400 mt-0.5">Net Profit Of Assocciation</p>
                </div>

                {{-- Active Meters --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-light/15 flex items-center justify-center">
                            <i class="fa-solid fa-circle-check text-mid"></i>
                        </div>
                        <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-0.5 rounded-full">+5%</span>
                    </div>
                    <p class="text-2xl font-syne font-bold text-deep">{{ $activ_meters }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Active Meters</p>
                </div>

                {{-- Broken / Out of Service --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                            <i class="fa-solid fa-circle-exclamation text-red-400"></i>
                        </div>
                        <span class="text-xs font-semibold text-red-400 bg-red-50 px-2 py-0.5 rounded-full">-3%</span>
                    </div>
                    <p class="text-2xl font-syne font-bold text-deep">{{ $broken_and_outService_meters }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Broken / Out of Service</p>
                </div>

                {{-- Villagers --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-teal/10 flex items-center justify-center">
                            <i class="fa-solid fa-house-user text-teal"></i>
                        </div>
                        <div class="flex flex-col gap-1 items-end">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> Subscribed: {{ $subscriberd_villagers }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500 bg-red-50 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> UnSubscribed: {{ $unsubscriberd_villagers }}
                            </span>
                        </div>
                    </div>
                    <p class="text-2xl font-syne font-bold text-deep">{{ $total_villagers }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Villagers</p>
                </div>

            </div>
            <div class="max-w-6xl  p-6 space-y-6">

                {{-- TITLE --}}
                <h1 class="text-2xl font-bold text-gray-800">
                    Monthly Payments Statistics
                </h1>

                {{-- FLEX SECTION --}}
                <div class="flex flex-col lg:flex-row gap-6">

                    {{-- CHART (smaller card) --}}
                    <div class="bg-white p-4 rounded-xl shadow flex-1">
                        <canvas id="paymentsChart" height="120"></canvas>
                    </div>

                    {{-- QUICK STATS (optional but nice) --}}
                    <div class="bg-white p-4 rounded-xl shadow w-full lg:w-1/3">
                        <h2 class="font-semibold text-gray-700 mb-3">Summary</h2>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Total Months</span>
                                <span class="font-bold">{{ $monthlyPayments->count() }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Total Revenue</span>
                                <span class="font-bold text-green-600">
                                    {{ number_format($monthlyPayments->sum('total'), 2) }} DH
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- TABLE --}}
                <div class="bg-white rounded-xl shadow overflow-hidden">

                    <div class="p-4 border-b">
                        <h2 class="font-semibold text-gray-700">
                            Monthly Breakdown
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 text-left text-gray-600">
                                <tr>
                                    <th class="p-3">Month</th>
                                    <th class="p-3">Total Payments</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($monthlyPayments as $monthPayment)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">
                                        {{ $monthPayment->month }}
                                    </td>
                                    <td class="p-3 font-semibold text-green-600">
                                        {{ number_format($monthPayment->total, 2) }} DH
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function toggleSidebar() {
            const sb = document.getElementById('sidebar');
            const ov = document.getElementById('overlay');
            sb.classList.toggle('-translate-x-full');
            ov.classList.toggle('hidden');
        }

        const ctx = document.getElementById('paymentsChart');
        const chartData = @json($monthlyPayments);
        console.log(chartData);
        const labels = chartData.map(i => i.month);
        const data = chartData.map(i => Number(i.total));

        new Chart(document.getElementById('paymentsChart'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Payments (DH)',
                    data,
                    backgroundColor: '#0C7779'
                }]
            }
        });
    </script>

</body>

</html>