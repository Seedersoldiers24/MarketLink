@extends('layouts.app')

@section('title', 'About MarketLink - Direct Farm-to-Table Pre-Order Platform')

@section('content')

<div class="bg-gradient-to-b from-brand-50/70 to-white py-16 border-b border-slate-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <span class="text-xs font-extrabold uppercase tracking-widest text-brand-700 bg-brand-100 px-3.5 py-1 rounded-full border border-brand-300">
            About MarketLink
        </span>
        <h1 class="font-heading font-extrabold text-3xl sm:text-5xl text-slate-900 tracking-tight">
            Bridging Local Farmers & Communities with <br class="hidden sm:inline">
            <span class="text-brand-700">Digital Pre-Order Efficiency</span>
        </h1>
        <p class="text-xs sm:text-sm text-slate-600 max-w-2xl mx-auto leading-relaxed">
            MarketLink connects independent farmers and neighborhood markets with conscious consumers. We streamline weekly harvesting, eliminate food waste, and make fresh regional produce effortlessly accessible.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16 space-y-12 sm:space-y-16">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="font-heading font-extrabold text-lg sm:text-xl text-slate-900">The Problem We Solve</h3>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                Shoppers often arrive at farmers markets only to discover their favorite organic produce is already sold out, or that a specific grower isn't attending this week. Farmers, meanwhile, harvest blindly without knowing exact customer demand, leading to unsold perishables and unpredictable revenue.
            </p>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-brand-200 shadow-sm space-y-4 bg-brand-50/30">
            <div class="w-12 h-12 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-seedling"></i>
            </div>
            <h3 class="font-heading font-extrabold text-lg sm:text-xl text-slate-900">The MarketLink Solution</h3>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                MarketLink centralizes regional market schedules, grower profiles, and weekly inventories into a seamless web platform. Customers pre-order exactly what they need before the harvest cutoff, and growers pick and pack with confidence. Pickup is fast, and payment is settled directly at the stall.
            </p>
        </div>
    </div>

    <div>
        <div class="text-center max-w-xl mx-auto mb-10">
            <span class="text-xs font-extrabold uppercase tracking-widest text-brand-700">Platform Pillars</span>
            <h2 class="font-heading font-extrabold text-3xl text-slate-900 mt-1">Built for Environmental & Economic Sustainability</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-earth-americas"></i>
                </div>
                <h4 class="font-heading font-bold text-base text-slate-900">Zero Food Waste</h4>
                <p class="text-xs text-slate-500 leading-relaxed">By harvesting strictly based on confirmed customer pre-orders, farms achieve virtually zero unsold produce waste on market days.</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <h4 class="font-heading font-bold text-base text-slate-900">Fair Direct Returns</h4>
                <p class="text-xs text-slate-500 leading-relaxed">No predatory middlemen fees. 100% of the produce value remains with the local farmers who nurture and harvest your food.</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <h4 class="font-heading font-bold text-base text-slate-900">Live Market Geolocation</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Integrated interactive mapping pinpoints exact market pavilions, parking zones, and individual stall pickup stations.</p>
            </div>
        </div>
    </div>

    <div class="bg-slate-900 text-white p-6 sm:p-10 md:p-12 rounded-3xl border border-slate-800 space-y-6">
        <div class="flex items-center justify-between flex-wrap gap-4 border-b border-slate-800 pb-4">
            <div>
                <span class="text-brand-400 font-bold text-xs uppercase tracking-widest">Platform Infrastructure</span>
                <h3 class="font-heading font-extrabold text-xl sm:text-2xl text-white mt-1">Enterprise-Grade Performance & Security</h3>
            </div>
            <span class="bg-brand-600 text-white font-extrabold text-xs px-3 py-1 rounded-xl">Verified Marketplace</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 text-xs">
            <div class="p-3 rounded-2xl bg-white/5 border border-white/10">
                <span class="text-slate-400 block uppercase font-bold text-[10px]">Architecture</span>
                <span class="text-white font-bold text-sm">Real-time Pre-Order Engine</span>
            </div>
            <div class="p-3 rounded-2xl bg-white/5 border border-white/10">
                <span class="text-slate-400 block uppercase font-bold text-[10px]">Data Integrity</span>
                <span class="text-white font-bold text-sm">Transactional SQL Storage</span>
            </div>
            <div class="p-3 rounded-2xl bg-white/5 border border-white/10">
                <span class="text-slate-400 block uppercase font-bold text-[10px]">Cart & Cutoffs</span>
                <span class="text-white font-bold text-sm">Automated Harvest Windows</span>
            </div>
            <div class="p-3 rounded-2xl bg-white/5 border border-white/10">
                <span class="text-slate-400 block uppercase font-bold text-[10px]">Support & Concierge</span>
                <span class="text-white font-bold text-sm">Interactive Help Desk</span>
            </div>
        </div>
    </div>
</div>
@endsection
