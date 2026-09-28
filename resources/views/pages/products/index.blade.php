@extends('layouts.app')

@section('title', 'Browse Farm Produce - Fresh Vegetables, Fruits, Breads & Dairy | MarketLink')

@section('content')

<div class="bg-gradient-to-b from-brand-50/50 to-slate-50 py-10 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-100 text-brand-800 text-xs font-bold uppercase tracking-wider mb-2">
                <i class="fa-solid fa-basket-shopping"></i> Weekly Harvest Catalog
            </div>
            <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900">Explore Farm Produce</h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">Direct from local growers. Reserve pre-orders today to guarantee fresh harvest on weekend market day.</p>
        </div>

        <div class="mt-6 flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
            <a href="{{ route('products.index', array_merge(request()->except('category', 'page'))) }}" class="px-4 py-2 rounded-2xl text-xs font-bold whitespace-nowrap transition-all {{ !request('category') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                All Categories
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('products.index', array_merge(request()->except('category', 'page'), ['category' => $cat->slug])) }}" class="px-4 py-2 rounded-2xl text-xs font-bold whitespace-nowrap transition-all {{ request('category') == $cat->slug ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                    {{ $cat->name }} ({{ $cat->products_count }})
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <div class="lg:col-span-3 w-full">
            
            <div class="lg:hidden mb-4 flex items-center justify-between gap-2.5">
                <button type="button" onclick="toggleProductFilters()" class="flex-1 py-3 px-4 rounded-2xl bg-white border border-slate-200 text-xs font-bold text-slate-800 shadow-xs flex items-center justify-between active:scale-[0.99] transition-all">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-brand-600"></i>
                        <span>Filters & Search</span>
                    </span>
                    <span class="flex items-center gap-2">
                        @php
                            $activeFilterCount = count(array_filter(request()->only(['search', 'market_id', 'day', 'min_price', 'max_price', 'in_stock'])));
                        @endphp
                        @if($activeFilterCount > 0)
                            <span class="px-2 py-0.5 rounded-full bg-brand-600 text-white text-[10px] font-extrabold">{{ $activeFilterCount }} active</span>
                        @endif
                        <i id="filter-chevron" class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                    </span>
                </button>

                @if(request()->hasAny(['search', 'category', 'market_id', 'day', 'min_price', 'max_price', 'in_stock', 'sort']))
                    <a href="{{ route('products.index') }}" class="px-3.5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs shrink-0">
                        Reset
                    </a>
                @endif
            </div>

            <div id="product-filters-panel" class="hidden lg:block">
                <form action="{{ route('products.index') }}" method="GET" class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm space-y-5 sm:space-y-6 lg:sticky lg:top-28">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <span class="font-heading font-bold text-sm text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-sliders text-brand-600"></i> Search Filters
                        </span>
                        @if(request()->hasAny(['search', 'category', 'market_id', 'day', 'min_price', 'max_price', 'in_stock', 'sort']))
                            <a href="{{ route('products.index') }}" class="text-[11px] font-bold text-rose-600 hover:underline">Reset</a>
                        @endif
                    </div>

                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Keyword Search</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="e.g. sourdough, tomato..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 pl-8 text-xs focus:outline-none focus:border-brand-500 font-medium">
                            <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-2.5 text-slate-400 text-xs"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Farmers Market</label>
                        <select name="market_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs focus:outline-none focus:border-brand-500 font-medium">
                            <option value="">All Markets</option>
                            @foreach($markets as $m)
                                <option value="{{ $m->id }}" {{ request('market_id') == $m->id ? 'selected' : '' }}>{{ $m->market_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Market Operating Day</label>
                        <select name="day" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs focus:outline-none focus:border-brand-500 font-medium">
                            <option value="">Any Day</option>
                            <option value="Saturday" {{ request('day') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                            <option value="Sunday" {{ request('day') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                            <option value="Wednesday" {{ request('day') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                            <option value="Tuesday" {{ request('day') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                            <option value="Friday" {{ request('day') == 'Friday' ? 'selected' : '' }}>Friday</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Price Range ($)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" step="0.5" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs focus:outline-none focus:border-brand-500 font-mono">
                            <input type="number" step="0.5" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs focus:outline-none focus:border-brand-500 font-mono">
                        </div>
                    </div>

                    <div class="pt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600 focus:ring-brand-500">
                            <span class="text-xs font-bold text-slate-700">In Stock Only</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Sort Produce By</label>
                        <select name="sort" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs focus:outline-none focus:border-brand-500 font-medium">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Harvest</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/20 transition-all active:scale-[0.99]">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-9 space-y-6">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">
                    Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} produce items
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm card-hover flex flex-col justify-between">
                        
                        <div class="relative h-48 bg-slate-100 overflow-hidden">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            <span class="absolute top-3 left-3 bg-brand-600 text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded-full shadow-sm">
                                {{ $product->category->name ?? 'Harvest' }}
                            </span>
                            @if($product->in_stock)
                                <span class="absolute bottom-3 right-3 bg-white/90 backdrop-blur-md text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                    {{ $product->stock_quantity }} {{ $product->unit }} left
                                </span>
                            @else
                                <span class="absolute bottom-3 right-3 bg-rose-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                    Sold Out
                                </span>
                            @endif
                        </div>

                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <a href="{{ route('farmers.show', $product->farmer_id) }}" class="text-[11px] font-bold text-brand-700 hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-store text-[10px]"></i> {{ $product->farmer->stall_name ?? 'Local Farm' }}
                                </a>
                                <h3 class="font-heading font-extrabold text-base text-slate-900 mt-1 line-clamp-1 hover:text-brand-700 transition-colors">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $product->description }}</p>
                                
                                <div class="mt-2 text-[10px] text-slate-400 flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-pin text-slate-400"></i>
                                    <span>{{ $product->farmer->market->market_name ?? 'Springfield Market' }}</span>
                                </div>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 block uppercase">Price</span>
                                    <div class="font-heading font-extrabold text-lg text-slate-900 leading-none">
                                        ${{ number_format($product->price, 2) }}
                                        <span class="text-xs font-normal text-slate-500">/ {{ $product->unit }}</span>
                                    </div>
                                </div>

                                @if($product->in_stock)
                                    <button onclick="addToCartAjax({{ $product->id }}, 1)" class="px-3.5 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-600/20 transition-all flex items-center gap-1.5 active:scale-95">
                                        <i class="fa-solid fa-plus text-[10px]"></i> Pre-Order
                                    </button>
                                @else
                                    <button disabled class="px-3 py-2 rounded-xl bg-slate-100 text-slate-400 text-xs font-bold cursor-not-allowed">
                                        Sold Out
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-500 bg-white rounded-3xl border border-slate-200">
                        <i class="fa-solid fa-leaf text-4xl text-slate-300 mb-3"></i>
                        <p class="font-bold text-base">No produce matched your search and filters.</p>
                        <a href="{{ route('products.index') }}" class="text-xs text-brand-700 underline font-semibold mt-2 inline-block">Clear all filters</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleProductFilters() {
    const panel = document.getElementById('product-filters-panel');
    const chevron = document.getElementById('filter-chevron');
    if (!panel) return;
    panel.classList.toggle('hidden');
    if (chevron) chevron.classList.toggle('rotate-180');
}
</script>
@endpush
