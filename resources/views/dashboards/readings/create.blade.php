<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Create Meter Reading</title>
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
                    keyframes: {
                        slideUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(28px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        }
                    },
                    animation: {
                        slideUp: 'slideUp 0.5s cubic-bezier(0.22,1,0.36,1) both',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>
@include('components.side-bar' , ['active' => 'readings'])

<body class="font-dm bg-white min-h-screen flex items-center justify-center px-4 py-10">

    <div class="animate-slideUp bg-white rounded-3xl p-10 w-full max-w-md shadow-2xl relative overflow-hidden">

        {{-- Top accent bar --}}
        <div class="absolute top-0 left-8 right-8 h-[3px] bg-gradient-to-r from-teal to-light rounded-b-md"></div>

        {{-- Icon --}}
        <div class="mx-auto mb-4 w-14 h-14 flex items-center justify-center rounded-2xl bg-gradient-to-br from-teal to-light shadow-lg shadow-light/30">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
                <line x1="2" y1="12" x2="4" y2="12" />
                <line x1="20" y1="12" x2="22" y2="12" />
                <line x1="12" y1="2" x2="12" y2="4" />
            </svg>
        </div>

        {{-- Heading --}}
        <h2 class="font-syne font-extrabold text-2xl text-deep text-center tracking-tight mb-1">Create Reading</h2>
        <p class="text-center text-sm text-teal/60 mb-7">Register a new Reading to the system</p>

        <form action="{{ route('reading.store') }}" method="post" class="space-y-5">
            @csrf
            <!-- # region -->
            {{-- Villager --}}
            <div class="space-y-1.5">
                <label class="block text-[0.72rem] font-semibold uppercase tracking-widest text-deep">Villager</label>
                <select name="meter_id"
                    class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none appearance-none
               focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition">
                    <option value="" disabled selected>Select a villager…</option>

                    @foreach($meter_of->groupBy(fn($meter) => $meter->villager->id) as $villagerId => $meters)
                    <optgroup label="{{ $meters->first()->villager->user->name }}">
                        @foreach($meters as $meter)
                        <option value="{{ $meter->id }}">
                            Meter: {{ mb_substr($meter->meter_reference, 0, 10) }}
                        </option>
                        @endforeach
                    </optgroup>
                    @endforeach

                </select>
            </div>



            {{-- current readings --}}
            <div class="space-y-1.5">
                <label for="current_reading" class="block text-[0.72rem] font-semibold uppercase tracking-widest text-deep">Current_reading</label>
                <input type="number" id="current_reading" name="current_reading"
                    class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none
                           focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition" />
            </div>

            {{-- Installation Date --}}
            <div class="space-y-1.5">
                <label for="reading_date" class="block text-[0.72rem] font-semibold uppercase tracking-widest text-deep">Reading Date</label>
                <input type="date" id="reading_date" name="reading_date"
                    class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none
                           focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition" />
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full bg-gradient-to-r from-teal to-light text-white font-syne font-bold text-base py-3.5 rounded-xl
                       shadow-lg shadow-light/30 hover:-translate-y-0.5 hover:shadow-xl hover:brightness-105
                       active:translate-y-0 transition-all duration-150 tracking-wide">
                Create New Reading →
            </button>

            {{-- Errors --}}
            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                    <li class="text-red-600 text-sm">— {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 rounded-xl bg-red-50 border border-red-200 p-4 text-red-700">
                _ {{ session('error') }}
            </div>
            @endif

        </form>
    </div>

</body>

</html>