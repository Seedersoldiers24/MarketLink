@extends('layouts.app')

@section('title', 'MarketLink - Fresh Harvests Directly From Local Farmers Markets')

@section('content')

<section class="relative bg-[#fcfbf9] border-b border-slate-200/80 overflow-hidden">
    <div id="hero-slider" class="slider-container relative">
        <div class="slider-track">

            <div class="slider-slide">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-16 lg:pt-16 lg:pb-24">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/90 text-emerald-900 text-xs font-bold tracking-wide shadow-xs animate-fade-in">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 pulse-ring"></span>
                                <span>Direct From Verified Springfield Growers</span>
                            </div>

                            <h1 class="font-heading font-extrabold text-3xl sm:text-5xl lg:text-6xl text-slate-900 tracking-tight leading-[1.12]">
                                Reserve Fresh Farm <span class="text-gradient">Harvests</span> for Weekend Pickup.
                            </h1>

                            <p class="text-sm sm:text-base lg:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                                Pre-order heirloom tomatoes, freshly picked berries, pasture-raised eggs, and artisanal sourdough directly from local family growers before Friday evening cutoffs.
                            </p>

                            <div class="inline-flex items-center gap-3 p-3 rounded-2xl bg-white border border-emerald-200/80 shadow-xs max-w-xl mx-auto lg:mx-0">
                                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-sm shrink-0">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div class="text-left text-xs">
                                    <div class="font-bold text-slate-800">Weekly Pre-Order Cutoff Window</div>
                                    <div class="text-emerald-700 font-extrabold font-mono text-xs sm:text-sm" id="hero-countdown">
                                        Calculating cutoff...
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('products.index') }}" method="GET" class="bg-white p-2 rounded-2xl shadow-md border border-slate-200/90 max-w-xl mx-auto lg:mx-0 flex flex-col sm:flex-row gap-2">
                                <div class="flex-1 flex items-center gap-3 px-3 py-2">
                                    <i class="fa-solid fa-magnifying-glass text-emerald-700 text-sm"></i>
                                    <input type="text" name="search" placeholder="Search heirloom tomatoes, strawberries, honey..." class="w-full bg-transparent text-xs sm:text-sm focus:outline-none placeholder:text-slate-400 font-medium">
                                </div>
                                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-2 active:scale-95 shadow-sm">
                                    <span>Search Produce</span>
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </button>
                            </form>

                            <div class="pt-1 flex flex-wrap items-center justify-center lg:justify-start gap-2 text-xs">
                                <span class="font-semibold text-slate-400 mr-1">Trending:</span>
                                @foreach($categories->take(5) as $cat)
                                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="px-3 py-1 rounded-full bg-white border border-slate-200 text-slate-600 hover:border-emerald-700 hover:text-emerald-800 font-medium transition-colors shadow-2xs">
                                        {{ $cat->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="lg:col-span-5 relative">
                            <div class="relative mx-auto max-w-md lg:max-w-none">
                                <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-white animate-float">
                                    <img src="https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=800&q=80" alt="Springfield Farmers Market" class="w-full h-72 sm:h-96 object-cover">
                                </div>

                                <div class="absolute bottom-2 left-2 sm:-bottom-5 sm:-left-6 glass-pill p-2.5 sm:p-3.5 rounded-2xl shadow-xl flex items-center gap-2.5 sm:gap-3 animate-float-slow max-w-[85%] sm:max-w-none">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-base sm:text-lg font-bold shrink-0">
                                        <i class="fa-solid fa-leaf"></i>
                                    </div>
                                    <div>
                                        <div class="text-[10px] sm:text-[11px] font-bold text-slate-900 leading-tight">Picked at Dawn</div>
                                        <div class="text-[9px] sm:text-[10px] text-emerald-800 font-bold">0 Middlemen • 100% Fresh</div>
                                    </div>
                                </div>

                                <div class="absolute top-2 right-2 sm:-top-4 sm:-right-6 glass-pill p-2 sm:p-3 rounded-2xl shadow-xl flex items-center gap-2">
                                    <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span class="text-[11px] sm:text-xs font-bold text-slate-800">4 Markets Open</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="slider-slide">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-16 lg:pt-16 lg:pb-24">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold tracking-wide">
                                <i class="fa-solid fa-seedling text-amber-600"></i>
                                <span>Springfield Regenerative Agriculture</span>
                            </div>

                            <h1 class="font-heading font-extrabold text-3xl sm:text-5xl lg:text-6xl text-slate-900 tracking-tight leading-[1.12]">
                                Support <span class="text-gradient">Local Farmers</span>, Eat Clean Every Week.
                            </h1>

                            <p class="text-sm sm:text-base lg:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                                Skip the industrialized grocery aisles. Connect directly with over 25 certified organic and family growers in your surrounding neighborhoods.
                            </p>

                            <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-3">
                                <a href="{{ route('farmers.index') }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs sm:text-sm shadow-md transition-all active:scale-95">
                                    <i class="fa-solid fa-store"></i> Meet Verified Growers
                                </a>
                                <a href="{{ route('markets.index') }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-white border border-slate-200 hover:border-emerald-700 text-slate-700 font-bold text-xs sm:text-sm transition-all shadow-2xs">
                                    <i class="fa-solid fa-map-location-dot text-emerald-700"></i> View Weekend Map
                                </a>
                            </div>
                        </div>

                        <div class="lg:col-span-5 relative">
                            <div class="relative mx-auto max-w-md lg:max-w-none">
                                <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-white animate-float" style="animation-delay: 0.5s;">
                                    <img src="https://images.unsplash.com/photo-1595273670150-bd0c3c392e46?auto=format&fit=crop&w=800&q=80" alt="Local Farmer" class="w-full h-72 sm:h-96 object-cover">
                                </div>

                                <div class="absolute bottom-2 right-2 sm:-bottom-5 sm:-right-6 glass-pill p-2.5 sm:p-3.5 rounded-2xl shadow-xl flex items-center gap-2.5 sm:gap-3 max-w-[85%] sm:max-w-none">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-base sm:text-lg font-bold shrink-0">
                                        <i class="fa-solid fa-award"></i>
                                    </div>
                                    <div>
                                        <div class="text-[10px] sm:text-[11px] font-bold text-slate-900 leading-tight">Certified Sustainable</div>
                                        <div class="text-[9px] sm:text-[10px] text-amber-800 font-bold">Soil & Water Inspected</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <button class="slider-prev absolute left-1.5 sm:left-4 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-white/95 backdrop-blur shadow-lg flex items-center justify-center hover:bg-emerald-800 hover:text-white transition-all active:scale-95 z-10 border border-slate-100">
            <i class="fa-solid fa-chevron-left text-xs sm:text-sm"></i>
        </button>
        <button class="slider-next absolute right-1.5 sm:right-4 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-white/95 backdrop-blur shadow-lg flex items-center justify-center hover:bg-emerald-800 hover:text-white transition-all active:scale-95 z-10 border border-slate-100">
            <i class="fa-solid fa-chevron-right text-xs sm:text-sm"></i>
        </button>

        <div class="absolute bottom-3 sm:bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            <button class="slider-dot w-2.5 h-2.5 rounded-full bg-emerald-600 transition-all"></button>
            <button class="slider-dot w-2.5 h-2.5 rounded-full bg-slate-300 transition-all"></button>
        </div>
    </div>
</section>

<section class="reveal border-b border-slate-200/80 bg-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-100">
                <div class="font-heading font-extrabold text-2xl sm:text-4xl text-slate-900 count-up" data-target="{{ $stats['total_markets'] }}">{{ $stats['total_markets'] }}</div>
                <div class="text-[11px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">Weekend Markets</div>
            </div>
            <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-100">
                <div class="font-heading font-extrabold text-2xl sm:text-4xl text-slate-900 count-up" data-target="{{ $stats['total_farmers'] }}">{{ $stats['total_farmers'] }}</div>
                <div class="text-[11px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">Independent Growers</div>
            </div>
            <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-100">
                <div class="font-heading font-extrabold text-2xl sm:text-4xl text-slate-900 count-up" data-target="{{ $stats['total_products'] }}">{{ $stats['total_products'] }}</div>
                <div class="text-[11px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">Fresh Harvest Items</div>
            </div>
            <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-100">
                <div class="font-heading font-extrabold text-2xl sm:text-4xl text-emerald-800">100%</div>
                <div class="text-[11px] sm:text-xs font-bold text-emerald-900 uppercase tracking-wider mt-1">Local & Verified</div>
            </div>
        </div>
    </div>
</section>

<section class="reveal py-16 bg-[#fcfbf9]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Seasonal Selection</span>
                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 mt-1">Shop Weekly Harvest by Category</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Produce picked ripe and delivered fresh to Springfield market counters.</p>
            </div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 hover:text-emerald-900 transition-colors">
                View Entire Catalog <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @forelse($categories as $cat)
                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="group bg-white rounded-2xl p-4 text-center border border-slate-200/90 shadow-2xs card-hover flex flex-col items-center">
                    <div class="w-16 h-16 rounded-2xl overflow-hidden mb-3 bg-slate-50 border border-slate-100 img-zoom">
                        <img src="{{ $cat->image ?? 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?auto=format&fit=crop&w=200&q=80' }}" alt="{{ $cat->name }}" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-heading font-bold text-xs text-slate-900 group-hover:text-emerald-800 transition-colors line-clamp-1">
                        {{ $cat->name }}
                    </h3>
                    <span class="text-[11px] text-slate-400 mt-0.5">{{ $cat->products_count ?? 0 }} items</span>
                </a>
            @empty
                <div class="col-span-full text-center py-8 text-slate-400 text-sm">
                    No categories available yet.
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="reveal py-16 bg-white border-y border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Fresh Pre-Orders</span>
                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 mt-1">Featured Produce Ready for Pickup</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Pre-order now to guarantee supply before Saturday morning cutoffs.</p>
            </div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 hover:text-emerald-900">
                View All Products <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredProducts as $product)
                <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-2xs card-hover flex flex-col">
                    <div class="relative h-48 overflow-hidden bg-slate-50 img-zoom">
                        <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-xs">
                            {{ $product->category->name ?? 'Harvest' }}
                        </span>
                        @if(($product->stock_quantity ?? 0) > 0)
                            <span class="absolute bottom-3 right-3 bg-emerald-50/95 border border-emerald-200 text-emerald-900 text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs">
                                {{ $product->stock_quantity }} {{ $product->unit }} left
                            </span>
                        @else
                            <span class="absolute bottom-3 right-3 bg-rose-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs">
                                Sold Out
                            </span>
                        @endif
                    </div>

                    <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <a href="{{ route('farmers.show', $product->farmer_id) }}" class="text-[11px] font-bold text-emerald-800 hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-store text-[10px]"></i> {{ $product->farmer->stall_name ?? 'Local Farm' }}
                            </a>
                            <h3 class="font-heading font-extrabold text-sm text-slate-900 mt-1 line-clamp-1 hover:text-emerald-800 transition-colors">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $product->description ?? 'Fresh seasonal produce picked at morning peak.' }}</p>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-400">Price</span>
                                <div class="font-heading font-extrabold text-base text-slate-900 leading-none">
                                    ${{ number_format($product->price ?? 0, 2) }}
                                    <span class="text-xs font-normal text-slate-500">/ {{ $product->unit ?? 'unit' }}</span>
                                </div>
                            </div>

                            @if(($product->stock_quantity ?? 0) > 0)
                                <button onclick="addToCartAjax({{ $product->id }}, 1)" class="px-3.5 py-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white text-xs font-bold transition-all flex items-center gap-1.5 active:scale-95 shadow-xs">
                                    <i class="fa-solid fa-plus text-[10px]"></i> Pre-Order
                                </button>
                            @else
                                <button disabled class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-400 text-xs font-bold cursor-not-allowed">
                                    Sold Out
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-slate-400 text-sm">
                    No featured products available yet.
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="reveal py-16 bg-[#fcfbf9]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

            <div class="lg:col-span-5 space-y-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Springfield Map</span>
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 leading-tight mt-1">
                        Find Your Weekend Pickup Market
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mt-2">
                        View stall locations, operating days, and express customer pre-order pickup stations across Springfield.
                    </p>
                </div>

                <div class="space-y-3">
                    @forelse($markets as $m)
                        <div class="p-3.5 rounded-2xl bg-white border border-slate-200/90 shadow-2xs flex items-center justify-between hover:border-emerald-700 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center font-bold text-xs border border-emerald-100 shrink-0">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">{{ $m->market_name }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $m->operating_days }} • {{ $m->timings }}</div>
                                </div>
                            </div>
                            <a href="{{ route('markets.show', $m->slug) }}" class="text-xs font-bold text-emerald-800 hover:underline shrink-0">
                                View <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs">
                            No markets available yet.
                        </div>
                    @endforelse
                </div>

                <div class="pt-2">
                    <a href="{{ route('markets.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs shadow-xs transition-all active:scale-95">
                        <i class="fa-solid fa-map-location-dot"></i> Open Full Springfield Directory
                    </a>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="bg-white p-3 rounded-3xl shadow-sm border border-slate-200">
                    <div id="home-map" class="h-96 rounded-2xl z-10 w-full"></div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="reveal py-16 bg-white border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Direct Farm-To-Table</span>
        <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 mt-1">How Pre-Ordering Works</h2>
        <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto mt-2">Zero lines, zero food waste, and guaranteed harvest fresh quality.</p>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-12 text-left">
            <div class="p-6 rounded-3xl bg-[#fcfbf9] border border-slate-200/90 space-y-3 card-hover">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-900 flex items-center justify-center text-sm font-extrabold">
                    1
                </div>
                <h3 class="font-heading font-bold text-sm text-slate-900">Select Market & Stall</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Choose your local Springfield weekend market and browse catalogs from verified nearby family growers.
                </p>
            </div>

            <div class="p-6 rounded-3xl bg-[#fcfbf9] border border-slate-200/90 space-y-3 card-hover">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-900 flex items-center justify-center text-sm font-extrabold">
                    2
                </div>
                <h3 class="font-heading font-bold text-sm text-slate-900">Pre-Order Before Cutoff</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Place your items into the basket before the Friday evening cutoff (12h prior to market opening).
                </p>
            </div>

            <div class="p-6 rounded-3xl bg-[#fcfbf9] border border-slate-200/90 space-y-3 card-hover">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-900 flex items-center justify-center text-sm font-extrabold">
                    3
                </div>
                <h3 class="font-heading font-bold text-sm text-slate-900">Dawn Harvest & Pack</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Farmers pick the exact quantities ordered early Saturday dawn and package your designated bag.
                </p>
            </div>

            <div class="p-6 rounded-3xl bg-[#fcfbf9] border border-slate-200/90 space-y-3 card-hover">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-900 flex items-center justify-center text-sm font-extrabold">
                    4
                </div>
                <h3 class="font-heading font-bold text-sm text-slate-900">Express Stall Pickup</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Walk straight to the farm stall on market morning, inspect your produce, and settle payment in person.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="reveal py-16 bg-[#fcfbf9] border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Verified Shoppers</span>
            <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 mt-1">Community Reviews</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Feedback from neighborhood families supporting local growers.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($recentReviews as $rev)
                <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-2xs flex flex-col justify-between card-hover">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-amber-400 text-xs">
                                @for($i=1; $i<=5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= ($rev->rating ?? 0) ? '' : 'text-slate-200' }}"></i>
                                @endfor
                            </div>
                            <span class="text-[11px] text-slate-400">{{ $rev->created_at ? $rev->created_at->diffForHumans() : '' }}</span>
                        </div>
                        <p class="text-xs text-slate-700 italic leading-relaxed">"{{ $rev->comment ?? 'Great fresh produce!' }}"</p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr($rev->customer->name ?? 'C', 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-900">{{ $rev->customer->name ?? 'Customer' }}</div>
                                <div class="text-[11px] text-emerald-800 font-semibold">{{ $rev->farmer->stall_name ?? 'Farmer Stall' }}</div>
                            </div>
                        </div>

                        @if($rev->farmer_reply ?? false)
                            <div class="mt-3 bg-emerald-50/70 p-2.5 rounded-xl border border-emerald-100 text-[11px] text-slate-700">
                                <span class="font-bold text-emerald-900">Grower Note:</span> {{ $rev->farmer_reply }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-slate-400 text-sm">
                    No reviews available yet.
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="reveal py-16 bg-slate-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#15803d_1px,transparent_1px)] [background-size:16px_16px] opacity-15"></div>
    <div class="relative max-w-4xl mx-auto px-4 text-center space-y-6">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold border border-emerald-500/30">
            <i class="fa-solid fa-store"></i> Grower Partnership
        </div>
        <h2 class="font-heading font-extrabold text-2xl sm:text-4xl text-white">Are You an Independent Grower in Springfield?</h2>
        <p class="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto leading-relaxed font-normal">
            Register your stall on MarketLink to list weekly harvest stock, receive guaranteed pre-orders before market morning, and build direct relationships with local customers.
        </p>
        <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('register') }}" class="px-6 py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs sm:text-sm shadow-lg transition-all active:scale-95">
                Register Your Farm Stall
            </a>
            <a href="{{ route('markets.index') }}" class="px-6 py-3.5 rounded-2xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white font-bold text-xs sm:text-sm transition-all active:scale-95">
                Explore Market Directory
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    function updateHeroCountdown() {
        const el = document.getElementById('hero-countdown');
        if (!el) return;
        const now = new Date();
        const nextFriday = new Date();
        const day = now.getDay();
        const diff = (5 - day + 7) % 7;
        nextFriday.setDate(now.getDate() + (diff === 0 && now.getHours() >= 20 ? 7 : diff));
        nextFriday.setHours(20, 0, 0, 0);

        const totalSecs = Math.max(0, Math.floor((nextFriday - now) / 1000));
        const days = Math.floor(totalSecs / 86400);
        const hours = Math.floor((totalSecs % 86400) / 3600);
        const mins = Math.floor((totalSecs % 3600) / 60);
        const secs = totalSecs % 60;

        el.textContent = `${days}d : ${String(hours).padStart(2, '0')}h : ${String(mins).padStart(2, '0')}m : ${String(secs).padStart(2, '0')}s remaining`;
    }
    updateHeroCountdown();
    setInterval(updateHeroCountdown, 1000);

    const counters = document.querySelectorAll('.count-up');
    const animateCounters = () => {
        counters.forEach(counter => {
            const target = parseInt(counter.dataset.target || 0, 10);
            if (target === 0) return;
            let current = 0;
            const step = Math.max(1, Math.ceil(target / 30));
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    counter.textContent = target;
                    clearInterval(timer);
                } else {
                    counter.textContent = current;
                }
            }, 30);
        });
    };
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    obs.disconnect();
                }
            });
        }, { threshold: 0.3 });
        const statSection = document.querySelector('.count-up');
        if (statSection) observer.observe(statSection.parentElement);
    } else {
        animateCounters();
    }

    if (typeof L !== 'undefined' && document.getElementById('home-map')) {
        const map = L.map('home-map').setView([37.774929, -122.419416], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        @foreach($markets as $m)
            @if(!empty($m->latitude) && !empty($m->longitude))
                L.marker([{{ $m->latitude }}, {{ $m->longitude }}])
                    .addTo(map)
                    .bindPopup(`
                        <div style="min-width: 160px; font-family: sans-serif;">
                            <h4 style="font-weight: 700; margin: 0 0 4px 0; color: #16382b; font-size: 13px;">{{ $m->market_name }}</h4>
                            <p style="margin: 0; font-size: 11px; color: #64748b;">{{ $m->address }}</p>
                            <p style="margin: 2px 0 6px 0; font-size: 11px; font-weight: 600; color: #1e293b;">{{ $m->operating_days }}</p>
                            <a href="{{ route('markets.show', $m->slug) }}" style="display: inline-block; font-size: 11px; font-weight: 700; color: #1e4d2b; text-decoration: underline;">View Market Stalls &rarr;</a>
                        </div>
                    `);
            @endif
        @endforeach

        setTimeout(() => { map.invalidateSize(); }, 300);
        window.addEventListener('resize', () => { map.invalidateSize(); });
    }
});
</script>
@endpush