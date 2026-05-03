<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reading #{{ $reading->id }}</title>

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
</head>

<body class="font-dm bg-gray-50 text-gray-800">

<div class="flex min-h-screen">

    @include('components.side-bar', ['active' => 'readings'])

    <div class="ml-56 flex-1 flex flex-col">

        {{-- HEADER --}}
        <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="font-syne font-bold text-deep text-lg">
                    Reading Details
                </h1>
                <p class="text-xs text-gray-400">
                    Full meter reading information
                </p>
            </div>

            <a href="{{ route('readings') }}"
               class="text-sm text-gray-600 hover:text-deep border border-gray-200 px-4 py-2 rounded-xl">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back
            </a>
        </header>

        {{-- CONTENT --}}
        <main class="p-6">

            <div class="max-w-3xl mx-auto bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                {{-- TOP CARD --}}
                <div class="bg-gradient-to-r from-deep to-teal px-6 py-5 text-white flex justify-between items-center">
                    <div>
                        <p class="text-xs opacity-70">READING</p>
                        <h2 class="font-syne font-bold text-xl">
                            #{{ $reading->id }}
                        </h2>
                    </div>

                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-gauge text-lg"></i>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="divide-y divide-gray-100 p-6   ">

                    {{-- Meter --}}
                    <div class="flex justify-between items-center px-6 py-4">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-gauge text-light"></i>
                            Meter Reference
                        </span>

                        <span class="text-sm font-semibold text-teal">
                            {{ $reading->meter?->meter_reference ?? '—' }}
                        </span>
                    </div>

                    {{-- Villager --}}
                    <div class="flex justify-between items-center px-6 py-4">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-user text-light"></i>
                            Villager
                        </span>

                        <span class="text-sm font-medium">
                            {{ $reading->meter?->villager?->user?->name ?? '—' }}
                        </span>
                    </div>

                    {{-- Previous --}}
                    <div class="flex justify-between items-center px-6 py-4">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-arrow-left text-light"></i>
                            Previous Reading
                        </span>

                        <span class="text-sm font-semibold">
                            {{ number_format($reading->previous_reading ?? 0, 2) }}
                        </span>
                    </div>

                    {{-- Current --}}
                    <div class="flex justify-between items-center px-6 py-4">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-arrow-right text-light"></i>
                            Current Reading
                        </span>

                        <span class="text-sm font-semibold">
                            {{ number_format($reading->current_reading ?? 0, 2) }}
                        </span>
                    </div>

                    {{-- Consumption --}}
                    <div class="flex justify-between items-center px-6 py-4 bg-gray-50">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-bolt text-light"></i>
                            Consumption
                        </span>

                        <span class="text-lg font-extrabold text-deep">
                            {{ number_format($reading->consumption ?? 0, 2) }} m²
                        </span>
                    </div>

                    {{-- Date --}}
                    <div class="flex justify-between items-center px-6 py-4">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-calendar text-light"></i>
                            Reading Date
                        </span>

                        <span class="text-sm">
                            {{ \Carbon\Carbon::parse($reading->reading_date)->format('d M Y') }}
                        </span>
                    </div>

                    @if($reading->meter?->status == 'broken')
                   <div class="mt-4 p-6 bg-red-50 border border-red-200 rounded-xl mt-8">
                       <p class="font-semibold text-red-600">
                           ⚠ System Notice
                       </p>
    
                       <p class="text-sm text-red-500 mt-1">
                           This meter is currently broken. Billing is based on historical average consumption.
                       </p>
    
                       <p class="text-xs text-red-400 mt-2">
                           Last update: system auto-calculation enabled
                       </p>
                   </div>
                   @endif
                </div>
                
            </div>

        </main>

    </div>

</div>

</body>
</html>