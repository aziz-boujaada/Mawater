<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Login') }} - MeterPro</title>
    
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

    <div class="w-full max-w-[440px] animate-in fade-in zoom-in-95 duration-500">
        
        <!-- Logo Area -->
        <div class="flex flex-col items-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-2xl shadow-emerald-500/20 mb-4">
                <i data-lucide="droplets" class="text-white w-8 h-8"></i>
            </div>
            <h1 class="font-syne font-extrabold text-white text-3xl tracking-tight">MeterPro</h1>
            <p class="text-zinc-500 text-sm mt-2">{{ __('Smart utility management system') }}</p>
        </div>

        <!-- Login Card -->
        <div class="bg-zinc-900 border border-white/5 rounded-[32px] p-8 md:p-10 shadow-2xl">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-white tracking-tight">{{ __('Welcome back') }}</h2>
                <p class="text-zinc-500 text-sm mt-1">{{ __('Please enter your details to sign in.') }}</p>
            </div>

            <form action="{{ route('login.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="text-xs font-bold text-zinc-400 uppercase tracking-widest {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('Email Address') }}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} flex items-center pointer-events-none text-zinc-500 group-focus-within:text-emerald-500 transition-colors">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            required
                            placeholder="{{ __('Enter your email address') }}"
                            class="w-full bg-zinc-800/50 border border-white/5 rounded-2xl {{ app()->getLocale() === 'ar' ? 'pr-11 pl-4' : 'pl-11 pr-4' }} py-3.5 text-white outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-zinc-600" />
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label for="password" class="text-xs font-bold text-zinc-400 uppercase tracking-widest">{{ __('Password') }}</label>
                        <a href="#" class="text-[11px] font-bold text-emerald-500 hover:text-emerald-400 transition-colors">{{ __('Forgot password?') }}</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} flex items-center pointer-events-none text-zinc-500 group-focus-within:text-emerald-500 transition-colors">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            placeholder="{{ __('Enter your password') }}"
                            class="w-full bg-zinc-800/50 border border-white/5 rounded-2xl {{ app()->getLocale() === 'ar' ? 'pr-11 pl-4' : 'pl-11 pr-4' }} py-3.5 text-white outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-zinc-600" />
                    </div>
                </div>

                @if ($errors->any())
                <div class="bg-rose-500/10 border border-rose-500/20 rounded-2xl p-4 animate-in slide-in-from-top-2">
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
                    {{ __('Sign In') }}
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-white/5 text-center text-sm text-zinc-500">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="font-bold text-white hover:text-emerald-500 transition-colors {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ __('Register now') }}</a>
            </div>
        </div>

        <p class="text-center text-zinc-600 text-[11px] mt-8 font-medium">
            &copy; {{ date('Y') }} MeterPro. {{ __('All rights reserved.') }}
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
