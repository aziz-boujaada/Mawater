<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Details</title>

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

        @include('components.side-bar', ['active' => 'meters'])

        <div class="ml-56 flex-1 flex flex-col min-w-0">

            {{-- HEADER --}}
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="font-syne font-bold text-deep text-lg">
                        Meter Details
                    </h1>
                    <p class="text-xs text-gray-400">
                        Full information about meter
                    </p>
                </div>

                <a href="{{ route('meters') }}"
                    class="text-sm text-gray-500 hover:text-deep border px-4 py-2 rounded-xl">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back
                </a>
            </header>

            {{-- CONTENT --}}
            <main class="p-6 space-y-6">

                {{-- TOP CARD --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border">

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 uppercase">Meter Reference</p>
                            <h2 class="text-2xl font-bold font-syne text-deep">
                                {{ $meter->meter_reference }}
                            </h2>
                        </div>

                        <div>
                            @if($meter->status === 'active')
                            <span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-xs font-semibold">
                                Active
                            </span>
                            @elseif($meter->status === 'broken')
                            <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">
                                Broken
                            </span>
                            @elseif($meter->status === 'repaired')
                            <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">
                                Repaired
                            </span>
                            @else
                            <span class="bg-yellow-50 text-yellow-600 px-3 py-1 rounded-full text-xs font-semibold">
                                Out of Service
                            </span>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- INFO GRID --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="bg-white p-5 rounded-2xl shadow-sm border">
                        <p class="text-gray-400 text-xs">Villager</p>
                        <p class="text-lg font-semibold">
                            {{ $meter->villager?->user?->name ?? '—' }}
                        </p>
                    </div>

                    <div class="bg-white p-5 rounded-2xl shadow-sm border">
                        <p class="text-gray-400 text-xs">Installation Date</p>
                        <p class="text-lg font-semibold">
                            {{ $meter->installation_date }}
                        </p>
                    </div>

                </div>

                {{-- READINGS TABLE --}}
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

                    <div class="px-6 py-4 border-b">
                        <h3 class="font-syne font-bold text-deep">Meter Readings</h3>
                    </div>

                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs text-gray-400 uppercase">
                            <tr>
                                <th class="px-6 py-3 text-left">ID</th>
                                <th class="px-6 py-3 text-left">Previous</th>
                                <th class="px-6 py-3 text-left">Current</th>
                                <th class="px-6 py-3 text-left">Consumption</th>
                                <th class="px-6 py-3 text-left">Date</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse($meter->meterReadings as $reading)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-gray-500">#{{ $reading->id }}</td>
                                <td class="px-6 py-3">{{ $reading->previous_reading }}</td>
                                <td class="px-6 py-3">{{ $reading->current_reading }}</td>
                                <td class="px-6 py-3 font-semibold text-deep">
                                    {{ $reading->consumption }}
                                </td>
                                <td class="px-6 py-3 text-gray-500">
                                    {{ $reading->reading_date }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-400">
                                    No readings found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
                @if($meter->status == 'broken')
                <div class="mt-4 p-6 bg-red-50 border border-red-200 rounded-xl">
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
            </main>

        </div>

    </div>

</body>

</html>