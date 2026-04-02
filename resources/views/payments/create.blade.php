<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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


        {{-- MAIN --}}
        <div class="ml-56 flex-1 flex flex-col min-w-0">

            {{-- TOPBAR --}}
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-6 py-4 flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <i class="fa-solid fa-bars text-gray-600"></i>
                </button>
                <div class="flex-1">
                    <h1 class="font-syne font-bold text-deep text-lg tracking-tight">Collector Invoices</h1>
                    <p class="text-xs text-gray-400">Pending payments per collector</p>
                </div>
                <a href="{{ route('invoices') }}"
                    class="flex items-center gap-2 text-sm text-gray-500 hover:text-deep border border-gray-200 hover:border-deep px-4 py-2 rounded-xl transition-colors">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back
                </a>
            </header>

            {{-- CONTENT --}}
            <main class="flex-1 p-6 space-y-10">

                @foreach ($collectors as $collector)

                {{-- Collector section --}}
                <div>

                    {{-- Collector header --}}
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-mid to-light flex items-center justify-center text-white text-sm font-bold shrink-0">
                            {{ strtoupper(substr($collector->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="font-syne font-bold text-deep text-base">{{ $collector->name }}</h2>
                            <p class="text-xs text-gray-400">{{ $collector->invoices->count() }} invoice(s)</p>
                        </div>
                    </div>

                    {{-- Invoices grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">

                        @foreach ($collector->invoices as $invoice)

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">

                            {{-- Card header --}}
                            <div class="bg-gradient-to-r from-deep to-teal px-5 py-4 flex items-center justify-between">
                                <div>
                                    <p class="text-white/60 text-[0.65rem] font-semibold uppercase tracking-widest mb-0.5">Invoice</p>
                                    <h3 class="font-syne font-bold text-white text-base tracking-tight">{{ $invoice->invoice_reference }}</h3>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-receipt text-white"></i>
                                </div>
                            </div>

                            {{-- Details --}}
                            <div class="divide-y divide-gray-50 flex-1">

                                <div class="flex items-center justify-between px-5 py-3">
                                    <div class="flex items-center gap-2 text-gray-400 text-xs">
                                        <i class="fa-solid fa-hashtag w-3 text-center text-light"></i>
                                        <span>ID</span>
                                    </div>
                                    <span class="font-mono text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-lg">#{{ $invoice->id }}</span>
                                </div>

                                <div class="flex items-center justify-between px-5 py-3">
                                    <div class="flex items-center gap-2 text-gray-400 text-xs">
                                        <i class="fa-solid fa-gauge w-3 text-center text-light"></i>
                                        <span>Meter Ref</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-[#f4fafa] border border-[#d4e8ec] text-teal text-xs font-semibold px-2 py-0.5 rounded-full">
                                        {{ $invoice->reading->meter->meter_reference }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between px-5 py-3">
                                    <div class="flex items-center gap-2 text-gray-400 text-xs">
                                        <i class="fa-solid fa-user w-3 text-center text-light"></i>
                                        <span>Villager</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <div class="w-5 h-5 rounded-full bg-gradient-to-br from-mid to-light flex items-center justify-center text-white text-[0.6rem] font-bold shrink-0">
                                            {{ strtoupper(substr($invoice->reading->meter->villager->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-gray-700 font-medium text-xs">{{ $invoice->reading->meter->villager->user->name }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between px-5 py-3">
                                    <div class="flex items-center gap-2 text-gray-400 text-xs">
                                        <i class="fa-solid fa-calendar w-3 text-center text-light"></i>
                                        <span>Period</span>
                                    </div>
                                    <span class="text-gray-700 text-xs font-medium">{{ $invoice->billing_period }}</span>
                                </div>

                                <div class="flex items-center justify-between px-5 py-3">
                                    <div class="flex items-center gap-2 text-gray-400 text-xs">
                                        <i class="fa-solid fa-droplet w-3 text-center text-light"></i>
                                        <span>Consumption</span>
                                    </div>
                                    <span class="text-gray-700 text-xs font-medium">{{ $invoice->reading->consumption }} m³</span>
                                </div>

                                <div class="flex items-center justify-between px-5 py-4">
                                    <div class="flex items-center gap-2 text-gray-400 text-xs">
                                        <i class="fa-solid fa-money-bill-wave w-3 text-center text-light"></i>
                                        <span>Total</span>
                                    </div>
                                    <div>
                                        <span class="font-syne font-extrabold text-deep text-lg">{{ number_format($invoice->total_amount, 2) }}</span>
                                        <span class="text-gray-400 text-xs ml-0.5">MAD</span>
                                    </div>
                                </div>

                            </div>

                            {{-- Payment button --}}
                            <div class="px-5 py-4 bg-gray-50/50 border-t border-gray-100">
                                <form action="{{ route('payments.store') }}" method="POST" class="payment-form">
                                    @csrf
                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                                    <select name="status" onchange="toggleStatusPaidFields(this)">
                                        <option value="paid">Paid</option>
                                        <option value="partial">Partial</option>
                                    </select>

                                    <div class="partialFields space-y-4 hidden">
                                        <input type="number" name="amount_paid" placeholder="amount to pay EX:10DH"
                                            class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3" />
                                    </div>

                                    <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-teal to-light text-white font-bold text-sm py-2.5 rounded-xl">
                                        Mark as Paid
                                    </button>
                                </form>
                            </div>

                        </div>

                        @endforeach

                    </div>
                </div>

                @endforeach

            </main>
        </div>

    </div>

    <script>
        function toggleStatusPaidFields(selectElement) {
            const form = selectElement.closest('form');
            const fields = form.querySelector('.partialFields');
            const input = fields.querySelector('input');

            const isPartial = selectElement.value === "partial";

            fields.classList.toggle("hidden", !isPartial);
            input.disabled = !isPartial;

            if (!isPartial) {
                input.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('select[name="status"]').forEach(select => {
                toggleStatusPaidFields(select);
            });
        });
    </script>
</body>

</html>