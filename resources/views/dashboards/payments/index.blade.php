<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Readings</title>
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
                        light: '#3BC1A8',
                    },
                    fontFamily: {
                        syne: ['Syne', 'sans-serif'],
                        dm: ['DM Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body class="font-dm bg-gray-50 text-grav y-800">
    <div class="flex min-h-screen">

        @include('components.side-bar' , ['active' => 'payments'])

        <div class="ml-56 flex-1 flex flex-col min-w-0">
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="font-syne font-bold text-deep text-lg tracking-tight">Payments</h1>
                    <p class="text-xs text-gray-400">All Payments records</p>
                </div>
                <a href="{{ route('payments.create') }}" class="flex items-center gap-2 bg-deep text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-teal transition-colors shadow-sm">
                    <i class="fa-solid fa-plus text-xs"></i>
                    New payment
                </a>
            </header>

            <main class="flex-1 p-6">
                <div class="bg-white mb-4 rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h3 class="font-syne font-bold text-deep text-sm">All Payments</h3>

                        <div class="flex items-center gap-2 bg-gray-100 rounded-xl px-3 py-2 text-sm text-gray-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            <input type="text" placeholder="Search…" class="bg-transparent outline-none text-gray-600 placeholder-gray-400 text-sm w-40">
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-[0.72rem] uppercase tracking-widest text-gray-400 font-semibold">
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Invoice ID</th>
                                    <th class="px-6 py-3">Invoice Total</th>
                                    <th class="px-6 py-3">Collector</th>
                                    <th class="px-6 py-3">Amount Paid</th>

                                    <th class="px-6 py-3">Paid at</th>

                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($payments as $payment)
                                <tr class="hover:bg-gray-50/60 transition-colors">

                                    <td class="px-6 py-3.5 text-gray-400 font-mono text-xs">#{{ $payment->id }}</td>

                                    <td class="px-6 py-3.5">
                                        <span class="inline-flex items-center gap-1.5 bg-[#f4fafa] border border-[#d4e8ec] text-teal text-xs font-semibold px-2.5 py-1 rounded-full">
                                            <i class="fa-solid fa-receipt text-lg"></i>
                                            {{ $payment->invoice?->id ?? '—' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-3.5">{{ number_format($payment->invoice?->total_amount ?? 0, 2) }} DH</td>

                                    <td class="px-6 py-3.5">
                                        <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-medium">
                                            <i class="fa-solid fa-user text-[0.7rem]"></i>
                                            {{ $payment->collector?->name ?? '—' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-3.5">
                                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">
                                            <i class="fa-solid fa-check text-[0.7rem]"></i>
                                            {{ number_format($payment->amount_paid, 2) }} DH
                                        </span>
                                    </td>

                                  
                                    <td class="px-6 py-3.5 text-gray-500 text-xs">{{ $payment->payment_date }}</td>

                                    <td class="px-6 py-3.5 text-right">
                                        <a href="{{ route('payments.show', $payment->id) }}" class="text-xs text-mid font-semibold hover:underline">View</a>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center">
                                                <i class="fa-solid fa-file-circle-xmark text-red-400 text-base"></i>
                                            </div>
                                            <p class="text-red-500 font-semibold text-sm">No payments found</p>
                                            <p class="text-red-300 text-xs">There are no payments to display at the moment.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $payments->links() }}
            </main>
        </div>
    </div>
</body>

</html>