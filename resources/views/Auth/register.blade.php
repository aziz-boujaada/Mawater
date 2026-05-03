<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Register</title>
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
                    keyframes: {
                        slideUp: {
                            '0%':   { opacity: '0', transform: 'translateY(28px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="font-dm bg-deep min-h-screen flex items-center justify-center px-4 py-10">

<div class="animate-slideUp w-full max-w-4xl flex rounded-3xl shadow-2xl overflow-hidden">

    {{-- WELCOME ASIDE --}}
    <aside class="hidden lg:flex flex-col justify-between w-80 shrink-0 bg-gradient-to-br from-teal via-[#0e8a8c] to-mid p-10 relative overflow-hidden">

        <div class="absolute -top-16 -left-16 w-64 h-64 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-20 -right-20 w-72 h-72 rounded-full bg-white/5"></div>

        {{-- Top --}}
        <div class="relative z-10">
            <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center mb-8">
                <i class="fa-solid fa-gauge text-white text-xl"></i>
            </div>
            <h1 class="font-syne font-extrabold text-white text-3xl leading-tight mb-3">
                Welcome to<br>MeterPro
            </h1>
            <p class="text-white/60 text-sm leading-relaxed">
                Smart water meter management for rural communities. Track, monitor, and report with ease.
            </p>
        </div>

        {{-- Features --}}
        <div class="relative z-10 space-y-4 my-8">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-dial text-white text-xs"></i>
                </div>
                <p class="text-white/80 text-sm">Real-time meter monitoring</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-users text-white text-xs"></i>
                </div>
                <p class="text-white/80 text-sm">Manage villagers & accounts</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-file-lines text-white text-xs"></i>
                </div>
                <p class="text-white/80 text-sm">Automated billing & reports</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-shield-halved text-white text-xs"></i>
                </div>
                <p class="text-white/80 text-sm">Role-based access control</p>
            </div>
        </div>

        {{-- Bottom CTA --}}
        <div class="relative z-10">
            <p class="text-white/50 text-xs mb-2">Already have an account?</p>
            <a href="{{ route('login') ?? '#' }}"
               class="inline-flex items-center gap-2 text-white text-sm font-semibold border border-white/25 px-4 py-2 rounded-xl hover:bg-white/10 transition-colors">
                <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                Sign In
            </a>
        </div>
    </aside>

    {{-- FORM CARD --}}
    <div class="flex-1 bg-white p-10 relative overflow-y-auto">

        {{-- Top accent bar --}}
        <div class="absolute top-0 left-8 right-8 h-[3px] bg-gradient-to-r from-teal to-light rounded-b-md"></div>

        {{-- Icon --}}
        <div class="mx-auto mb-4 w-14 h-14 flex items-center justify-center rounded-2xl bg-gradient-to-br from-teal to-light shadow-lg shadow-light/30">
            <i class="fa-solid fa-user-plus text-white text-xl"></i>
        </div>

        <h2 class="font-syne font-extrabold text-2xl text-deep text-center tracking-tight mb-1">Create Account</h2>
        <p class="text-center text-sm text-teal/60 mb-7">Fill in the details to register a new user</p>

        <form action="{{route('register.store')}}" method="post" class="space-y-4">
            @csrf

            <input type="text" name="name" placeholder="Full Name"
                class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none placeholder-[#9dbec7] focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition" />

            <input type="email" name="email" placeholder="Email"
                class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none placeholder-[#9dbec7] focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition" />

            <input type="password" name="password" placeholder="Password"
                class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none placeholder-[#9dbec7] focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition" />

            <input type="password" name="password_confirmation" placeholder="Confirm Password"
                class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none placeholder-[#9dbec7] focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition" />

            <input type="text" name="phone" placeholder="Phone"
                class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none placeholder-[#9dbec7] focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition" />

              <select id="role" name="role"
                class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none appearance-none focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition"
                onchange="toggleVillagerFields()">
                <option value="">Select Role</option>
                <!-- <option value="admin">Admin</option> -->
                <option value="repair_agent">Repair Agent</option>
                <option value="collector">Collector</option>
                <option value="villager">Villager</option>
            </select>

            <div id="villagerFields" class="space-y-4 hidden">
                <input type="text" name="cin" placeholder="CIN"
                    class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none placeholder-[#9dbec7] focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition" />

                <input type="text" name="address" placeholder="Address"
                    class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none placeholder-[#9dbec7] focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition" />

                <select name="subscription_status"
                    class="w-full bg-[#f4fafa] border border-[#d4e8ec] rounded-xl px-4 py-3 text-[0.95rem] text-deep outline-none appearance-none focus:border-mid focus:bg-white focus:ring-2 focus:ring-light/25 transition">
                    <option value="">Subscription Status</option>
                    <option value="subscribed">Subscribed</option>
                    <option value="not_subscribed">Not Subscribed</option>
                </select>
            </div>

            <div id="message" class="text-center text-sm font-medium"></div>

            <button type="submit" id="register_btn"
                class="w-full bg-gradient-to-r from-teal to-light text-white font-syne font-bold text-base py-3.5 rounded-xl shadow-lg shadow-light/30 hover:-translate-y-0.5 hover:shadow-xl hover:brightness-105 active:translate-y-0 transition-all duration-150 tracking-wide">
                Register
            </button>

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                    <li class="text-red-600 text-sm">— {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

        </form>
    </div>

</div>

    <script>
        function toggleVillagerFields() {
            const role = document.getElementById("role").value;
            const fields = document.getElementById("villagerFields");
            const isVillager = role === "villager";

            if (isVillager) {
                fields.classList.remove("hidden");
            } else {
                fields.classList.add("hidden");
            }

            const villagerInputs = document.querySelectorAll('#villagerFields input, #villagerFields select');
            villagerInputs.forEach((el) => {
                el.disabled = !isVillager;
                if (!isVillager) {
                    el.value = '';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', toggleVillagerFields);
    </script>
</body>

</html>