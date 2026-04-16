<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ayt Daoud — Water Billing Management</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Simple clean font: Plus Jakarta Sans -->
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
                    animation: {
                        'fade-up':   'fadeUp .7s ease both',
                        'fade-down': 'fadeDown .6s ease both',
                        'pulse-ring':'pulseRing 3s ease-in-out infinite',
                        'wave1':     'waveMove 9s linear infinite',
                        'wave2':     'waveMove 14s linear infinite reverse',
                        'drop':      'dropFloat linear infinite',
                    },
                    keyframes: {
                        fadeUp:    { from:{ opacity:0, transform:'translateY(24px)' }, to:{ opacity:1, transform:'translateY(0)' } },
                        fadeDown:  { from:{ opacity:0, transform:'translateY(-16px)' }, to:{ opacity:1, transform:'translateY(0)' } },
                        pulseRing: { '0%,100%':{ boxShadow:'0 0 0 3px rgba(59,193,168,.3)' }, '50%':{ boxShadow:'0 0 0 7px rgba(59,193,168,.07)' } },
                        waveMove:  { from:{ transform:'translateX(0)' }, to:{ transform:'translateX(-10%)' } },
                        dropFloat: { '0%':{ transform:'translateY(110vh)', opacity:0 }, '8%':{ opacity:.45 }, '92%':{ opacity:.3 }, '100%':{ transform:'translateY(-40px)', opacity:0 } },
                    },
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* background mesh */
        .bg-mesh {
            background:
                radial-gradient(ellipse 70% 55% at 15% 10%, rgba(59,193,168,.11) 0%, transparent 60%),
                radial-gradient(ellipse 55% 70% at 85% 90%, rgba(12,119,121,.09) 0%, transparent 55%),
                #F0FAFA;
        }

        /* gradient text */
        .grad-text {
            background: linear-gradient(135deg, #249E94, #3BC1A8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* animated drops */
        .drop { position:absolute; border-radius:50% 50% 50% 50% / 60% 60% 40% 40%; background:linear-gradient(180deg,rgba(59,193,168,.45),rgba(12,119,121,.2)); animation:dropFloat linear infinite; }

        /* card top-bar reveal */
        .feature-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#249E94,#3BC1A8); transform:scaleX(0); transform-origin:left; transition:transform .3s; border-radius:4px 4px 0 0; }
        .feature-card:hover::before { transform:scaleX(1); }

        /* step connector */
        .steps-row::before { content:''; position:absolute; top:38px; left:14%; right:14%; height:1px; background:linear-gradient(90deg,transparent,rgba(59,193,168,.35),transparent); }

        @keyframes dropFloat {
            0%   { transform:translateY(110vh); opacity:0; }
            8%   { opacity:.45; }
            92%  { opacity:.3; }
            100% { transform:translateY(-40px); opacity:0; }
        }
        @keyframes waveMove {
            from { transform:translateX(0); }
            to   { transform:translateX(-10%); }
        }
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(24px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes fadeDown {
            from { opacity:0; transform:translateY(-16px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes pulseRing {
            0%,100% { box-shadow:0 0 0 3px rgba(59,193,168,.3); }
            50%     { box-shadow:0 0 0 7px rgba(59,193,168,.07); }
        }

        .anim-fade-up  { animation:fadeUp  .7s ease both; }
        .anim-delay-1  { animation-delay:.15s; }
        .anim-delay-2  { animation-delay:.3s; }
        .anim-delay-3  { animation-delay:.45s; }
        .anim-delay-4  { animation-delay:.6s; }
        .logo-pulse    { animation:pulseRing 3s ease-in-out infinite; }
    </style>
</head>

<body class="bg-mesh text-[#0a2a2f] overflow-x-hidden min-h-screen">

    {{-- ───── NAVBAR ───── --}}
    <nav class="fixed top-0 inset-x-0 z-50 flex items-center justify-between px-6 lg:px-10 h-[70px]"
         style="background:rgba(0,84,97,.92);backdrop-filter:blur(18px);border-bottom:1px solid rgba(59,193,168,.18);">

        {{-- Brand --}}
        <a href="#" class="flex items-center gap-3 no-underline">
            <div class="logo-pulse w-10 h-10 rounded-full flex items-center justify-center text-lg font-bold text-white"
                 style="background:linear-gradient(135deg,#3BC1A8,#249E94);">💧</div>
            <div>
                <p class="text-white font-bold text-[15px] leading-tight">Ayt Daoud</p>
                <p class="text-[#3BC1A8] text-[10px] font-medium tracking-widest uppercase">Water Billing System</p>
            </div>
        </a>

        {{-- Links --}}
        <ul class="hidden md:flex items-center gap-1 list-none">
            <li><a href="#features" class="text-white/70 hover:text-white hover:bg-white/10 text-sm font-medium px-4 py-2 rounded-lg transition-all">Features</a></li>
            <li><a href="#how"      class="text-white/70 hover:text-white hover:bg-white/10 text-sm font-medium px-4 py-2 rounded-lg transition-all">How It Works</a></li>
            <li><a href="#contact"  class="text-white/70 hover:text-white hover:bg-white/10 text-sm font-medium px-4 py-2 rounded-lg transition-all">Contact</a></li>
           @php $role = Auth::user()->role @endphp
            @if (Route::has('login'))
                @auth
                    <li>
                        <a href="{{ url($role .'/dashboard')}}"
                           class="ml-2 text-sm font-semibold text-white px-5 py-2 rounded-lg transition-all hover:-translate-y-px"
                           style="background:linear-gradient(135deg,#249E94,#3BC1A8);box-shadow:0 2px 14px rgba(59,193,168,.4);">
                            Dashboard
                        </a>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="text-white/70 hover:text-white hover:bg-white/10 text-sm font-medium px-4 py-2 rounded-lg transition-all">Log in</a></li>
                    @if (Route::has('register'))
                        <li>
                            <a href="{{ route('register') }}"
                               class="ml-2 text-sm font-semibold text-white px-5 py-2 rounded-lg transition-all hover:-translate-y-px"
                               style="background:linear-gradient(135deg,#249E94,#3BC1A8);box-shadow:0 2px 14px rgba(59,193,168,.4);">
                                Register
                            </a>
                        </li>
                    @endif
                @endauth
            @endif
        </ul>
    </nav>

    {{-- ───── HERO ───── --}}
    <section class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden px-4 pt-28 pb-20">

        {{-- Floating drops --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="drop absolute" style="left:8%;  width:6px; height:9px;  animation-duration:9s;  animation-delay:0s;"></div>
            <div class="drop absolute" style="left:21%; width:5px; height:7px;  animation-duration:13s; animation-delay:2s;"></div>
            <div class="drop absolute" style="left:38%; width:7px; height:11px; animation-duration:8s;  animation-delay:.8s;"></div>
            <div class="drop absolute" style="left:55%; width:5px; height:8px;  animation-duration:15s; animation-delay:3s;"></div>
            <div class="drop absolute" style="left:70%; width:8px; height:12px; animation-duration:10s; animation-delay:.4s;"></div>
            <div class="drop absolute" style="left:84%; width:5px; height:7px;  animation-duration:11s; animation-delay:4s;"></div>
            <div class="drop absolute" style="left:93%; width:6px; height:9px;  animation-duration:14s; animation-delay:1.5s;"></div>
        </div>

        {{-- Hero content --}}
        <div class="relative z-10 text-center max-w-3xl mx-auto">

            {{-- Badge --}}
            <span class="anim-fade-up inline-flex items-center gap-2 text-[11px] font-semibold tracking-widest uppercase px-4 py-1.5 rounded-full mb-8"
                  style="background:rgba(59,193,168,.12);border:1px solid rgba(59,193,168,.32);color:#249E94;">
                💧 &nbsp; Certified Community Association
            </span>

            {{-- Title --}}
            <h1 class="anim-fade-up anim-delay-1 font-extrabold leading-[1.1] mb-5"
                style="font-size:clamp(2.5rem,6vw,4.2rem);color:#005461;">
                Manage <span class="grad-text">Water Billing</span><br>
                Simply &amp; Transparently
            </h1>

            {{-- Sub --}}
            <p class="anim-fade-up anim-delay-2 text-[#4a7a82] text-lg leading-relaxed max-w-xl mx-auto mb-10">
                Ayt Daoud Association — a digital platform to track water consumption,
                generate invoices, and manage payments for all subscribers with ease.
            </p>

            {{-- CTA --}}
            <div class="anim-fade-up anim-delay-3 flex flex-wrap items-center justify-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center gap-2 text-white font-semibold text-sm px-6 py-3 rounded-xl transition-all hover:-translate-y-1"
                           style="background:linear-gradient(135deg,#005461,#0C7779);box-shadow:0 4px 20px rgba(0,84,97,.35);">
                            ⚡ Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 text-white font-semibold text-sm px-6 py-3 rounded-xl transition-all hover:-translate-y-1"
                           style="background:linear-gradient(135deg,#005461,#0C7779);box-shadow:0 4px 20px rgba(0,84,97,.35);">
                            🔐 Log In
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-2 text-deep font-semibold text-sm px-6 py-3 rounded-xl transition-all hover:-translate-y-1"
                               style="background:rgba(59,193,168,.1);border:1.5px solid rgba(59,193,168,.4);color:#005461;">
                                ✨ Create Account
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>

        {{-- Stats --}}
        <div class="anim-fade-up anim-delay-4 relative z-10 mt-14 flex flex-wrap items-center justify-center gap-3">
            @foreach([['250+','Active Members'],['100%','Transparent Billing'],['24/7','Always Available'],['0 Paper','Fully Digital']] as $s)
            <div class="text-center px-6 py-4 rounded-2xl min-w-[120px] transition-transform hover:-translate-y-1"
                 style="background:rgba(255,255,255,.8);backdrop-filter:blur(14px);border:1px solid rgba(59,193,168,.2);">
                <p class="grad-text font-extrabold text-3xl leading-none">{{ $s[0] }}</p>
                <p class="text-[#4a7a82] text-[11px] font-semibold tracking-wider uppercase mt-1">{{ $s[1] }}</p>
            </div>
            @endforeach
        </div>

        {{-- SVG waves --}}
        <div class="absolute bottom-0 inset-x-0 h-36 overflow-hidden pointer-events-none">
            <div class="absolute bottom-0 w-[120%] -left-[10%] h-full" style="animation:waveMove 9s linear infinite;opacity:.4;">
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="w-full h-full">
                    <path d="M0,60 C240,100 480,20 720,60 C960,100 1200,20 1440,60 L1440,120 L0,120 Z" fill="rgba(0,84,97,0.07)"/>
                </svg>
            </div>
            <div class="absolute bottom-0 w-[120%] -left-[10%] h-full" style="animation:waveMove 14s linear infinite reverse;opacity:.25;">
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="w-full h-full">
                    <path d="M0,80 C360,40 720,110 1080,50 C1260,20 1380,70 1440,80 L1440,120 L0,120 Z" fill="rgba(59,193,168,0.06)"/>
                </svg>
            </div>
        </div>
    </section>

    {{-- ───── FEATURES ───── --}}
    <section id="features" class="relative z-10 py-24 px-4">
        <div class="text-center mb-14">
            <span class="inline-block text-[11px] font-bold tracking-[.14em] uppercase px-3 py-1 rounded-full mb-3"
                  style="background:rgba(36,158,148,.1);color:#249E94;">What We Offer</span>
            <h2 class="font-extrabold text-[#005461]" style="font-size:clamp(1.8rem,3.5vw,2.5rem);">
                Everything you need in one place
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 max-w-5xl mx-auto">
            @foreach([
                ['📋','Invoice Generation',   'Automatically create and send water bills for each subscriber based on their actual recorded consumption.'],
                ['📊','Consumption Tracking', 'Visual monthly consumption charts with comparisons and trend analysis for every subscriber account.'],
                ['💳','Payment Management',   'Track payment status per subscriber with automatic reminders for overdue accounts.'],
                ['👥','Subscriber Database',  'A complete registry of all members with account details, meter numbers, and contact information.'],
                ['📅','Transaction History',  'Full archive of all financial operations and invoices, searchable across any time period.'],
                ['📈','Financial Reports',    'Periodic reports covering revenue, outstanding balances, and consumption metrics.'],
            ] as $f)
            <div class="feature-card relative bg-white rounded-2xl p-7 overflow-hidden transition-all duration-300 hover:-translate-y-1.5"
                 style="border:1px solid rgba(59,193,168,.14);box-shadow:0 1px 4px rgba(0,84,97,.05);">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5"
                     style="background:rgba(59,193,168,.12);border:1px solid rgba(59,193,168,.18);">
                    {{ $f[0] }}
                </div>
                <h3 class="font-bold text-[#005461] text-base mb-2">{{ $f[1] }}</h3>
                <p class="text-[#4a7a82] text-sm leading-relaxed">{{ $f[2] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ───── HOW IT WORKS ───── --}}
    <section id="how" class="relative py-24 px-4 overflow-hidden"
             style="background:linear-gradient(145deg,#005461 0%,#0C7779 100%);">

        {{-- Decorative circles --}}
        <div class="absolute -top-40 -right-20 w-[480px] h-[480px] rounded-full pointer-events-none"
             style="background:rgba(59,193,168,.07);"></div>
        <div class="absolute -bottom-32 -left-16 w-[340px] h-[340px] rounded-full pointer-events-none"
             style="background:rgba(0,84,97,.18);"></div>

        <div class="relative z-10">
            <div class="text-center mb-14">
                <span class="inline-block text-[11px] font-bold tracking-[.14em] uppercase px-3 py-1 rounded-full mb-3"
                      style="background:rgba(59,193,168,.18);color:#3BC1A8;">The Process</span>
                <h2 class="font-extrabold text-white" style="font-size:clamp(1.8rem,3.5vw,2.5rem);">
                    Simple, fast &amp; transparent
                </h2>
            </div>

            <div class="steps-row relative flex flex-col md:flex-row max-w-4xl mx-auto gap-10 md:gap-0">
                @foreach([
                    ['1','Read the Meter',    'Record the monthly water meter reading for each subscriber'],
                    ['2','Calculate the Bill','Automatically compute the amount based on the approved tariff'],
                    ['3','Send the Invoice',  'Notify the subscriber of the amount due for the billing period'],
                    ['4','Record Payment',    'Confirm payment and instantly update the subscriber\'s record'],
                ] as $step)
                <div class="flex-1 text-center px-4 relative z-10 group">
                    <div class="w-20 h-20 rounded-full mx-auto mb-5 flex items-center justify-center font-extrabold text-3xl transition-all duration-300 group-hover:scale-105"
                         style="background:rgba(255,255,255,.08);border:1.5px solid rgba(59,193,168,.38);color:#3BC1A8;backdrop-filter:blur(6px);">
                        {{ $step[0] }}
                    </div>
                    <h3 class="text-white font-bold text-sm mb-2">{{ $step[1] }}</h3>
                    <p class="text-white/55 text-xs leading-relaxed">{{ $step[2] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ───── BOTTOM CTA ───── --}}
    <section id="contact" class="py-24 px-4 text-center">
        <div class="max-w-xl mx-auto bg-white rounded-3xl p-12 relative overflow-hidden"
             style="border:1px solid rgba(59,193,168,.16);box-shadow:0 20px 60px rgba(0,84,97,.08);">

            {{-- Rainbow top bar --}}
            <div class="absolute top-0 inset-x-0 h-1 rounded-t-3xl"
                 style="background:linear-gradient(90deg,#005461,#0C7779,#249E94,#3BC1A8);"></div>

            <div class="text-5xl mb-5">💧</div>
            <h2 class="font-extrabold text-[#005461] text-2xl mb-3">Join Ayt Daoud Association</h2>
            <p class="text-[#4a7a82] text-sm leading-relaxed mb-8 max-w-sm mx-auto">
                Register now to access the digital management system and track your water bills with ease and full transparency.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center gap-2 text-white font-semibold text-sm px-6 py-3 rounded-xl transition-all hover:-translate-y-1"
                           style="background:linear-gradient(135deg,#005461,#0C7779);box-shadow:0 4px 20px rgba(0,84,97,.3);">
                            Go to Dashboard &rarr;
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 text-white font-semibold text-sm px-6 py-3 rounded-xl transition-all hover:-translate-y-1"
                           style="background:linear-gradient(135deg,#005461,#0C7779);box-shadow:0 4px 20px rgba(0,84,97,.3);">
                            Log In &rarr;
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-2 font-semibold text-sm px-6 py-3 rounded-xl transition-all hover:-translate-y-1"
                               style="background:rgba(59,193,168,.1);border:1.5px solid rgba(59,193,168,.38);color:#005461;">
                                Create an Account
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </section>

    {{-- ───── FOOTER ───── --}}
    <footer class="py-6 text-center text-xs tracking-wide" style="background:#005461;color:rgba(255,255,255,.45);">
        &copy; {{ date('Y') }}
        <strong class="text-[#3BC1A8] font-semibold">Ayt Daoud Association</strong>
        &mdash; All rights reserved &middot; Water Billing Management System
    </footer>

</body>
</html>