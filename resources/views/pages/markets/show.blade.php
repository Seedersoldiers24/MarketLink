@extends('layouts.app')

@section('title', $market->market_name . ' - Stalls & Pickup Map | MarketLink')

@section('content')

<div class="relative bg-slate-900 text-white py-16 overflow-hidden">
    <div class="absolute inset-0 opacity-25">
        <img src="{{ $market->image }}" alt="{{ $market->market_name }}" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/80 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-3">
                <a href="{{ route('markets.index') }}" class="inline-flex items-center gap-1.5 text-xs text-brand-300 hover:text-white font-semibold transition-colors">
                    <i class="fa-solid fa-arrow-left"></i> All Markets Directory
                </a>
                <h1 class="font-heading font-extrabold text-3xl sm:text-5xl text-white tracking-tight">
                    {{ $market->market_name }}
                </h1>
                <p class="text-sm text-slate-300 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-brand-400"></i> {{ $market->address }}, {{ $market->city }}
                </p>
            </div>

            <div class="flex flex-wrap sm:flex-nowrap items-stretch sm:items-center gap-2 sm:gap-3 w-full md:w-auto">
                <div class="flex-1 sm:flex-initial p-2.5 sm:p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/10 text-xs">
                    <span class="text-brand-300 block text-[10px] uppercase font-bold">Operating Days</span>
                    <span class="font-bold text-white text-xs sm:text-sm">{{ $market->operating_days }}</span>
                </div>
                <div class="flex-1 sm:flex-initial p-2.5 sm:p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/10 text-xs">
                    <span class="text-brand-300 block text-[10px] uppercase font-bold">Timings</span>
                    <span class="font-bold text-white text-xs sm:text-sm">{{ $market->timings }}</span>
                </div>
                <a href="https://www.google.com/maps/search/?api=1&query={{ $market->latitude }},{{ $market->longitude }}" target="_blank" class="w-full sm:w-auto px-4 sm:px-5 py-2.5 sm:py-3 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-lg transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-diamond-turn-right"></i> Open Directions
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="font-heading font-bold text-lg text-slate-900">About this Market</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    {{ $market->description ?? 'A vibrant community market bringing together regional farmers, bakers, and artisans. Pre-order online and collect directly from the stall during scheduled pickup windows.' }}
                </p>

                <div class="space-y-3 pt-4 border-t border-slate-100 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Map Geolocation Provider:</span>
                        <span class="font-bold text-slate-800">{{ $market->map_provider }} (Leaflet)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Latitude / Longitude:</span>
                        <span class="font-mono text-slate-700 font-medium">{{ $market->latitude }}, {{ $market->longitude }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Active Farmer Stalls:</span>
                        <span class="font-bold text-brand-700">{{ $market->farmers->count() }} Registered Stalls</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7">
            <div class="bg-white p-3 rounded-3xl shadow-sm border border-slate-200">
                <div id="single-market-map" class="h-64 sm:h-80 md:h-96 rounded-2xl w-full z-10 border border-slate-100"></div>
            </div>
        </div>
    </div>

    <div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 sm:mb-8">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-widest text-brand-700">Vendor Directory</span>
                <h2 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900 mt-0.5">
                    Farmer Stalls at {{ $market->market_name }} ({{ $market->farmers->count() }})
                </h2>
            </div>
            <a href="{{ route('farmers.index', ['market_id' => $market->id]) }}" class="text-xs font-bold text-brand-700 hover:underline">
                View All Stalls &rarr;
            </a>
        </div>

        <div class="space-y-8">
            @forelse($market->farmers as $farmer)
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 card-hover">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <img src="{{ $farmer->avatar ?? 'https://images.unsplash.com/photo-1595273670150-bd0c3c392e46?auto=format&fit=crop&w=150&q=80' }}" alt="{{ $farmer->stall_name }}" class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl object-cover border-2 border-brand-500 shadow-sm flex-shrink-0">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-heading font-extrabold text-base sm:text-lg text-slate-900">
                                        <a href="{{ route('farmers.show', $farmer->id) }}" class="hover:text-brand-700 transition-colors">{{ $farmer->stall_name }}</a>
                                    </h3>
                                    @if($farmer->stall_number)
                                        <span class="bg-slate-100 text-slate-700 text-[10px] font-extrabold px-2 py-0.5 rounded-md border border-slate-200">
                                            {{ $farmer->stall_number }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-500 flex flex-wrap items-center gap-x-2 gap-y-0.5 mt-0.5">
                                    <span>Grower: <strong class="text-slate-700">{{ $farmer->contact_person }}</strong></span>
                                    <span class="hidden sm:inline">•</span>
                                    <span>Operating: <strong>{{ $farmer->operating_days }}</strong></span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-start">
                            <span class="text-amber-500 text-xs font-extrabold flex items-center gap-1 bg-amber-50 px-3 py-1.5 rounded-xl border border-amber-200">
                                <i class="fa-solid fa-star"></i> {{ $farmer->averageRating() }} ({{ $farmer->reviews->count() }} reviews)
                            </span>
                            <a href="{{ route('farmers.show', $farmer->id) }}" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors">
                                View Stall &rarr;
                            </a>
                        </div>
                    </div>

                    <div class="pt-5">
                        <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-3">Available for Pickup Pre-Order:</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @forelse($farmer->products as $prod)
                                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center gap-3">
                                    <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <h5 class="text-xs font-bold text-slate-900 truncate">
                                            <a href="{{ route('products.show', $prod->slug) }}" class="hover:text-brand-700">{{ $prod->name }}</a>
                                        </h5>
                                        <div class="text-xs font-extrabold text-brand-700 mt-0.5">
                                            ${{ number_format($prod->price, 2) }} <span class="text-[10px] font-normal text-slate-500">/ {{ $prod->unit }}</span>
                                        </div>
                                    </div>
                                    <button onclick="addToCartAjax({{ $prod->id }}, 1)" class="w-8 h-8 rounded-xl bg-brand-600 hover:bg-brand-700 text-white flex items-center justify-center text-xs shadow-sm flex-shrink-0" title="Add to Pre-Order">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            @empty
                                <div class="col-span-full text-xs text-slate-400 italic">No products listed currently for this stall.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 rounded-3xl text-center text-slate-500 border border-slate-200">
                    <p class="font-bold">No farmer stalls currently registered for this market.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const lat = {{ $market->latitude }};
        const lng = {{ $market->longitude }};
        const map = L.map('single-market-map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng])
            .addTo(map)
            .bindPopup(`
                <div style="font-family: inherit;">
                    <h4 style="font-weight: 700; color: #15803d; font-size: 13px; margin: 0 0 2px 0;">{{ $market->market_name }}</h4>
                    <p style="margin: 0; font-size: 11px; color: #64748b;">{{ $market->address }}</p>
                    <p style="margin: 4px 0 0 0; font-size: 11px; font-weight: 600;">{{ $market->operating_days }} • {{ $market->timings }}</p>
                </div>
            `)
            .openPopup();

        setTimeout(() => {
            map.invalidateSize();
        }, 300);

        window.addEventListener('resize', () => {
            map.invalidateSize();
        });
    });
</script>
@endpush
