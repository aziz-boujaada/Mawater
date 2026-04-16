<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body class="font-dm bg-gray-50 text-gray-800">
<div class="flex min-h-screen">

    @include('components.side-bar', ['active' => 'payments'])

    <div class="ml-56 flex-1 flex flex-col min-w-0">

        {{-- ── HEADER ── --}}
        <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="font-syne font-bold text-deep text-lg tracking-tight">Payment Details</h1>
                <p class="text-xs text-gray-400">Detailed payment information</p>
            </div>
            <a href="{{ route('payments') }}"
               class="flex items-center gap-2 bg-gray-100 text-gray-600 text-sm font-semibold px-4 py-2 rounded-xl hover:bg-gray-200 transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back
            </a>
        </header>

        {{-- ── MAIN ── --}}
        <main class="flex items-center justify-center p-6">
            <div class="max-w-2xl space-y-4">

                {{-- Top status banner --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                             style="background:linear-gradient(135deg,rgba(59,193,168,.15),rgba(36,158,148,.08));">
                            <i class="fa-solid fa-receipt text-mid text-base"></i>
                        </div>
                        <div>
                            <p class="font-syne font-bold text-deep text-sm leading-tight">
                                Payment <span class="text-teal">#{{ $payment->id }}</span>
                            </p>
                            <p class="text-xs text-gray-400">Invoice #{{ $payment->invoice?->id ?? '—' }}</p>
                        </div>
                    </div>

                    {{-- Payment status badge --}}
                    @php
                        $remaining = $payment->invoice?->remaining_amount ?? 0;
                    @endphp
                    @if($remaining <= 0)
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold px-3 py-1 rounded-full bg-green-50 text-green-600 border border-green-100">
                            <i class="fa-solid fa-circle-check text-[10px]"></i>
                            Paid
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold px-3 py-1 rounded-full bg-amber-50 text-amber-600 border border-amber-100">
                            <i class="fa-solid fa-clock text-[10px]"></i>
                            Partial
                        </span>
                    @endif
                </div>

                {{-- Main details card --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                    <div class="px-6 py-3.5 border-b border-gray-50">
                        <h2 class="font-syne font-bold text-deep text-sm tracking-tight">
                            <i class="fa-solid fa-circle-info text-light mr-2 text-xs"></i>
                            Payment Information
                        </h2>
                    </div>

                    <div class="divide-y divide-gray-50">

                        {{-- Payment ID --}}
                        <div class="flex items-center justify-between px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center">
                                    <i class="fa-solid fa-hashtag text-gray-400 text-[11px]"></i>
                                </div>
                                <p class="text-xs text-gray-400 font-medium">Payment ID</p>
                            </div>
                            <p class="font-mono text-xs font-semibold text-deep bg-gray-50 px-2.5 py-1 rounded-lg">
                                #{{ $payment->id }}
                            </p>
                        </div>

                        {{-- Invoice ID --}}
                        <div class="flex items-center justify-between px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-[#f4fafa] flex items-center justify-center">
                                    <i class="fa-solid fa-file-invoice text-teal text-[11px]"></i>
                                </div>
                                <p class="text-xs text-gray-400 font-medium">Invoice</p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 bg-[#f4fafa] border border-[#d4e8ec] text-teal text-xs font-semibold px-2.5 py-1 rounded-full">
                                <i class="fa-solid fa-file-lines text-[9px]"></i>
                                #{{ $payment->invoice?->id ?? '—' }}
                            </span>
                        </div>

                        {{-- Collector --}}
                        <div class="flex items-center justify-between px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-gray-400 text-[11px]"></i>
                                </div>
                                <p class="text-xs text-gray-400 font-medium">Collector</p>
                            </div>
                            <p class="text-sm font-semibold text-gray-700">
                                {{ $payment->collector?->name ?? '—' }}
                            </p>
                        </div>

                        {{-- Payment Date --}}
                        <div class="flex items-center justify-between px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center">
                                    <i class="fa-solid fa-calendar-day text-gray-400 text-[11px]"></i>
                                </div>
                                <p class="text-xs text-gray-400 font-medium">Payment Date</p>
                            </div>
                            <p class="text-sm text-gray-600">{{ $payment->payment_date }}</p>
                        </div>

                    </div>
                </div>

                {{-- Financial summary card --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                    <div class="px-6 py-3.5 border-b border-gray-50">
                        <h2 class="font-syne font-bold text-deep text-sm tracking-tight">
                            <i class="fa-solid fa-coins text-light mr-2 text-xs"></i>
                            Financial Summary
                        </h2>
                    </div>

                    <div class="grid grid-cols-3 divide-x divide-gray-50">

                        {{-- Invoice Total --}}
                        <div class="px-6 py-5 text-center">
                            <div class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-2">
                                <i class="fa-solid fa-file-invoice-dollar text-gray-400 text-xs"></i>
                            </div>
                            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider mb-1">Invoice Total</p>
                            <p class="font-syne font-bold text-deep text-lg">
                                {{ number_format($payment->invoice?->total_amount ?? 0, 2) }}
                                <span class="text-xs font-normal text-gray-400">DH</span>
                            </p>
                        </div>

                        {{-- Amount Paid --}}
                        <div class="px-6 py-5 text-center">
                            <div class="w-8 h-8 rounded-xl bg-green-50 flex items-center justify-center mx-auto mb-2">
                                <i class="fa-solid fa-circle-check text-green-500 text-xs"></i>
                            </div>
                            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider mb-1">Amount Paid</p>
                            <p class="font-syne font-bold text-green-600 text-lg">
                                {{ number_format($payment->amount_paid, 2) }}
                                <span class="text-xs font-normal text-gray-400">DH</span>
                            </p>
                        </div>

                        {{-- Remaining --}}
                        <div class="px-6 py-5 text-center">
                            <div class="w-8 h-8 rounded-xl bg-red-50 flex items-center justify-center mx-auto mb-2">
                                <i class="fa-solid fa-circle-exclamation text-red-400 text-xs"></i>
                            </div>
                            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider mb-1">Remaining</p>
                            <p class="font-syne font-bold text-red-500 text-lg">
                                {{ number_format($payment->invoice?->remaining_amount ?? 0, 2) }}
                                <span class="text-xs font-normal text-gray-400">DH</span>
                            </p>
                        </div>

                    </div>

                   

                </div>

            </div>
        </main>
    </div>
</div>
</body>
</html>