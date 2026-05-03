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

        @include('components.side-bar' , ['active' => 'payments'])
        {{-- MAIN --}}
        <div class="ml-56 flex-1 flex flex-col min-w-0 ">

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

                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center gap-2 text-sm text-red-400 hover:text-red-800 border border-gray-200 hover:border-red-500 px-4 py-2 rounded-xl transition-colors"
                    title="Logout">
                    <i class="fa-solid fa-right-from-bracket text-sm"></i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </header>

            {{-- CONTENT --}}
            <main class="flex-1 p-6 space-y-10">



                @foreach ($collectors as $collector)

                {{-- Collector section --}}
                <div>

                    {{-- Collector header --}}
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-mid to-light flex items-center justify-center text-white text-sm font-bold shrink-0 shadow-md shadow-light/20">
                            {{ strtoupper(substr($collector->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="font-syne font-bold text-deep text-base">{{ $collector->name }}</h2>
                            <p class="text-xs text-gray-400">
                                <i class="fa-solid fa-receipt text-light mr-1"></i>
                                {{ $collector->invoices->count() }} invoice(s)
                            </p>
                        </div>
                        <div class="ml-auto h-px flex-1 bg-gray-100 max-w-xs"></div>
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
                                        {{ $invoice->reading?->meter?->meter_reference }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between px-5 py-3">
                                    <div class="flex items-center gap-2 text-gray-400 text-xs">
                                        <i class="fa-solid fa-user w-3 text-center text-light"></i>
                                        <span>Villager</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <div class="w-5 h-5 rounded-full bg-gradient-to-br from-mid to-light flex items-center justify-center text-white text-[0.6rem] font-bold shrink-0">
                                            {{ strtoupper(substr($invoice->reading?->meter?->villager->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-gray-700 font-medium text-xs">{{ $invoice->reading?->meter?->villager->user->name }}</span>
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
                                    <span class="text-gray-700 text-xs font-medium">{{ $invoice->reading?->consumption }} m³</span>
                                </div>

                                @php
                                $paid = $invoice->payments?->sum('amount_paid');
                                $remaining = $invoice->remaining_amount ?? $invoice->total_amount;
                                $total = $invoice->total_amount;
                                @endphp

                                {{-- Payment summary badges --}}
                                <div class="flex flex-wrap gap-2 items-center justify-center px-4 py-4 text-xs font-medium">
                                    <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-100 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-check text-[10px]"></i>
                                        {{ $paid }} DH paid
                                    </span>
                                    @if ($remaining > 0)
                                    <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 border border-red-100 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                                        {{ $remaining }} DH remaining
                                    </span>
                                    @endif
                                    <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-600 border border-blue-100 px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-money-bill-wave text-[10px]"></i>
                                        {{ $total }} DH total
                                    </span>
                                </div>

                            </div>

                            {{-- Payment form --}}
                            <div class="px-5 py-4 bg-gray-50/50 border-t border-gray-100">
                                <form action="{{ route('payments.store') }}" method="POST" class="payment-form space-y-3">
                                    @csrf
                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                                    @if ($invoice->total_amount > 0)

                                    {{-- Submit / Already Paid --}}
                                    @if ($remaining > 0)
                                    <div class="">
                                        <label for="amount_to_paid" class="flex items-center gap-2 text-gray-400 text-md pb-1">Amount To pay</label>
                                        <input type="number" name="amount_paid" placeholder="Amount to pay e.g. 10" step="0.01" min="0"
                                            class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-2.5 text-sm text-deep outline-none placeholder-[#9dbec7] focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition" />
                                    </div>
                                    <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-teal to-light text-white font-syne font-bold text-sm py-2.5 rounded-xl shadow-sm shadow-light/20 hover:-translate-y-0.5 hover:brightness-105 active:translate-y-0 transition-all duration-150">
                                        <i class="fa-solid fa-circle-check text-xs"></i>
                                        Pay
                                    </button>
                                    @else
                                    <div class="w-full flex items-center justify-center gap-2 bg-gray-200 text-gray-500 font-syne font-bold text-sm py-2.5 rounded-xl cursor-not-allowed">
                                        <i class="fa-solid fa-check-double text-xs"></i>
                                        Fully Paid
                                    </div>
                                    @endif

                                    @endif
                                </form>
                            </div>

                        </div>

                        @endforeach

                    </div>
                </div>

                @endforeach
                <div id="response_messgaes">
                    @if(session('error'))
                    <div class="response_messgaes absolute top-24 left-1/2 transform -translate-x-1/2 z-50 w-11/12 md:w-1/2 bg-red-50 border border-red-200 p-4 rounded-xl text-red-700 shadow-lg flex items-center gap-2">
                        {{ session('error') }}
                    </div>
                    @elseif(session('success'))
                <div class="response_messgaes absolute top-24 left-1/2 transform -translate-x-1/2 z-50 w-11/12 md:w-1/2 bg-green-50 border border-green-200 p-4 rounded-xl text-green-700 shadow-lg flex items-center gap-2">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
               
            </main>




            <script>
                const hideresponsMessage = () => {
                    const respons_msg = document.getElementById('response_messgaes')
                    if (respons_msg) {
                        setTimeout(() => {
                            respons_msg.classList.add('hidden');
                        }, 5000);
                    }

                }
                document.addEventListener('DOMContentLoaded', () => {
                    hideresponsMessage()
                });
            </script>
</body>

</html>