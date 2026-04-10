<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices</title>
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

<body class="font-dm bg-gray-50 text-gray-800">
    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        @include('components.side-bar' ,['active' => 'invoices'])

        {{-- MAIN --}}
        <div class="ml-56 flex-1 flex flex-col min-w-0">

            {{-- TOPBAR --}}
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="font-syne font-bold text-deep text-lg tracking-tight">Invoices</h1>
                    <p class="text-xs text-gray-400">Billing records & payment history</p>
                </div>
                <a href="{{ route('invoices.create') }}"
                    class="flex items-center gap-2 bg-deep text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-teal transition-colors shadow-sm">
                    <i class="fa-solid fa-plus text-xs"></i>
                    New Invoice
                </a>
            </header>

            {{-- CONTENT --}}
            <main class="flex-1 p-6">
                <div class="bg-white mb-4 rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    {{-- Table header --}}
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h3 class="font-syne font-bold text-deep text-sm">All Invoices</h3>

                        {{-- Search --}}
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
                                    <th class="px-6 py-3">Reference</th>
                                    <th class="px-6 py-3">Meter Ref</th>
                                    <th class="px-6 py-3">Villager</th>
                                    <th class="px-6 py-3">Amount</th>
                                    <th class="px-6 py-3">Remaining Amount</th>
                                    <th class="px-6 py-3">status</th>
                                    <th class="px-6 py-3">Billing Period</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($invoices as $invoice)
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <td class="px-6 py-3.5 text-gray-400 font-mono text-xs">#{{ $invoice->id }}</td>
                                    <td class="px-6 py-3.5 font-semibold text-deep text-xs tracking-wide">{{ $invoice->invoice_reference }}</td>
                                    <td class="px-6 py-3.5">
                                        <span class="inline-flex items-center gap-1.5 bg-[#f4fafa] border border-[#d4e8ec] text-teal text-xs font-semibold px-2.5 py-1 rounded-full">
                                            <i class="fa-solid fa-gauge text-[0.6rem]"></i>
                                            {{ $invoice->reading?->meter?->meter_reference ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-mid to-light flex items-center justify-center text-white text-[0.6rem] font-bold shrink-0">
                                                {{ strtoupper(substr($invoice->reading?->meter?->villager?->user?->name ?? 'U', 0, 2)) }}
                                            </div>
                                            <span class="text-gray-700 font-medium text-sm">{{ $invoice->reading?->meter?->villager?->user?->name ?? '—' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <span class="font-syne font-bold text-deep">{{ number_format($invoice->total_amount, 2) }}</span>
                                        <span class="text-yellow-600 text-xs ml-0.5">DH</span>
                                    </td>
                                    
                                     <td class="px-6 py-3.5">
                                        <span class="font-syne bg-red-50 p-1 rounded-2xl  font-bold text-red-500">{{ number_format($invoice->remaining_amount, 2) }}</span>
                                        <span class="text-yellow-600 text-xs ml-0.5">DH</span>
                                    </td>
                                    <td class="px-6 py-3.5 text-gray-500 text-xs">
                                        @if ($invoice->status == 'paid')
                                        <span class="inline-flex items-center justify-center w-[100px] gap-1.5  font-syne font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">
                                            paid
                                        </span>
                                        @elseif($invoice->status == 'partially_paid')
                                        <span class="inline-flex items-center justify-center w-[100px] gap-1.5  font-syne font-semibold text-yellow-600 bg-yellow-50 px-2.5 py-1 rounded-full">
                                            Partial Paid
                                        </span>
                                        @elseif($invoice->status == 'unpaid')
                                        <span class="inline-flex items-center justify-center w-[100px] gap-1.5  font-syne font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-full">
                                            Unpaid
                                        </span>
                                        @endif
                                        <td class="px-6 py-3.5 text-gray-500 text-xs">{{ $invoice->billing_period }}</td>
                                        
                                    </td>
                                    <td class="px-6 py-3.5 text-right">
                                        <a href="{{ route('invoices.show' ,$invoice->id) }}" class="text-xs text-mid font-semibold hover:underline">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center">
                                                <i class="fa-solid fa-file-circle-xmark text-red-400 text-base"></i>
                                            </div>
                                            <p class="text-red-500 font-semibold text-sm">No invoices found</p>
                                            <p class="text-red-300 text-xs">There are no invoices to display at the moment.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $invoices->links() }}
            </main>
        </div>
    </div>
</body>

</html>