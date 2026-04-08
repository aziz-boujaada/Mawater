<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collector Dashboard</title>
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
                        light: '#3BC1A8'
                    },
                    fontFamily: {
                        syne: ['Syne', 'sans-serif'],
                        dm: ['DM Sans', 'sans-serif']
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(8px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        }
                    },
                    animation: {
                        fadeIn: 'fadeIn 0.3s ease both'
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body class="font-dm bg-gray-50 text-gray-800">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="flex min-h-screen">

        @include('components.side-bar', ['active' => 'dashboard'])

        <div class="flex-1 flex flex-col lg:ml-56 min-w-0">

            {{-- TOPBAR --}}
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-6 py-4 flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <i class="fa-solid fa-bars text-gray-600"></i>
                </button>
                <div class="flex-1 min-w-0">
                    <h1 class="font-syne font-bold text-deep text-lg tracking-tight">Repair Agent Dashboard</h1>
                    <p class="text-xs text-gray-400">Welcome back, {{ auth()->user()->name ?? 'Repair Agent' }} 👋</p>
                </div>
                <button class="relative p-2 rounded-xl hover:bg-gray-100 transition">
                    <i class="fa-solid fa-bell text-gray-500"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-light border-2 border-white"></span>
                </button>
            </header>

            <main class="flex-1 p-6 space-y-6">

                {{-- STAT CARDS --}}
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">

                    <!-- Total Repairs -->
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-teal/10 flex items-center justify-center">
                                <i class="fa-solid fa-screwdriver-wrench text-teal"></i>
                            </div>
                            <span class="text-xs font-semibold text-teal bg-teal/10 px-2 py-0.5 rounded-full">Repairs</span>
                        </div>
                        <p class="text-2xl font-syne font-bold text-deep">{{ $repairsCount }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Total Repairs</p>
                    </div>

                    <!-- Total Loss Cost -->
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center">
                                <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                            </div>
                            <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-0.5 rounded-full">Loss Cost</span>
                        </div>
                        <p class="text-2xl font-syne font-bold text-deep">{{ $repairsAmountLose }} DH</p>
                        <p class="text-xs text-gray-400 mt-0.5">Total Losses</p>
                    </div>

                    <!-- Average Repair Cost -->
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <i class="fa-solid fa-chart-line text-blue-600"></i>
                            </div>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">Average Cost</span>
                        </div>
                        <p class="text-2xl font-syne font-bold text-deep">{{ number_format($moyenCost ,2)}} DH</p>
                        <p class="text-xs text-gray-400 mt-0.5">Repairs Average</p>
                    </div>

                    <!-- Completion Rate -->
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 rounded-2xl bg-green-100 flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-circle-check text-green-600 text-lg"></i>
                            </div>
                            <span class="text-xs font-semibold text-green-700 bg-green-100 px-3 py-1 rounded-full">
                                Completion Rate
                            </span>
                        </div>

                        <!-- Percentage -->
                        <div class="mb-3">
                            <p class="text-3xl font-syne font-bold text-deep leading-none">
                                {{ number_format($completionRate, 2) }}%
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Repair success overview</p>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden mb-4">
                            <div
                                class="bg-green-500 h-2.5 rounded-full transition-all duration-700"
                                style="width: {{ $completionRate }}%">
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-2">
                            <div class="rounded-xl bg-green-50 px-3 py-2">
                                <p class="text-xs text-gray-500">Repaired</p>
                                <p class="text-sm font-bold text-green-600">{{ $completedRepairs }}</p>
                            </div>

                            <div class="rounded-xl bg-red-50 px-3 py-2">
                                <p class="text-xs text-gray-500">In Progress</p>
                                <p class="text-sm font-bold text-red-500">{{ $inProgressRepairs }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 max-w-md mr-auto">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-syne text-lg font-bold text-deep">Repair Status Overview</h2>
                        <i class="fa-solid fa-chart-pie text-green-500"></i>
                    </div>

                    <div style="position: relative; height: 200px; width: 100%;">
                        <canvas id="repairChart"></canvas>
                    </div>
                </div>

            </main>

            <footer class="px-6 py-4 border-t border-gray-100 text-xs text-gray-400 text-center">
                MeterPro &copy; {{ date('Y') }} — Water Meter Management System
            </footer>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sb = document.getElementById('sidebar');
            const ov = document.getElementById('sidebar-overlay');
            sb.classList.toggle('-translate-x-full');
            ov.classList.toggle('hidden');
        }
        const ctx = document.getElementById('repairChart');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Repaired', 'In Progress'],
                datasets: [{
                    data: [{{$completedRepairs}}, {{$inProgressRepairs}}],
                    backgroundColor: ['#22c55e', '#ef4444'],
                    borderWidth: 0,
                    borderRadius: 6
                }]
            },
            options: {
                cutout: '20%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            padding: 15
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>

</html>