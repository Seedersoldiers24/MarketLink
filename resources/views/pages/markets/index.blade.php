@extends('layouts.app')

@section('title', 'Farmers Markets Directory - Live Map & Operating Days | MarketLink')

@section('content')
<div class="bg-gradient-to-b from-brand-50/50 to-slate-50 py-10 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-100 text-brand-800 text-xs font-bold uppercase tracking-wider mb-2">
                    <i class="fa-solid fa-map-location-dot"></i> OpenStreetMap Geolocation
                </div>
                <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900">Farmers Markets Directory</h1>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">Discover weekly farmers markets across Springfield, check operating days, and navigate to pickup stalls.</p>
            </div>

            <form action="{{ route('markets.index') }}" method="GET" class="w-full md:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                <div class="relative w-full sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search market or address..." class="w-full bg-white border border-slate-200 rounded-2xl px-3.5 py-2 pl-9 text-xs focus:outline-none focus:border-brand-500 shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                </div>

                <div class="flex items-center gap-2">
                    <select name="day" onchange="this.form.submit()" class="flex-1 sm:flex-initial bg-white border border-slate-200 rounded-2xl px-3 py-2 text-xs focus:outline-none focus:border-brand-500 shadow-sm font-semibold text-slate-700">
                        <option value="">All Days</option>
                        <option value="Saturday" {{ request('day') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                        <option value="Sunday" {{ request('day') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        <option value="Wednesday" {{ request('day') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="Tuesday" {{ request('day') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="Friday" {{ request('day') == 'Friday' ? 'selected' : '' }}>Friday</option>
                    </select>

                    <button type="submit" class="px-4 py-2 rounded-2xl bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs shadow-sm">
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'day']))
                        <a href="{{ route('markets.index') }}" class="px-3 py-2 rounded-2xl bg-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-300">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    
    <div class="bg-white p-3 sm:p-5 rounded-3xl shadow-lg border border-slate-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-3 px-1 sm:px-2">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                <i class="fa-solid fa-earth-americas text-brand-600"></i> Interactive Market Geolocation Map
            </div>
            <span class="text-[10px] sm:text-[11px] text-slate-400">Click any green marker to view stall information and directions</span>
        </div>
        <div id="directory-map" class="h-64 sm:h-80 md:h-96 rounded-2xl w-full z-10 border border-slate-100"></div>
    </div>

    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-heading font-extrabold text-xl text-slate-900">
                Found Markets ({{ $markets->total() }})
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($markets as $market)
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm card-hover flex flex-col justify-between">
                    <div>
                        
                        <div class="relative h-48 overflow-hidden bg-slate-100">
                            <img src="{{ $market->image }}" alt="{{ $market->market_name }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                            <span class="absolute top-3 left-3 bg-brand-600 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                {{ $market->city }}
                            </span>
                            <div class="absolute bottom-3 left-3 right-3 text-white">
                                <h3 class="font-heading font-extrabold text-lg line-clamp-1 leading-snug">
                                    {{ $market->market_name }}
                                </h3>
                            </div>
                        </div>

                        <div class="p-5 space-y-3">
                            <div class="flex items-start gap-2 text-xs text-slate-600">
                                <i class="fa-solid fa-location-dot text-brand-600 mt-0.5"></i>
                                <span>{{ $market->address }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-xs pt-2 border-t border-slate-100">
                                <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                                    <span class="text-[10px] text-slate-400 font-bold block uppercase">Operating Days</span>
                                    <span class="font-bold text-slate-800 text-[11px]">{{ $market->operating_days }}</span>
                                </div>
                                <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                                    <span class="text-[10px] text-slate-400 font-bold block uppercase">Market Timings</span>
                                    <span class="font-bold text-slate-800 text-[11px]">{{ $market->timings }}</span>
                                </div>
                            </div>

                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed pt-1">
                                {{ $market->description }}
                            </p>
                        </div>
                    </div>

                    <div class="p-5 pt-0 flex items-center justify-between border-t border-slate-100 mt-2">
                        <span class="text-xs font-bold text-brand-700">
                            <i class="fa-solid fa-store mr-1"></i> {{ $market->farmers_count }} Stalls Present
                        </span>
                        <a href="{{ route('markets.show', $market->slug) }}" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/20 transition-all flex items-center gap-1.5">
                            <span>View Stalls</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-500">
                    <i class="fa-solid fa-store-slash text-4xl text-slate-300 mb-3"></i>
                    <p class="font-bold text-base">No markets matched your search criteria.</p>
                    <a href="{{ route('markets.index') }}" class="text-xs text-brand-700 underline font-semibold mt-2 inline-block">Reset filters</a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $markets->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const markersData = @json($mapMarkers);

        // Center around the first market or Springfield defaults
        const centerLat = markersData.length ? markersData[0].lat : 37.774929;
        const centerLng = markersData.length ? markersData[0].lng : -122.419416;

        const map = L.map('directory-map').setView([centerLat, centerLng], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        markersData.forEach(item => {
            const popupContent = `
                <div style="min-width: 180px;">
                    <h4 style="font-weight: 700; color: #15803d; font-size: 13px; margin: 0 0 4px 0;">${item.name}</h4>
                    <p style="margin: 0; font-size: 11px; color: #475569;">${item.address}</p>
                    <div style="margin: 6px 0; font-size: 11px; font-weight: 600; color: #0f172a;">
                        <span style="display: block;">📅 ${item.days}</span>
                        <span style="display: block;">⏰ ${item.timings}</span>
                    </div>
                    <a href="${item.url}" style="display: inline-block; padding: 4px 10px; background: #15803d; color: #ffffff; border-radius: 6px; font-size: 10px; font-weight: 700; text-decoration: none;">View Market & Stalls &rarr;</a>
                </div>
            `;

            L.marker([item.lat, item.lng])
                .addTo(map)
                .bindPopup(popupContent);
        });
        setTimeout(() => {
            map.invalidateSize();
        }, 300);

        window.addEventListener('resize', () => {
            map.invalidateSize();
        });
    });
</script>
@endpush
