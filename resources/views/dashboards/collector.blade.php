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
    <div class="flex min-h-screen">

        @include('components.side-bar', ['active' => 'dashboard'])

        <div class="flex-1 flex flex-col lg:ml-56 min-w-0">

            {{-- TOPBAR --}}
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-6 py-4 flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <i class="fa-solid fa-bars text-gray-600"></i>
                </button>
                <div class="flex-1 min-w-0">
                    <h1 class="font-syne font-bold text-deep text-lg tracking-tight">Collector Dashboard</h1>
                    <p class="text-xs text-gray-400">Welcome back, {{ auth()->user()->name ?? 'Collector' }} 👋</p>
                </div>
                <button class="relative p-2 rounded-xl hover:bg-gray-100 transition">
                    <i class="fa-solid fa-bell text-gray-500"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-light border-2 border-white"></span>
                </button>
            </header>

            <main class="flex-1 p-6 space-y-6">

                {{-- STAT CARDS --}}
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">

                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-teal/10 flex items-center justify-center">
                                <i class="fa-solid fa-wave-square text-teal"></i>
                            </div>
                            <span class="text-xs font-semibold text-teal bg-teal/10 px-2 py-0.5 rounded-full">Readings</span>
                        </div>
                        <p class="text-2xl font-syne font-bold text-deep">{{ $readingsCount }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Total Readings</p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-deep/10 flex items-center justify-center">
                                <i class="fa-solid fa-receipt text-deep"></i>
                            </div>
                            <span class="text-xs font-semibold text-deep bg-deep/10 px-2 py-0.5 rounded-full">Invoices</span>
                        </div>
                        <p class="text-2xl font-syne font-bold text-deep">{{ $invoicesCount }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Total Invoices</p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-light/15 flex items-center justify-center">
                                <i class="fa-solid fa-money-bill-wave text-mid"></i>
                            </div>
                            <span class="text-xs font-semibold text-mid bg-light/15 px-2 py-0.5 rounded-full">Payments</span>
                        </div>
                        <p class="text-2xl font-syne font-bold text-deep">{{ $paymentsCount }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Total Payments</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                                <i class="fa-solid fa-coins text-green-600"></i>
                            </div>
                            <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-0.5 rounded-full">Collected</span>
                        </div>
                        <p class="text-2xl font-syne font-bold text-deep">{{ $totalCollected }} DH</p>
                        <p class="text-xs text-gray-400 mt-0.5">Total Collected</p>
                    </div>

                </div>

                {{-- TABS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    {{-- Tab buttons --}}
                    <div class="flex border-b border-gray-100">
                        <button onclick="switchTab('readings')" id="tab-readings"
                            class="tab-btn flex items-center gap-2 px-6 py-4 text-sm font-semibold border-b-2 border-teal text-teal transition-colors">
                            <i class="fa-solid fa-wave-square"></i>
                            Readings
                        </button>
                        <button onclick="switchTab('invoices')" id="tab-invoices"
                            class="tab-btn flex items-center gap-2 px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fa-solid fa-receipt"></i>
                            Invoices
                        </button>
                        <button onclick="switchTab('payments')" id="tab-payments"
                            class="tab-btn flex items-center gap-2 px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fa-solid fa-money-bill-wave"></i>
                            Payments
                        </button>
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

        function switchTab(tab) {
            // Hide all panels
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
            // Reset all buttons
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('border-teal', 'text-teal');
                b.classList.add('border-transparent', 'text-gray-400');
            });
            // Show selected panel
            document.getElementById('panel-' + tab).classList.remove('hidden');
            // Activate selected button
            const btn = document.getElementById('tab-' + tab);
            btn.classList.remove('border-transparent', 'text-gray-400');
            btn.classList.add('border-teal', 'text-teal');
        }
    </script>
</body>

</html>