<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->id }}</title>
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
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body class="font-dm bg-gray-50 text-gray-800">
    <div class="flex min-h-screen">

        @include('components.side-bar', ['active' => 'invoices'])

        {{-- MAIN --}}
        <div class="ml-56 flex-1 flex flex-col min-w-0">

            {{-- TOPBAR --}}
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-6 py-4 flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <i class="fa-solid fa-bars text-gray-600"></i>
                </button>
                <div class="flex-1">
                    <h1 class="font-syne font-bold text-deep text-lg tracking-tight">Invoice Detail</h1>
                    <p class="text-xs text-gray-400">Full breakdown for invoice #{{ $invoice->id }}</p>
                </div>
                <a href="{{ route('invoices') }}"
                    class="flex items-center gap-2 text-sm text-gray-500 hover:text-deep border border-gray-200 hover:border-deep px-4 py-2 rounded-xl transition-colors">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back
                </a>
            </header>

            {{-- CONTENT --}}
            <main class="flex-1 p-6">
                <div class="max-w-2xl mx-auto space-y-4">

                    {{-- Invoice card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                        {{-- Card header --}}
                        <div class="bg-gradient-to-r from-deep to-teal px-6 py-5 flex items-center justify-between">
                            <div>
                                <p class="text-white/60 text-xs mb-1 font-semibold uppercase tracking-widest">Invoice</p>
                                <h2 class="font-syne font-bold text-white text-xl tracking-tight">{{ $invoice->invoice_reference }}</h2>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center">
                                <i class="fa-solid fa-receipt text-white text-lg"></i>
                            </div>
                        </div>

                        {{-- Details grid --}}
                        <div class="divide-y divide-gray-50">

                            <div class="flex items-center justify-between px-6 py-4">
                                <div class="flex items-center gap-3 text-gray-400 text-sm">
                                    <i class="fa-solid fa-hashtag w-4 text-center text-light"></i>
                                    <span>Invoice ID</span>
                                </div>
                                <span class="font-mono text-xs font-semibold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-lg">#{{ $invoice->id }}</span>
                            </div>

                            <div class="flex items-center justify-between px-6 py-4">
                                <div class="flex items-center gap-3 text-gray-400 text-sm">
                                    <i class="fa-solid fa-gauge w-4 text-center text-light"></i>
                                    <span>Meter Reference</span>
                                </div>
                                <span class="inline-flex items-center gap-1.5 bg-[#f4fafa] border border-[#d4e8ec] text-teal text-xs font-semibold px-2.5 py-1 rounded-full">
                                    {{ $invoice->reading->meter->meter_reference }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between px-6 py-4">
                                <div class="flex items-center gap-3 text-gray-400 text-sm">
                                    <i class="fa-solid fa-user w-4 text-center text-light"></i>
                                    <span>Villager</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-mid to-light flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($invoice->reading->meter->villager->user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-gray-700 font-medium text-sm">{{ $invoice->reading->meter->villager->user->name }}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between px-6 py-4">
                                <div class="flex items-center gap-3 text-gray-400 text-sm">
                                    <i class="fa-solid fa-calendar w-4 text-center text-light"></i>
                                    <span>Billing Period</span>
                                </div>
                                <span class="text-gray-700 text-sm font-medium">{{ $invoice->billing_period }}</span>
                            </div>

                            <div class="flex items-center justify-between px-6 py-4">
                                <div class="flex items-center gap-3 text-gray-400 text-sm">
                                    <i class="fa-solid fa-gauge w-4 text-center text-light"></i>
                                    <span>Consumpation</span>
                                </div>
                                <span class="text-gray-700 text-sm font-medium">{{ $invoice->reading->consumption }}</span>
                            </div>

                            <div class="flex items-center justify-between px-6 py-5">
                                <div class="flex items-center gap-3 text-gray-400 text-sm">
                                    <i class="fa-solid fa-money-bill-wave w-4 text-center text-light"></i>
                                    <span>Status</span>
                                </div>
                                <div class="text-right">
                                    @if ($invoice->status == 'paid')
                                    <span class="inline-flex items-center justify-center  gap-1.5  font-syne font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">
                                        paid
                                    </span>
                                    @elseif($invoice->status == 'partially_paid')
                                    <span class="inline-flex items-center justify-center  gap-1.5  font-syne font-semibold text-yellow-600 bg-yellow-50 px-2.5 py-1 rounded-full">
                                        Partial Paid
                                    </span>
                                    <span class="bg-red-50 text-red-600 font-syne p-1 rounded-full">Remaining {{ $invoice->remaining_amount }} DH</span>
                                    @elseif($invoice->status == 'unpaid')
                                    <span class="inline-flex items-center justify-center  gap-1.5  font-syne font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-full">
                                        Unpaid
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-between px-6 py-5">
                                <div class="flex items-center gap-3 text-gray-400 text-sm">
                                    <i class="fa-solid fa-money-bill-wave w-4 text-center text-light"></i>
                                    <span>Total Amount</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-syne font-extrabold text-deep text-2xl">{{ number_format($invoice->total_amount, 2) }}</span>
                                    <span class="text-gray-400 text-sm ml-1">DH</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </main>
        </div>

    </div>

    <script>
        function toggleSidebar() {
            const sb = document.getElementById('sidebar');
            const ov = document.getElementById('sidebar-overlay');
            sb.classList.toggle('-translate-x-full');
            ov.classList.toggle('hidden');
        }
    </script>
</body>

</html>