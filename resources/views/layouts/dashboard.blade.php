<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MarketLink Management Portal')</title>

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
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
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
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex flex-col md:flex-row overflow-x-hidden">

    <div id="sidebar-backdrop" onclick="toggleDashboardSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 hidden md:hidden drawer-backdrop"></div>

    <aside id="dashboard-sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-300 flex flex-col justify-between border-r border-slate-800 transform -translate-x-full md:translate-x-0 md:static md:w-64 transition-transform duration-300 ease-in-out shrink-0 overflow-y-auto touch-scroll">
        <div>
            
            <div class="p-4 sm:p-5 border-b border-slate-800 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-brand-700 text-white flex items-center justify-center font-bold shadow-xs shrink-0">
                        <i class="fa-solid fa-leaf text-sm"></i>
                    </div>
                    <div>
                        <div class="font-heading font-extrabold text-base text-white tracking-tight">Market<span class="text-brand-400">Link</span></div>
                        <div class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold">
                            @if(Auth::user()->isAdmin())
                                Administrator
                            @elseif(Auth::user()->isFarmer())
                                Farm Stall Vendor
                            @else
                                Customer Account
                            @endif
                        </div>
                    </div>
                </a>

                <button onclick="toggleDashboardSidebar()" aria-label="Close sidebar" class="md:hidden text-slate-400 hover:text-white p-1.5 rounded-lg hover:bg-slate-800 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="px-5 py-3.5 bg-slate-800/40 border-b border-slate-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-slate-800 border border-slate-700 text-slate-200 flex items-center justify-center font-bold text-xs shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</div>
                    <div class="text-[11px] text-slate-400 capitalize">{{ Auth::user()->role }}</div>
                </div>
            </div>

            <nav class="p-3.5 space-y-1 text-xs font-semibold">
                @if(Auth::user()->isAdmin())
                    
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-chart-line text-sm w-4"></i> Dashboard Overview
                    </a>
                    <a href="{{ route('admin.farmers') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.farmers') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-tractor text-sm w-4"></i> Manage Farmers
                    </a>
                    <a href="{{ route('admin.customers') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.customers') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-users text-sm w-4"></i> Customer Accounts
                    </a>
                    <a href="{{ route('admin.markets') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.markets') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-map-location-dot text-sm w-4"></i> Farmers Markets
                    </a>
                    <a href="{{ route('admin.moderation') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.moderation') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-shield-halved text-sm w-4"></i> Content Moderation
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.reports') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-chart-pie text-sm w-4"></i> Reports & Analytics
                    </a>
                    <a href="{{ route('admin.categories') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.categories') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-layer-group text-sm w-4"></i> Master Categories
                    </a>
                    <a href="{{ route('admin.announcements') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.announcements') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-bullhorn text-sm w-4"></i> Announcements
                    </a>
                @elseif(Auth::user()->isFarmer())
                    
                    <a href="{{ route('farmer.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('farmer.dashboard') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-chart-line text-sm w-4"></i> Dashboard & Insights
                    </a>
                    <a href="{{ route('farmer.orders') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('farmer.orders') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-clipboard-list text-sm w-4"></i> Pre-Orders Manager
                    </a>
                    <a href="{{ route('farmer.products') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('farmer.products') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-apple-whole text-sm w-4"></i> Weekly Stock & Pricing
                    </a>
                    <a href="{{ route('farmer.profile') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('farmer.profile') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-store text-sm w-4"></i> Stall Setup & Cutoff
                    </a>
                    <a href="{{ route('farmer.reviews') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('farmer.reviews') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-star-half-stroke text-sm w-4"></i> Customer Reviews
                    </a>
                @else
                    
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('customer.dashboard') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-clock-rotate-left text-sm w-4"></i> My Pre-Orders
                    </a>
                    <a href="{{ route('customer.favorites') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('customer.favorites') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-heart text-sm w-4 text-rose-400"></i> Saved Favorites
                    </a>
                    <a href="{{ route('customer.profile') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('customer.profile') ? 'bg-slate-800 text-white font-bold border-l-2 border-brand-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-user-gear text-sm w-4"></i> My Contact Details
                    </a>
                @endif
            </nav>
        </div>

        <div class="p-4 border-t border-slate-800 space-y-2 text-xs font-semibold">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Back to Main Store
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-rose-400 hover:text-rose-300 hover:bg-rose-950/40 transition-colors">
                    <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        
        <header class="bg-white border-b border-slate-200/80 px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between sticky top-0 z-30 shadow-xs">
            <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                
                <button onclick="toggleDashboardSidebar()" aria-label="Open sidebar menu" class="md:hidden p-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors shrink-0 active:scale-95">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>

                <div class="min-w-0">
                    <h1 class="font-heading font-extrabold text-base sm:text-xl text-slate-900 leading-tight truncate">
                        @yield('header_title', 'Dashboard')
                    </h1>
                    <p class="text-[11px] sm:text-xs text-slate-500 font-medium truncate hidden xs:block">
                        @yield('header_subtitle', 'Manage operations and review data')
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <a href="{{ route('markets.index') }}" class="hidden lg:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">
                    <i class="fa-solid fa-map text-brand-600"></i> View Map
                </a>
                <a href="{{ route('products.index') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">
                    <i class="fa-solid fa-basket-shopping text-brand-600"></i> Browse Produce
                </a>
                <span class="text-[11px] sm:text-xs font-bold bg-brand-50 text-brand-700 px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-xl border border-brand-200 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="hidden xs:inline">System Live</span>
                </span>
            </div>
        </header>

        <div class="px-4 sm:px-6 pt-4">
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

            @if(isset($errors) && $errors->any())
                <div class="p-3.5 sm:p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm animate-fade-in">
                    <div class="flex items-center gap-2 font-bold text-xs sm:text-sm mb-1">
                        <i class="fa-solid fa-circle-xmark text-rose-500"></i> Validation Errors:
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <main class="p-4 sm:p-6 flex-1 min-w-0">
            @yield('content')
        </main>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
    function toggleDashboardSidebar() {
        const sidebar = document.getElementById('dashboard-sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        if (!sidebar || !backdrop) return;
        const isHidden = sidebar.classList.contains('-translate-x-full');
        if (isHidden) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
            document.body.classList.add('overflow-hidden', 'md:overflow-auto');
        } else {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
            document.body.classList.remove('overflow-hidden', 'md:overflow-auto');
        }
    }
    // Auto-close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const sidebar = document.getElementById('dashboard-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (sidebar && !sidebar.classList.contains('-translate-x-full') && window.innerWidth < 768) {
                toggleDashboardSidebar();
            }
        }
    });
    </script>
    @stack('scripts')
</body>
</html>
