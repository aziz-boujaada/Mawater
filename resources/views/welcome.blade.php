<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Ait Daoud') }} — {{ __('Smart Water Management') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10b981',
                        'primary-hover': '#059669',
                        surface: '#fafafa',
                        heritage: '#005461',
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                        syne: ['Syne', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="font-sans antialiased bg-zinc-50 text-zinc-900 overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-md border-b border-zinc-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                        <i data-lucide="droplets" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="font-syne font-bold text-xl text-zinc-900 tracking-tight block leading-none">{{ __('Ait Daoud') }}</span>
                        <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-[0.2em] mt-1 block">{{ __('Association Rural') }}</span>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center gap-8">
                    <a href="#vision" class="text-sm font-semibold text-zinc-500 hover:text-emerald-600 transition-colors">{{ __('Notre Vision') }}</a>
                    <a href="#impact" class="text-sm font-semibold text-zinc-500 hover:text-emerald-600 transition-colors">{{ __('Impact Local') }}</a>
                    <a href="#contact" class="text-sm font-semibold text-zinc-500 hover:text-emerald-600 transition-colors">{{ __('Contact') }}</a>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Language Selector in Navbar -->
                    <div class="relative group mr-2">
                        <button class="flex items-center gap-2 bg-zinc-100 border border-zinc-200 rounded-xl px-3 py-1.5 text-xs font-bold text-zinc-600 hover:bg-zinc-200 transition-colors">
                            <i data-lucide="languages" class="w-4 h-4"></i>
                            <span class="uppercase">{{ app()->getLocale() }}</span>
                        </button>
                        <div class="absolute right-0 top-full mt-2 w-32 bg-white border border-zinc-200 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 overflow-hidden">
                            <a href="{{ route('lang.switch', 'ar') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-zinc-600 hover:bg-zinc-50 hover:text-emerald-600 transition-colors">
                                <span class="w-5 text-center">🇲🇦</span> {{ __('Arabic') }}
                            </a>
                            <a href="{{ route('lang.switch', 'fr') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-zinc-600 hover:bg-zinc-50 hover:text-emerald-600 transition-colors border-t border-zinc-100">
                                <span class="w-5 text-center">🇫🇷</span> {{ __('French') }}
                            </a>
                            <a href="{{ route('lang.switch', 'en') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-zinc-600 hover:bg-zinc-50 hover:text-emerald-600 transition-colors border-t border-zinc-100">
                                <span class="w-5 text-center">🇺🇸</span> {{ __('English') }}
                            </a>
                        </div>
                    </div>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:bg-emerald-700 transition-all shadow-sm">
                                {{ __('Dashboard') }}
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-zinc-600 hover:text-zinc-900 transition-colors px-4">{{ __('Connexion') }}</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-zinc-900 text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:bg-zinc-800 transition-all shadow-sm">
                                {{ __('Inscription') }}
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-56 lg:pb-40 overflow-hidden">
        <!-- Background Accents -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10">
            <div class="absolute top-[-15%] left-[-5%] w-[60%] h-[70%] bg-emerald-500/5 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-[-15%] right-[-5%] w-[60%] h-[70%] bg-zinc-500/5 blur-[120px] rounded-full"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-[11px] font-bold uppercase tracking-widest mb-10 animate-in fade-in slide-in-from-top-4 duration-500">
                <i data-lucide="shield-check" class="w-3 h-3"></i>
                {{ __('Official Water Management System') }} — {{ __('Douar Ait Daoud') }}
            </div>
            
            <h1 class="font-syne font-extrabold text-5xl md:text-7xl lg:text-8xl text-zinc-900 tracking-tight leading-[0.95] mb-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
                {{ __("L'avenir de l'eau") }}<br/>
                <span class="text-emerald-600">{{ __("dans notre Douar.") }}</span>
            </h1>
            
            <p class="max-w-2xl mx-auto text-zinc-500 text-lg md:text-xl leading-relaxed mb-16 animate-in fade-in slide-in-from-bottom-8 duration-700">
                {{ __("L'Association Ait Daoud s'engage pour une gestion transparente et équitable des ressources hydrauliques au profit de notre communauté rurale.") }}
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-5 animate-in fade-in slide-in-from-bottom-12 duration-700">
                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-emerald-600 text-white font-bold px-10 py-5 rounded-2xl hover:bg-emerald-700 hover:-translate-y-1 transition-all shadow-2xl shadow-emerald-500/20 text-lg">
                    {{ __("Rejoindre l'Espace Membre") }}
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
                <a href="#impact" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-white text-zinc-600 border border-zinc-200 font-bold px-10 py-5 rounded-2xl hover:bg-zinc-50 transition-all text-lg">
                    {{ __("En savoir plus") }}
                </a>
            </div>

            <!-- Rural Context Metrics -->
            <div class="mt-32 grid grid-cols-1 md:grid-cols-3 gap-12 text-left max-w-5xl mx-auto animate-in fade-in duration-1000">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-emerald-500/5 rounded-[40px] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-white border border-zinc-100 shadow-sm flex items-center justify-center mb-6">
                            <i data-lucide="users" class="w-6 h-6 text-emerald-600"></i>
                        </div>
                        <h3 class="font-syne font-bold text-xl text-zinc-900 mb-2">{{ __('Communauté Unie') }}</h3>
                        <p class="text-zinc-500 text-sm leading-relaxed">{{ __("Une plateforme conçue par et pour les habitants de Ait Daoud, favorisant l'entraide et la clarté.") }}</p>
                    </div>
                </div>

                <div class="relative group">
                    <div class="absolute -inset-4 bg-emerald-500/5 rounded-[40px] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-white border border-zinc-100 shadow-sm flex items-center justify-center mb-6">
                            <i data-lucide="search" class="w-6 h-6 text-emerald-600"></i>
                        </div>
                        <h3 class="font-syne font-bold text-xl text-zinc-900 mb-2">{{ __('Transparence Totale') }}</h3>
                        <p class="text-zinc-500 text-sm leading-relaxed">{{ __("Suivi en temps réel de votre consumption et facturation équitable sans aucune zone d'ombre.") }}</p>
                    </div>
                </div>

                <div class="relative group">
                    <div class="absolute -inset-4 bg-emerald-500/5 rounded-[40px] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-white border border-zinc-100 shadow-sm flex items-center justify-center mb-6">
                            <i data-lucide="leaf" class="w-6 h-6 text-emerald-600"></i>
                        </div>
                        <h3 class="font-syne font-bold text-xl text-zinc-900 mb-2">{{ __('Impact Rural') }}</h3>
                        <p class="text-zinc-500 text-sm leading-relaxed">{{ __("Modernisation de nos infrastructures pour préserver chaque goutte d'eau de notre terre.") }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section: Identity -->
    <section id="impact" class="py-32 bg-white border-y border-zinc-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="relative">
                    <div class="aspect-[4/5] rounded-[48px] bg-zinc-100 overflow-hidden shadow-2xl relative">
                        <!-- Placeholder for local community image -->
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/20 to-zinc-900/40 mix-blend-overlay"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i data-lucide="image" class="w-20 h-20 text-white opacity-20"></i>
                        </div>
                        
                        <!-- Overlay Card -->
                        <div class="absolute bottom-8 left-8 right-8 p-8 bg-white/90 backdrop-blur-xl rounded-[32px] shadow-2xl">
                            <p class="text-zinc-900 font-syne font-bold text-xl mb-1">{{ __('Ait Daoud Solidaire') }}</p>
                            <p class="text-zinc-500 text-sm">{{ __('Protéger nos ressources pour les générations futures.') }}</p>
                        </div>
                    </div>
                    <!-- Decorative Element -->
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-emerald-600 rounded-[40px] -z-10 rotate-12 blur-2xl opacity-20"></div>
                </div>

                <div class="space-y-10">
                    <div>
                        <h2 class="font-syne font-bold text-4xl md:text-5xl text-zinc-900 leading-tight mb-6">{{ __('Un engagement pour le Douar.') }}</h2>
                        <p class="text-zinc-500 text-lg leading-relaxed">
                            {{ __("L'Association Ait Daoud modernise ses services. Notre nouvelle plateforme numérique permet une gestion plus fluide, réduisant les erreurs de facturation et assurant la pérennité de notre réseau d'eau potable.") }}
                        </p>
                    </div>

                    <div class="space-y-6">
                        <div class="flex gap-5">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center shrink-0">
                                <i data-lucide="check" class="w-5 h-5 text-emerald-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-zinc-900">{{ __('Relevés Digitalisés') }}</h4>
                                <p class="text-sm text-zinc-500">{{ __("Fin des relevés manuels imprécis. Tout est enregistré numériquement.") }}</p>
                            </div>
                        </div>
                        <div class="flex gap-5">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center shrink-0">
                                <i data-lucide="check" class="w-5 h-5 text-emerald-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-zinc-900">{{ __('Paiement Simplifié') }}</h4>
                                <p class="text-sm text-zinc-500">{{ __("Un suivi clair de vos paiements et de vos factures impayées.") }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-6">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-emerald-600 font-bold hover:gap-4 transition-all group">
                            {{ __('Consulter mon compte') }}
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-zinc-950 text-white pt-24 pb-12 overflow-hidden relative">
        <!-- Background Glow -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full h-[500px] bg-emerald-500/5 blur-[120px] rounded-full -z-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-16 mb-20">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center">
                            <i data-lucide="droplets" class="w-6 h-6"></i>
                        </div>
                        <span class="font-syne font-bold text-2xl tracking-tight">{{ __('Ait Daoud') }}</span>
                    </div>
                    <p class="text-zinc-500 text-lg max-w-sm leading-relaxed">
                        {{ __("Agir ensemble pour la préservation de l'eau et le développement durable de notre région.") }}
                    </p>
                </div>
                
                <div>
                    <h5 class="font-syne font-bold text-white mb-6 uppercase tracking-widest text-[10px]">{{ __('Association') }}</h5>
                    <ul class="space-y-4 text-zinc-500 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('Our Office') }}</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('Vision 2026') }}</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('News') }}</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-syne font-bold text-white mb-6 uppercase tracking-widest text-[10px]">{{ __('Support') }}</h5>
                    <ul class="space-y-4 text-zinc-500 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('Complaint') }}</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('Report a Leak') }}</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('Villager Space') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-zinc-600 text-xs">
                    &copy; {{ date('Y') }} {{ __("Association Ait Daoud pour l'Eau et le Développement Rural.") }}
                </p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-zinc-500 hover:text-white transition-colors"><i data-lucide="instagram" class="w-5 h-5"></i></a>
                    <a href="#" class="text-zinc-500 hover:text-white transition-colors"><i data-lucide="facebook" class="w-5 h-5"></i></a>
                    <a href="#" class="text-zinc-500 hover:text-white transition-colors"><i data-lucide="mail" class="w-5 h-5"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
