<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Register') }} - MeterPro</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-zinc-950 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Background Accents -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[60%] bg-emerald-500/10 blur-[120px] rounded-full"></div>
        <div class="absolute -bottom-[20%] -right-[10%] w-[50%] h-[60%] bg-emerald-600/10 blur-[120px] rounded-full"></div>
    </div>

    <div class="w-full max-w-[540px] animate-in fade-in zoom-in-95 duration-500">
        
        <!-- Logo Area -->
        <div class="flex flex-col items-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-2xl shadow-emerald-500/20 mb-4">
                <i data-lucide="droplets" class="text-white w-8 h-8"></i>
            </div>
            <h1 class="font-syne font-extrabold text-white text-3xl tracking-tight">MeterPro</h1>
            <p class="text-zinc-500 text-sm mt-2">{{ __('New user registration') }}</p>
        </div>

        <!-- Register Card -->
        <div class="bg-zinc-900 border border-white/5 rounded-[32px] p-8 md:p-10 shadow-2xl">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-white tracking-tight">{{ __('Create Account') }}</h2>
                <p class="text-zinc-500 text-sm mt-1">{{ __('Join the smart water management platform.') }}</p>
            </div>

            <form action="{{ route('register.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Full Name -->
                    <div class="space-y-2">
                        <label for="name" class="text-xs font-bold text-zinc-400 uppercase tracking-widest {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('Full Name') }}</label>
                        <input type="text" name="name" id="name" required placeholder="{{ __('Enter your full name') }}" class="w-full bg-zinc-800/50 border border-white/5 rounded-2xl px-4 py-3.5 text-white outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-zinc-600 text-sm" />
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="text-xs font-bold text-zinc-400 uppercase tracking-widest {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('Email Address') }}</label>
                        <input type="email" name="email" id="email" required placeholder="{{ __('Enter your email address') }}" class="w-full bg-zinc-800/50 border border-white/5 rounded-2xl px-4 py-3.5 text-white outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-zinc-600 text-sm" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="text-xs font-bold text-zinc-400 uppercase tracking-widest {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('Password') }}</label>
                        <input type="password" name="password" id="password" required placeholder="{{ __('Enter your password') }}" class="w-full bg-zinc-800/50 border border-white/5 rounded-2xl px-4 py-3.5 text-white outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-zinc-600 text-sm" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-xs font-bold text-zinc-400 uppercase tracking-widest {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="{{ __('Confirm your password') }}" class="w-full bg-zinc-800/50 border border-white/5 rounded-2xl px-4 py-3.5 text-white outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-zinc-600 text-sm" />
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone" class="text-xs font-bold text-zinc-400 uppercase tracking-widest {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('Phone Number') }}</label>
                        <input type="text" name="phone" id="phone" required placeholder="{{ __('Enter your phone number') }}" class="w-full bg-zinc-800/50 border border-white/5 rounded-2xl px-4 py-3.5 text-white outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-zinc-600 text-sm" />
                    </div>

                    <!-- Role -->
                    <div class="space-y-2">
                        <label for="role" class="text-xs font-bold text-zinc-400 uppercase tracking-widest {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('Select Role') }}</label>
                        <select id="role" name="role" required class="w-full bg-zinc-800/50 border border-white/5 rounded-2xl px-4 py-3.5 text-white outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all appearance-none cursor-pointer text-sm" onchange="toggleVillagerFields()">
                            <option value="">{{ __('Select Role') }}</option>
                            <option value="repair_agent">{{ __('Repair Agent') }}</option>
                            <option value="collector">{{ __('Collector') }}</option>
                            <option value="villager">{{ __('Villager') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Villager Fields (Conditional) -->
                <div id="villagerFields" class="space-y-5 hidden pt-4 border-t border-white/5 animate-in slide-in-from-top-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label for="cin" class="text-xs font-bold text-zinc-400 uppercase tracking-widest {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('CIN') }}</label>
                            <input type="text" name="cin" id="cin" placeholder="{{ __('Enter your CIN') }}" class="w-full bg-zinc-800/50 border border-white/5 rounded-2xl px-4 py-3.5 text-white outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-zinc-600 text-sm" />
                        </div>
                        <div class="space-y-2">
                            <label for="address" class="text-xs font-bold text-zinc-400 uppercase tracking-widest {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('Address') }}</label>
                            <input type="text" name="address" id="address" placeholder="{{ __('Enter your address') }}" class="w-full bg-zinc-800/50 border border-white/5 rounded-2xl px-4 py-3.5 text-white outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-zinc-600 text-sm" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="subscription_status" class="text-xs font-bold text-zinc-400 uppercase tracking-widest {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('Subscription') }}</label>
                        <select name="subscription_status" id="subscription_status" class="w-full bg-zinc-800/50 border border-white/5 rounded-2xl px-4 py-3.5 text-white outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all appearance-none cursor-pointer text-sm">
                            <option value="subscribed">{{ __('Subscribed') }}</option>
                            <option value="not_subscribed">{{ __('Not Subscribed') }}</option>
                        </select>
                    </div>
                </div>

                @if ($errors->any())
                <div class="bg-rose-500/10 border border-rose-500/20 rounded-2xl p-4">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                        <li class="text-rose-400 text-xs font-medium flex items-center gap-2">
                            <i data-lucide="alert-circle" class="w-3 h-3"></i>
                            {{ $error }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <button
                    type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-syne font-bold py-4 rounded-2xl shadow-xl shadow-emerald-600/20 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 tracking-wide mt-2">
                    {{ __('Create Account') }}
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-white/5 text-center text-sm text-zinc-500">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}" class="font-bold text-white hover:text-emerald-500 transition-colors {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('Sign In') }}</a>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

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
    </script>
</body>
</html>
