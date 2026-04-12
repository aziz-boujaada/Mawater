<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villager Dashboard</title>
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
                    <p class="text-xs text-gray-400">Welcome back, {{ auth()->user()->name ?? 'villager' }} 👋</p>
                </div>
                <button class="relative p-2 rounded-xl hover:bg-gray-100 transition">
                    <i class="fa-solid fa-bell text-gray-500"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-light border-2 border-white"></span>
                </button>
            </header>

            <main class="flex-1 p-6 space-y-6">


                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                    {{-- Total Readings --}}
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                                <i class="fa-solid fa-gauge text-blue-500"></i>
                            </div>
                            <span class="text-xs text-gray-400 font-medium">Readings</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $readingsCount }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Total meter readings</p>
                    </div>

                    {{-- Total Invoices --}}
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center">
                                <i class="fa-solid fa-file-invoice text-orange-500"></i>
                            </div>
                            <span class="text-xs text-gray-400 font-medium">Invoices</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $invoicesCount }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Total invoices generated</p>
                    </div>

                    {{-- Paid Invoices --}}
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center">
                                <i class="fa-solid fa-circle-check text-green-500"></i>
                            </div>
                            <span class="text-xs text-gray-400 font-medium">Paid</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $paidInvoicesCount }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Paid invoices</p>
                    </div>

                    {{-- Total Paid Amount --}}
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                                <i class="fa-solid fa-money-bill-wave text-emerald-500"></i>
                            </div>
                            <span class="text-xs text-gray-400 font-medium">Paid Amount</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ number_format($totalAmountPaid, 2) }} DH
                        </h3>
                        <p class="text-xs text-gray-400 mt-1">Total amount already paid</p>
                    </div>

                    {{-- Remaining Amount --}}
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center">
                                <i class="fa-solid fa-wallet text-red-500"></i>
                            </div>
                            <span class="text-xs text-gray-400 font-medium">Remaining</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ number_format($remainingAmount, 2) }} DH
                        </h3>
                        <p class="text-xs text-gray-400 mt-1">Pending unpaid amount</p>
                    </div>

                </div>



            </main>

            <footer class="px-6 py-4 border-t border-gray-100 text-xs text-gray-400 text-center">
                MeterPro &copy; {{ date('Y') }} — Water Meter Management System
            </footer>
        </div>
    </div>

</body>

</html>