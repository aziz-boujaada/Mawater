<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Page Not Found | Ayt Daoud</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        deep: '#005461',
                        mid: '#0C7779',
                        accent: '#249E94',
                        teal: '#3BC1A8',
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

    {{-- HEADER --}}
    <header class="w-full"
        style="background:rgba(0,84,97,.92);backdrop-filter:blur(18px);border-bottom:1px solid rgba(59,193,168,.18);">
        <div class="max-w-6xl mx-auto px-6 lg:px-10 h-[70px] flex items-center justify-between">

            <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg text-white font-bold"
                    style="background:linear-gradient(135deg,#3BC1A8,#249E94);">💧</div>
                <div>
                    <p class="text-white font-bold text-[15px] leading-tight">Ayt Daoud</p>
                    <p class="text-[#3BC1A8] text-[10px] font-medium tracking-widest uppercase">
                        Water Billing System
                    </p>
                </div>
            </a>

            <a href="{{ url('/') }}"
                class="text-sm font-semibold text-white px-5 py-2 rounded-lg transition-all hover:-translate-y-px"
                style="background:linear-gradient(135deg,#249E94,#3BC1A8);box-shadow:0 2px 14px rgba(59,193,168,.4);">
                Home
            </a>
        </div>
    </header>

    {{-- MAIN --}}
    <main class="flex-1 flex items-center justify-center px-4 py-16">
        <div class="text-center max-w-md w-full">

            {{-- Icon --}}
            <div class="relative w-32 h-32 mx-auto mb-8">
                <div class="relative z-10 w-full h-full rounded-full flex items-center justify-center"
                    style="background:linear-gradient(135deg,rgba(59,193,168,.15),rgba(36,158,148,.08));border:2px solid rgba(59,193,168,.3);">
                    <span class="text-5xl select-none">🔍</span>
                </div>
            </div>

            {{-- Badge --}}
            <span class="inline-block text-[11px] font-bold tracking-[.14em] uppercase px-3 py-1 rounded-full mb-4"
                style="background:rgba(36,158,148,.1);color:#249E94;border:1px solid rgba(59,193,168,.25);">
                Error 404
            </span>

            {{-- Title --}}
            <h1 class="font-extrabold text-4xl text-[#005461] mb-3">
                Page <span class="grad-text">Not Found</span>
            </h1>

            {{-- Message --}}
            <p class="text-[#4a7a82] text-base leading-relaxed mb-8 max-w-sm mx-auto">
                The page you're looking for doesn’t exist or may have been moved.
                Please check the URL or return to the homepage.
            </p>

            {{-- Divider --}}
            <div class="w-16 h-px mx-auto mb-8"
                style="background:linear-gradient(90deg,transparent,rgba(59,193,168,.4),transparent);"></div>

            {{-- Buttons --}}
            <div class="flex flex-wrap items-center justify-center gap-3">

                <button onclick="history.back()"
                    class="inline-flex items-center gap-2 text-white font-semibold text-sm px-6 py-3 rounded-xl cursor-pointer transition-all hover:-translate-y-1 border-0"
                    style="background:linear-gradient(135deg,#005461,#0C7779);box-shadow:0 4px 20px rgba(0,84,97,.3);">
                    ← Go Back
                </button>

                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 font-semibold text-sm px-6 py-3 rounded-xl transition-all hover:-translate-y-1"
                    style="background:rgba(59,193,168,.1);border:1.5px solid rgba(59,193,168,.35);color:#005461;">
                    🏠 Home
                </a>
            </div>

            <p class="mt-8 text-[#4a7a82] text-xs">
                Lost?
                <a href="{{ url('/') }}" class="underline underline-offset-2 hover:text-[#249E94] transition-colors">
                    Return safely to home page
                </a>
            </p>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="py-5 text-center text-xs tracking-wide"
        style="background:#005461;color:rgba(255,255,255,.4);">
        &copy; {{ date('Y') }}
        <strong class="text-[#3BC1A8] font-semibold">Ayt Daoud Association</strong>
        &mdash; Water Billing Management System
    </footer>

</body>
</html>