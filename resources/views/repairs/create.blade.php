<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Repair</title>
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
                        slideUp: 'slideUp 0.5s cubic-bezier(0.22,1,0.36,1) both'
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body class="font-dm bg-deep min-h-screen flex items-center justify-center px-4 py-10">

    <div class="animate-slideUp bg-white rounded-3xl p-10 w-full max-w-md shadow-2xl relative overflow-hidden">

        {{-- Accent bar --}}
        <div class="absolute top-0 left-8 right-8 h-[3px] bg-gradient-to-r from-teal to-light rounded-b-md"></div>

        {{-- Icon --}}
        <div class="mx-auto mb-4 w-14 h-14 flex items-center justify-center rounded-2xl bg-gradient-to-br from-teal to-light shadow-lg shadow-light/30">
            <i class="fa-solid fa-screwdriver-wrench text-white text-xl"></i>
        </div>

        <h2 class="font-syne font-extrabold text-2xl text-deep text-center tracking-tight mb-1">Add Repair</h2>
        <p class="text-center text-sm text-teal/60 mb-7">Log a new meter repair request</p>

        <form action="{{ route('repairs.store') }}" method="post" class="space-y-5">
            @csrf
            {{-- Meter / Villager select --}}
            <div class="space-y-1.5">
                <label class="block text-[0.72rem] font-semibold uppercase tracking-widest text-deep">Villager</label>
                <select name="meter_id"
                    class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none appearance-none focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition">
                    <option value="" disabled selected>Select a villager…</option>

                    @foreach($meters->groupBy(fn($meter) => $meter->villager->id) as $villagerId => $meters)
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

            {{-- Problem Description --}}
            <div class="space-y-1.5">
                <label class="block text-[0.72rem] font-semibold uppercase tracking-widest text-deep">Problem Description</label>
                <input type="text" name="problem_description" placeholder="Describe the issue…"
                    class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none placeholder-[#9dbec7] focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition" />
            </div>

            {{-- Repair Cost --}}
            <div class="space-y-1.5">
                <label class="block text-[0.72rem] font-semibold uppercase tracking-widest text-deep">Repair Cost</label>
                <div class="relative">
                    <input type="number" name="repair_cost" placeholder="0.00"
                        class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 pr-16 text-[0.95rem] text-deep outline-none placeholder-[#9dbec7] focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition" />
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-teal/60">MAD</span>
                </div>
            </div>

            <label class="block text-[0.72rem] font-semibold uppercase tracking-widest text-deep">Repair Statu</label>
            <select name="status"
                class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none appearance-none focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition">
                <option value="" disabled selected>Select a status</option>
                <option value="in progress">In Progress</option>
                <option value="repaired">Repaired</option>

            </select>

            {{-- Submit --}}
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-teal to-light text-white font-syne font-bold text-base py-3.5 rounded-xl shadow-lg shadow-light/30 hover:-translate-y-0.5 hover:brightness-105 active:translate-y-0 transition-all duration-150 tracking-wide mt-2">
                <i class="fa-solid fa-plus text-sm"></i>
                Add Repair
            </button>

        </form>
    </div>

</body>

</html>