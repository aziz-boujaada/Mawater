<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Unauthorized | Ayt Daoud</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        deep:   '#005461',
                        mid:    '#0C7779',
                        accent: '#249E94',
                        teal:   '#3BC1A8',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .bg-mesh {
            background:
                radial-gradient(ellipse 70% 55% at 15% 10%, rgba(59,193,168,.1) 0%, transparent 60%),
                radial-gradient(ellipse 55% 70% at 85% 90%, rgba(12,119,121,.08) 0%, transparent 55%),
                #F0FAFA;
        }

        .grad-text {
            background: linear-gradient(135deg, #249E94, #3BC1A8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

       

 
    </style>
</head>

<body class="bg-mesh min-h-screen flex flex-col">

    {{-- ───── HEADER ───── --}}
    <header class="w-full"
            style="background:rgba(0,84,97,.92);backdrop-filter:blur(18px);border-bottom:1px solid rgba(59,193,168,.18);">
        <div class="max-w-6xl mx-auto px-6 lg:px-10 h-[70px] flex items-center justify-between">

            {{-- Brand --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
                <div class="logo-pulse w-10 h-10 rounded-full flex items-center justify-center text-lg text-white font-bold"
                     style="background:linear-gradient(135deg,#3BC1A8,#249E94);">💧</div>
                <div>
                    <p class="text-white font-bold text-[15px] leading-tight">Ayt Daoud</p>
                    <p class="text-[#3BC1A8] text-[10px] font-medium tracking-widest uppercase">Water Billing System</p>
                </div>
            </a>

            {{-- Nav links --}}
            <div class="hidden md:flex items-center gap-1">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard/collector') }}"
                           class="text-sm font-semibold text-white px-5 py-2 rounded-lg transition-all hover:-translate-y-px"
                           style="background:linear-gradient(135deg,#249E94,#3BC1A8);box-shadow:0 2px 14px rgba(59,193,168,.4);">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-white/70 hover:text-white hover:bg-white/10 text-sm font-medium px-4 py-2 rounded-lg transition-all">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="ml-1 text-sm font-semibold text-white px-5 py-2 rounded-lg transition-all hover:-translate-y-px"
                               style="background:linear-gradient(135deg,#249E94,#3BC1A8);box-shadow:0 2px 14px rgba(59,193,168,.4);">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    {{-- ───── MAIN CONTENT ───── --}}
    <main class="flex-1 flex items-center justify-center px-4 py-16">
        <div class="text-center max-w-md w-full">

            {{-- Lock icon with ripple rings --}}
            <div class="anim-1 relative w-32 h-32 mx-auto mb-8">
               
                <div class="relative z-10 w-full h-full rounded-full flex items-center justify-center"
                     style="background:linear-gradient(135deg,rgba(59,193,168,.15),rgba(36,158,148,.08));border:2px solid rgba(59,193,168,.3);">
                    <span class="lock-icon text-5xl select-none">🔒</span>
                </div>
            </div>

            {{-- 403 badge --}}
            <div class="anim-2">
                <span class="inline-block text-[11px] font-bold tracking-[.14em] uppercase px-3 py-1 rounded-full mb-4"
                      style="background:rgba(36,158,148,.1);color:#249E94;border:1px solid rgba(59,193,168,.25);">
                    Error 403
                </span>
            </div>

            {{-- Title --}}
            <h1 class="anim-2 font-extrabold text-4xl text-[#005461] mb-3">
                Access <span class="grad-text">Denied</span>
            </h1>

            {{-- Message --}}
            <p class="anim-3 text-[#4a7a82] text-base leading-relaxed mb-8 max-w-sm mx-auto">
                You don't have permission to view this page.
                Please contact your administrator or go back to a safe page.
            </p>

            {{-- Divider --}}
            <div class="anim-3 w-16 h-px mx-auto mb-8" style="background:linear-gradient(90deg,transparent,rgba(59,193,168,.4),transparent);"></div>

            {{-- Buttons --}}
            <div class="anim-4 flex flex-wrap items-center justify-center gap-3">

                {{-- Go Back --}}
                <button onclick="history.back()"
                        class="inline-flex items-center gap-2 text-white font-semibold text-sm px-6 py-3 rounded-xl cursor-pointer transition-all hover:-translate-y-1 border-0"
                        style="background:linear-gradient(135deg,#005461,#0C7779);box-shadow:0 4px 20px rgba(0,84,97,.3);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    Go Back
                </button>

                {{-- Home --}}
                <a href="{{ url('/') }}"
                   class="inline-flex items-center gap-2 font-semibold text-sm px-6 py-3 rounded-xl transition-all hover:-translate-y-1"
                   style="background:rgba(59,193,168,.1);border:1.5px solid rgba(59,193,168,.35);color:#005461;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                    Home
                </a>
            </div>

            {{-- Support hint --}}
            <p class="anim-4 mt-8 text-[#4a7a82] text-xs">
                Need access?
                <a href="mailto:contact@aytdaoud.ma" class="underline underline-offset-2 hover:text-[#249E94] transition-colors">
                    Contact support
                </a>
            </p>

        </div>
    </main>

    {{-- ───── FOOTER ───── --}}
    <footer class="py-5 text-center text-xs tracking-wide" style="background:#005461;color:rgba(255,255,255,.4);">
        &copy; {{ date('Y') }}
        <strong class="text-[#3BC1A8] font-semibold">Ayt Daoud Association</strong>
        &mdash; Water Billing Management System
    </footer>

</body>
</html>