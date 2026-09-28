<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MarketLink - Direct Farm-to-Table Pre-Orders & Local Markets')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0',
                            500: '#22c55e', 600: '#16a34a', 700: '#15803d',
                            800: '#166534', 900: '#14532d',
                        },
                        amber: { 500: '#f59e0b', 600: '#d97706' }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        heading: ['"Outfit"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="{{ asset('css/marketlink.css') }}">

    @stack('styles')
</head>
<body 
    data-ai-route="{{ route('ai.chat') }}" 
    data-cart-route="{{ route('cart.add') }}"
    class="bg-slate-50 text-slate-800 min-h-screen flex flex-col antialiased selection:bg-brand-500 selection:text-white">

    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 transition-all duration-200 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group shrink-0">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-2xl bg-emerald-800 text-white flex items-center justify-center font-bold shadow-sm group-hover:scale-105 transition-transform duration-200 shrink-0">
                        <i class="fa-solid fa-leaf text-base sm:text-lg"></i>
                    </div>
                    <div>
                        <div class="font-heading font-extrabold text-lg sm:text-2xl tracking-tight text-slate-900 flex items-center gap-1">
                            Market<span class="text-emerald-700">Link</span>
                        </div>
                        <p class="text-[10px] sm:text-[11px] font-semibold text-slate-500 hidden sm:block">Springfield Local Harvest Network</p>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('home') ? 'bg-brand-50 text-brand-700 font-bold' : 'text-slate-600 hover:text-brand-700 hover:bg-slate-100/70' }}">
                        Home
                    </a>
                    <a href="{{ route('markets.index') }}" class="px-3 py-2 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('markets.*') ? 'bg-brand-50 text-brand-700 font-bold' : 'text-slate-600 hover:text-brand-700 hover:bg-slate-100/70' }}">
                        <i class="fa-solid fa-map-location-dot text-brand-600 mr-1.5"></i> Markets
                    </a>
                    <a href="{{ route('farmers.index') }}" class="px-3 py-2 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('farmers.*') ? 'bg-brand-50 text-brand-700 font-bold' : 'text-slate-600 hover:text-brand-700 hover:bg-slate-100/70' }}">
                        <i class="fa-solid fa-store text-brand-600 mr-1.5"></i> Farmers
                    </a>
                    <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('products.*') ? 'bg-brand-50 text-brand-700 font-bold' : 'text-slate-600 hover:text-brand-700 hover:bg-slate-100/70' }}">
                        <i class="fa-solid fa-basket-shopping text-brand-600 mr-1.5"></i> Browse Produce
                    </a>
                    <a href="{{ route('about') }}" class="px-3 py-2 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('about') ? 'bg-brand-50 text-brand-700 font-bold' : 'text-slate-600 hover:text-brand-700 hover:bg-slate-100/70' }}">
                        About Us
                    </a>
                    <a href="{{ route('contact') }}" class="px-3 py-2 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('contact') ? 'bg-brand-50 text-brand-700 font-bold' : 'text-slate-600 hover:text-brand-700 hover:bg-slate-100/70' }}">
                        Contact
                    </a>
                </nav>

                <div class="flex items-center gap-1.5 sm:gap-3">
                    @php
                        $cartItemsCount = array_sum(array_column(session('cart', []), 'quantity'));
                    @endphp
                    <a href="{{ route('cart.index') }}" id="header-cart-btn" class="relative p-2 sm:p-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:text-brand-700 hover:border-brand-300 shadow-sm transition-all duration-200 flex items-center gap-2 group shrink-0">
                        <i class="fa-solid fa-basket-shopping text-base sm:text-lg text-brand-600 group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-bold hidden sm:inline">Pre-Orders</span>
                        <span id="cart-counter-badge" class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-brand-600 text-white text-[10px] font-bold flex items-center justify-center shadow-sm {{ $cartItemsCount > 0 ? '' : 'hidden' }}">
                            {{ $cartItemsCount }}
                        </span>
                    </a>

                    @auth
                        <div class="relative" id="user-menu-container">
                            <button onclick="toggleUserDropdown()" class="flex items-center gap-2 p-1.5 sm:px-3 sm:py-2 rounded-2xl bg-white border border-slate-200 hover:border-brand-300 shadow-sm text-slate-800 transition-all shrink-0">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-xs sm:text-sm shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="text-left hidden sm:block">
                                    <div class="text-xs font-bold leading-tight truncate max-w-[120px]">{{ Auth::user()->name }}</div>
                                    <div class="text-[10px] text-slate-500 capitalize">{{ Auth::user()->role }}</div>
                                </div>
                                <i class="fa-solid fa-chevron-down text-slate-400 text-[10px] sm:text-xs"></i>
                            </button>

                            <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-56 sm:w-60 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 animate-slide-down">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <div class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</div>
                                    <div class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</div>
                                    <span class="inline-block mt-1 text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-brand-100 text-brand-800">
                                        {{ Auth::user()->role }}
                                    </span>
                                </div>

                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-700">
                                        <i class="fa-solid fa-gauge-high text-brand-600 w-4"></i> Admin Console
                                    </a>
                                    <a href="{{ route('admin.markets') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-700">
                                        <i class="fa-solid fa-map-location text-brand-600 w-4"></i> Manage Markets
                                    </a>
                                    <a href="{{ route('admin.farmers') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-700">
                                        <i class="fa-solid fa-tractor text-brand-600 w-4"></i> Approve Farmers
                                    </a>
                                @elseif(Auth::user()->isFarmer())
                                    <a href="{{ route('farmer.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-700">
                                        <i class="fa-solid fa-gauge text-brand-600 w-4"></i> Stall Dashboard
                                    </a>
                                    <a href="{{ route('farmer.orders') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-700">
                                        <i class="fa-solid fa-clipboard-list text-brand-600 w-4"></i> Incoming Pre-Orders
                                    </a>
                                    <a href="{{ route('farmer.products') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-700">
                                        <i class="fa-solid fa-apple-whole text-brand-600 w-4"></i> Manage Weekly Stock
                                    </a>
                                    <a href="{{ route('farmer.profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-700">
                                        <i class="fa-solid fa-store text-brand-600 w-4"></i> Stall Settings & Slots
                                    </a>
                                @else
                                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-700">
                                        <i class="fa-solid fa-clock-rotate-left text-brand-600 w-4"></i> My Pre-Orders
                                    </a>
                                    <a href="{{ route('customer.favorites') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-700">
                                        <i class="fa-solid fa-heart text-rose-500 w-4"></i> Favorite Farmers & Items
                                    </a>
                                    <a href="{{ route('customer.profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-700">
                                        <i class="fa-solid fa-user-pen text-brand-600 w-4"></i> Profile Settings
                                    </a>
                                @endif

                                <div class="border-t border-slate-100 mt-1 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                            <i class="fa-solid fa-right-from-bracket w-4"></i> Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <a href="{{ route('login') }}" class="px-2.5 py-1.5 sm:px-3.5 sm:py-2 text-[11px] sm:text-xs font-bold text-slate-700 hover:text-brand-700 hover:bg-slate-100 rounded-xl transition-colors">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}" class="px-2.5 py-1.5 sm:px-4 sm:py-2 text-[11px] sm:text-xs font-bold text-white bg-gradient-to-r from-brand-700 to-brand-600 hover:from-brand-800 hover:to-brand-700 rounded-xl shadow-md shadow-brand-700/20 transition-all hover:shadow-lg">
                                Join Now
                            </a>
                        </div>
                    @endauth

                    <button onclick="toggleMobileNav()" aria-label="Toggle navigation menu" class="p-2 sm:p-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 md:hidden hover:bg-slate-50 active:scale-95 transition-all">
                        <i class="fa-solid fa-bars-staggered text-sm sm:text-base"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-nav" class="hidden md:hidden border-t border-slate-200/80 bg-white/98 backdrop-blur-md px-4 pt-3 pb-6 space-y-2 animate-slide-down max-h-[85vh] overflow-y-auto touch-scroll">
            @auth
                
                <div class="p-3 mb-2 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-xs shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <div class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] text-slate-500 capitalize">{{ Auth::user()->role }}</div>
                        </div>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-brand-100 text-brand-800">
                        {{ Auth::user()->role }}
                    </span>
                </div>

                <div class="space-y-1 pb-2 mb-2 border-b border-slate-100">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-1">Your Portal</div>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-brand-700 bg-brand-50/70">
                            <i class="fa-solid fa-gauge-high text-brand-600 w-4"></i> Admin Console
                        </a>
                        <a href="{{ route('admin.markets') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <i class="fa-solid fa-map-location text-brand-600 w-4"></i> Manage Markets
                        </a>
                        <a href="{{ route('admin.farmers') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <i class="fa-solid fa-tractor text-brand-600 w-4"></i> Approve Farmers
                        </a>
                    @elseif(Auth::user()->isFarmer())
                        <a href="{{ route('farmer.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-brand-700 bg-brand-50/70">
                            <i class="fa-solid fa-gauge text-brand-600 w-4"></i> Stall Dashboard
                        </a>
                        <a href="{{ route('farmer.orders') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <i class="fa-solid fa-clipboard-list text-brand-600 w-4"></i> Incoming Pre-Orders
                        </a>
                        <a href="{{ route('farmer.products') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <i class="fa-solid fa-apple-whole text-brand-600 w-4"></i> Manage Weekly Stock
                        </a>
                        <a href="{{ route('farmer.profile') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <i class="fa-solid fa-store text-brand-600 w-4"></i> Stall Settings & Slots
                        </a>
                    @else
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-brand-700 bg-brand-50/70">
                            <i class="fa-solid fa-clock-rotate-left text-brand-600 w-4"></i> My Pre-Orders
                        </a>
                        <a href="{{ route('customer.favorites') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <i class="fa-solid fa-heart text-rose-500 w-4"></i> Favorite Farmers & Items
                        </a>
                        <a href="{{ route('customer.profile') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <i class="fa-solid fa-user-pen text-brand-600 w-4"></i> Profile Settings
                        </a>
                    @endif
                </div>
            @endauth

            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-1">Browse Platform</div>
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-brand-50 hover:text-brand-700">
                <i class="fa-solid fa-house text-brand-600 w-4"></i> Home
            </a>
            <a href="{{ route('markets.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-brand-50 hover:text-brand-700">
                <i class="fa-solid fa-map-location-dot text-brand-600 w-4"></i> Markets Map
            </a>
            <a href="{{ route('farmers.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-brand-50 hover:text-brand-700">
                <i class="fa-solid fa-store text-brand-600 w-4"></i> Local Farmers
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-brand-50 hover:text-brand-700">
                <i class="fa-solid fa-basket-shopping text-brand-600 w-4"></i> Produce Catalog
            </a>
            <a href="{{ route('about') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-brand-50 hover:text-brand-700">
                <i class="fa-solid fa-circle-info text-brand-600 w-4"></i> About MarketLink
            </a>
            <a href="{{ route('contact') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-brand-50 hover:text-brand-700">
                <i class="fa-solid fa-envelope text-brand-600 w-4"></i> Contact Us
            </a>

            @guest
            <div class="pt-3 border-t border-slate-100 flex items-center gap-2">
                <a href="{{ route('login') }}" class="flex-1 text-center py-2.5 text-xs font-bold text-slate-700 border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">Sign In</a>
                <a href="{{ route('register') }}" class="flex-1 text-center py-2.5 text-xs font-bold text-white bg-brand-600 rounded-xl hover:bg-brand-700 transition-colors">Join Now</a>
            </div>
            @else
            <div class="pt-3 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-2.5 text-center text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-xl transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                    </button>
                </form>
            </div>
            @endguest
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="flex items-center gap-3 p-3.5 sm:p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm animate-fade-in" role="alert">
                <i class="fa-solid fa-circle-check text-emerald-500 text-base sm:text-lg shrink-0"></i>
                <div class="text-xs sm:text-sm font-semibold flex-1">{{ session('success') }}</div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center gap-3 p-3.5 sm:p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm animate-fade-in" role="alert">
                <i class="fa-solid fa-triangle-exclamation text-rose-500 text-base sm:text-lg shrink-0"></i>
                <div class="text-xs sm:text-sm font-semibold flex-1">{{ session('error') }}</div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(session('info'))
            <div class="flex items-center gap-3 p-3.5 sm:p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-800 shadow-sm animate-fade-in" role="alert">
                <i class="fa-solid fa-circle-info text-blue-500 text-base sm:text-lg shrink-0"></i>
                <div class="text-xs sm:text-sm font-semibold flex-1">{{ session('info') }}</div>
                <button onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-800"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="p-3.5 sm:p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm animate-fade-in">
                <div class="flex items-center gap-2 font-bold text-xs sm:text-sm mb-1">
                    <i class="fa-solid fa-circle-xmark text-rose-500"></i> Please check the following errors:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <main class="flex-grow">
        @yield('content')
    </main>

    <div id="ai-assistant-widget" class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50">
        <button onclick="toggleAiChat()" id="ai-trigger-btn" class="h-10 sm:h-11 px-3 sm:px-4 rounded-full bg-slate-900 hover:bg-slate-800 text-white shadow-lg flex items-center gap-2 sm:gap-2.5 text-xs font-bold transition-all hover:shadow-xl active:scale-95">
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            <i class="fa-regular fa-comment-dots text-sm"></i>
            <span class="hidden xs:inline sm:inline">Market Help & FAQ</span>
            <span class="xs:hidden sm:hidden">Help</span>
        </button>

        <div id="ai-chat-box" class="hidden absolute bottom-14 right-0 w-[calc(100vw-2rem)] sm:w-96 max-w-sm bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col h-[450px] max-h-[75vh] animate-fade-in">
            <div class="bg-slate-900 text-white p-4 flex items-center justify-between border-b border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-800 text-white flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <div class="font-heading font-bold text-sm leading-tight">Market Concierge</div>
                        <div class="text-[11px] text-slate-400 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Instant Market & Vendor Help
                        </div>
                    </div>
                </div>
                <button onclick="toggleAiChat()" class="text-slate-400 hover:text-white p-1 rounded-lg">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <div id="ai-messages-log" class="flex-1 p-4 overflow-y-auto space-y-3 text-xs bg-slate-50/50">
                <div class="flex items-start gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center flex-shrink-0 text-xs">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div class="chat-bubble-ai p-3 max-w-[85%] shadow-xs leading-relaxed">
                        Hello! Welcome to MarketLink. Looking for market operating schedules, pre-order cutoff times, or organic produce stalls? Ask me anything below:
                    </div>
                </div>
            </div>

            <div id="ai-suggestion-chips" class="px-3 py-2 bg-white border-t border-slate-100 flex items-center gap-1.5 overflow-x-auto whitespace-nowrap text-[11px]">
                <button onclick="askAiQuestion('Which markets are open Saturday?')" class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                    Saturday Markets
                </button>
                <button onclick="askAiQuestion('Find fresh organic berries')" class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                    Organic Berries
                </button>
                <button onclick="askAiQuestion('How does pickup cutoff work?')" class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                    Cutoff Hours
                </button>
            </div>

            <form id="ai-chat-form" onsubmit="sendAiMessage(event)" class="p-3 bg-white border-t border-slate-200 flex items-center gap-2">
                <input type="text" id="ai-user-input" placeholder="Ask about markets, farmers, produce..." class="flex-1 bg-slate-100 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-emerald-600 focus:bg-white transition-all">
                <button type="submit" class="w-8 h-8 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white flex items-center justify-center transition-all flex-shrink-0">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </form>
        </div>
    </div>

    <footer class="bg-slate-900 text-slate-300 mt-24 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-800 text-white flex items-center justify-center font-bold shadow-sm">
                            <i class="fa-solid fa-leaf text-base"></i>
                        </div>
                        <span class="font-heading font-extrabold text-2xl text-white tracking-tight">Market<span class="text-emerald-500">Link</span></span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-sm">
                        Connecting verified local sustainable growers directly with neighborhood families. Browse weekly harvest catalogs, pre-order before cutoff, and pick up fresh at your neighborhood weekend market.
                    </p>
                    <div class="pt-2 flex items-center gap-2 text-xs font-semibold text-emerald-400">
                        <i class="fa-solid fa-shield-halved"></i> 100% Verified Local Springfield Producers
                    </div>
                </div>

                <div>
                    <h4 class="font-heading font-bold text-white text-sm uppercase tracking-wider mb-4">Discovery</h4>
                    <ul class="space-y-2.5 text-xs text-slate-400">
                        <li><a href="{{ route('markets.index') }}" class="hover:text-brand-400 transition-colors">Farmers Markets Map</a></li>
                        <li><a href="{{ route('farmers.index') }}" class="hover:text-brand-400 transition-colors">Local Verified Growers</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-brand-400 transition-colors">Seasonal Produce Catalog</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-brand-400 transition-colors">Pre-Order Basket</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-heading font-bold text-white text-sm uppercase tracking-wider mb-4">Portals</h4>
                    <ul class="space-y-2.5 text-xs text-slate-400">
                        <li><a href="{{ route('customer.dashboard') }}" class="hover:text-brand-400 transition-colors">Customer Dashboard</a></li>
                        <li><a href="{{ route('farmer.dashboard') }}" class="hover:text-brand-400 transition-colors">Farmer Stall Manager</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-brand-400 transition-colors">Platform Administration</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-brand-400 transition-colors">Register New Stall</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-heading font-bold text-white text-sm uppercase tracking-wider mb-4">Support & Help</h4>
                    <ul class="space-y-2.5 text-xs text-slate-400">
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-brand-400"></i>
                            <a href="mailto:support@marketlink.com" class="hover:text-brand-400 transition-colors">support@marketlink.com</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-brand-400"></i>
                            <span>+1 (555) 010-0001</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-brand-400"></i>
                            <span>Springfield Local Markets</span>
                        </li>
                        <li class="pt-2">
                            <a href="{{ route('contact') }}" class="inline-block px-3 py-1.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-bold text-[11px] transition-colors">
                                Get In Touch
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4 text-center sm:text-left">
                <div>
                    &copy; {{ date('Y') }} MarketLink. All rights reserved.
                </div>
                <div class="flex flex-wrap items-center justify-center sm:justify-end gap-3 sm:gap-4">
                    <span class="flex items-center gap-1.5 text-emerald-400 font-semibold text-[11px] sm:text-xs">
                        <i class="fa-solid fa-database"></i> MySQL Relational Schema
                    </span>
                    <span class="flex items-center gap-1.5 text-rose-400 font-semibold text-[11px] sm:text-xs">
                        <i class="fa-brands fa-laravel"></i> Laravel 12 Backend
                    </span>
                    <span class="flex items-center gap-1.5 text-blue-400 font-semibold text-[11px] sm:text-xs">
                        <i class="fa-solid fa-map"></i> OpenStreetMap Leaflet
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const reveals = document.querySelectorAll('.reveal');
        const revealOnScroll = () => {
            const windowHeight = window.innerHeight;
            reveals.forEach(reveal => {
                const elementTop = reveal.getBoundingClientRect().top;
                if (elementTop < windowHeight - 100) reveal.classList.add('active');
            });
        };
        window.addEventListener('scroll', revealOnScroll);
        revealOnScroll();

        window.initSlider = function (containerId, autoPlay = true) {
            const container = document.getElementById(containerId);
            if (!container) return;
            const track = container.querySelector('.slider-track');
            const slides = container.querySelectorAll('.slider-slide');
            const prevBtn = container.querySelector('.slider-prev');
            const nextBtn = container.querySelector('.slider-next');
            const dots = container.querySelectorAll('.slider-dot');
            let currentIndex = 0;
            const totalSlides = slides.length;
            function goToSlide(index) {
                if (index < 0) index = totalSlides - 1;
                if (index >= totalSlides) index = 0;
                currentIndex = index;
                track.style.transform = `translateX(-${currentIndex * 100}%)`;
                dots.forEach((dot, i) => {
                    dot.classList.toggle('bg-emerald-600', i === currentIndex);
                    dot.classList.toggle('bg-slate-300', i !== currentIndex);
                });
            }
            if (prevBtn) prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));
            if (nextBtn) nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));
            dots.forEach((dot, i) => dot.addEventListener('click', () => goToSlide(i)));
            if (autoPlay && totalSlides > 1) setInterval(() => goToSlide(currentIndex + 1), 5500);
            goToSlide(0);
        };
        document.querySelectorAll('.slider-container').forEach(c => {
            if (c.id) window.initSlider(c.id, true);
        });
    });

    function toggleUserDropdown() {
        document.getElementById('user-dropdown-menu')?.classList.toggle('hidden');
    }
    document.addEventListener('click', function (e) {
        const container = document.getElementById('user-menu-container');
        const menu = document.getElementById('user-dropdown-menu');
        if (container && menu && !container.contains(e.target)) menu.classList.add('hidden');
    });
    function toggleMobileNav() {
        document.getElementById('mobile-nav')?.classList.toggle('hidden');
    }
    function toggleAiChat() {
        const box = document.getElementById('ai-chat-box');
        if (!box) return;
        box.classList.toggle('hidden');
        if (!box.classList.contains('hidden')) document.getElementById('ai-user-input')?.focus();
    }
    function askAiQuestion(question) {
        const input = document.getElementById('ai-user-input');
        if (input) { input.value = question; sendAiMessage(new Event('submit')); }
    }
    async function sendAiMessage(e) {
        if (e) e.preventDefault();
        const input = document.getElementById('ai-user-input');
        const msg = input?.value.trim();
        if (!msg) return;
        const log = document.getElementById('ai-messages-log');
        if (!log) return;
        log.innerHTML += `<div class="flex items-start justify-end gap-2"><div class="chat-bubble-user p-3 max-w-[85%] shadow-sm">${escapeHtml(msg)}</div></div>`;
        input.value = '';
        log.scrollTop = log.scrollHeight;
        const typingId = 'typing-' + Date.now();
        log.innerHTML += `<div id="${typingId}" class="flex items-center gap-2 text-slate-400 text-[11px]"><i class="fa-solid fa-circle-notch fa-spin text-brand-600"></i> FarmBot is finding fresh answers...</div>`;
        log.scrollTop = log.scrollHeight;
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const aiRoute = document.body.dataset.aiRoute || '/api/ai-chat';
            const response = await fetch(aiRoute, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ message: msg })
            });
            const data = await response.json();
            document.getElementById(typingId)?.remove();
            let formattedReply = (data.reply || 'Sorry, no response.').replace(/\n/g, '<br>');
            log.innerHTML += `<div class="flex items-start gap-2"><div class="w-7 h-7 rounded-lg bg-brand-100 text-brand-700 flex items-center justify-center flex-shrink-0 text-xs"><i class="fa-solid fa-robot"></i></div><div class="chat-bubble-ai p-3 max-w-[85%] shadow-sm leading-relaxed">${formattedReply}</div></div>`;
            log.scrollTop = log.scrollHeight;
        } catch (err) {
            document.getElementById(typingId)?.remove();
            log.innerHTML += `<div class="text-rose-500 text-xs">Unable to connect to assistant right now. Please try again.</div>`;
        }
    }
    function escapeHtml(text) {
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
    async function addToCartAjax(productId, qty = 1) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const cartRoute = document.body.dataset.cartRoute || '/cart/add';
            const res = await fetch(cartRoute, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ product_id: productId, quantity: qty })
            });
            const data = await res.json();
            if (data.success) {
                const badge = document.getElementById('cart-counter-badge');
                if (badge) { badge.textContent = data.cartCount; badge.classList.remove('hidden'); }
                const btn = document.getElementById('header-cart-btn');
                if (btn) { btn.classList.add('cart-bump'); setTimeout(() => btn.classList.remove('cart-bump'), 400); }
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Could not add to basket.', 'error');
            }
        } catch (e) { window.location.reload(); }
    }
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-20 sm:top-24 right-4 left-4 sm:left-auto sm:right-6 z-50 px-4 py-3 rounded-2xl shadow-xl border text-xs font-bold flex items-center gap-2 animate-fade-in max-w-md sm:w-auto ${type === 'success' ? 'bg-brand-700 text-white border-brand-600' : 'bg-rose-600 text-white border-rose-500'}`;
        toast.innerHTML = `<i class="fa-solid fa-${type === 'success' ? 'circle-check' : 'circle-exclamation'} shrink-0"></i> <span>${message}</span>`;
        document.body.appendChild(toast);
        setTimeout(() => { toast.classList.add('opacity-0'); setTimeout(() => toast.remove(), 300); }, 3000);
    }
    </script>

    @stack('scripts')
</body>
</html>