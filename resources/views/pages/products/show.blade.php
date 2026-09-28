@extends('layouts.app')

@section('title', $product->name . ' - ' . ($product->farmer->stall_name ?? 'Farm Fresh') . ' | MarketLink')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-brand-700">Home</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="{{ route('products.index') }}" class="hover:text-brand-700">Produce Catalog</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-slate-800">{{ $product->name }}</span>
        </nav>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-5 sm:p-8 lg:p-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
                
                <div class="lg:col-span-6 relative">
                    <div class="h-64 sm:h-80 lg:h-96 rounded-3xl overflow-hidden bg-slate-100 shadow-inner">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                    <span class="absolute top-3 sm:top-4 left-3 sm:left-4 bg-brand-600 text-white text-[11px] sm:text-xs font-extrabold px-3 py-1 rounded-full shadow-md">
                        {{ $product->category->name ?? 'Harvest' }}
                    </span>
                    @if($product->in_stock)
                        <span class="absolute bottom-3 sm:bottom-4 right-3 sm:right-4 bg-white/95 backdrop-blur-md text-emerald-800 text-[11px] sm:text-xs font-bold px-3 py-1.5 rounded-xl shadow-md border border-slate-200 max-w-[90%] truncate">
                            <i class="fa-solid fa-check text-emerald-500"></i> {{ $product->stock_quantity }} {{ $product->unit }} Available for Pickup
                        </span>
                    @else
                        <span class="absolute bottom-3 sm:bottom-4 right-3 sm:right-4 bg-rose-600 text-white text-[11px] sm:text-xs font-bold px-3 py-1.5 rounded-xl shadow-md">
                            Currently Sold Out
                        </span>
                    @endif
                </div>

                <div class="lg:col-span-6 flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        
                        <div class="flex items-center justify-between flex-wrap gap-2">
                            <a href="{{ route('farmers.show', $product->farmer_id) }}" class="text-xs font-bold text-brand-700 hover:underline flex items-center gap-1.5">
                                <i class="fa-solid fa-store"></i> {{ $product->farmer->stall_name ?? 'Local Farm Stall' }}
                            </a>
                            <span class="text-amber-500 font-extrabold text-xs flex items-center gap-1">
                                <i class="fa-solid fa-star"></i> {{ $product->averageRating() }} ({{ $product->reviews->count() }} Reviews)
                            </span>
                        </div>

                        <h1 class="font-heading font-extrabold text-2xl sm:text-4xl text-slate-900 leading-tight">
                            {{ $product->name }}
                        </h1>

                        <div class="flex items-baseline gap-2">
                            <span class="font-heading font-extrabold text-2xl sm:text-3xl text-brand-700">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            <span class="text-xs sm:text-sm font-semibold text-slate-500">per {{ $product->unit }}</span>
                        </div>

                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            {{ $product->description ?? 'Direct from the morning harvest. Fresh, clean, and packed with nutrients. Reserve online to guarantee your supply at this weekend\'s market pickup.' }}
                        </p>

                        <div class="p-3.5 sm:p-4 rounded-2xl bg-brand-50/60 border border-brand-200/60 space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-brand-900 font-semibold flex items-center gap-1.5">
                                    <i class="fa-solid fa-calendar-check text-brand-600"></i> Harvest Schedule:
                                </span>
                                <span class="font-bold text-brand-900 text-right">{{ $product->harvest_date ?? 'Harvested 24h prior to market' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-brand-900 font-semibold flex items-center gap-1.5">
                                    <i class="fa-solid fa-hourglass-half text-amber-600"></i> Stall Cutoff Window:
                                </span>
                                <span class="font-bold text-brand-900 text-right">{{ $product->farmer->cutoff_hours_before ?? 12 }}h prior to market start</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-5 sm:pt-6 border-t border-slate-100 space-y-4">
                        @if($product->in_stock)
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                                <div class="flex items-center justify-center border border-slate-200 rounded-2xl bg-slate-50 p-1 shrink-0">
                                    <button type="button" onclick="decrementQty()" class="w-10 h-10 rounded-xl bg-white text-slate-700 font-bold hover:bg-slate-100 shadow-xs flex items-center justify-center active:scale-95 transition-all">
                                        <i class="fa-solid fa-minus text-xs"></i>
                                    </button>
                                    <input type="number" id="detail-qty" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-14 text-center bg-transparent text-sm font-bold text-slate-900 focus:outline-none font-mono">
                                    <button type="button" onclick="incrementQty()" class="w-10 h-10 rounded-xl bg-white text-slate-700 font-bold hover:bg-slate-100 shadow-xs flex items-center justify-center active:scale-95 transition-all">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                    </button>
                                </div>

                                <button onclick="addToCartAjax({{ $product->id }}, parseInt(document.getElementById('detail-qty').value))" class="flex-1 py-3.5 px-6 rounded-2xl bg-gradient-to-r from-brand-700 to-brand-600 hover:from-brand-800 hover:to-brand-700 text-white font-bold text-xs sm:text-sm shadow-lg shadow-brand-700/20 transition-all flex items-center justify-center gap-2 active:scale-95">
                                    <i class="fa-solid fa-basket-shopping"></i> Add to Pre-Order Basket
                                </button>
                            </div>
                        @else
                            <button disabled class="w-full py-3.5 rounded-2xl bg-slate-100 text-slate-400 font-bold text-xs sm:text-sm cursor-not-allowed">
                                This Harvest is Currently Sold Out
                            </button>
                        @endif

                        <div class="flex flex-col sm:flex-row items-center justify-between text-[11px] sm:text-xs text-slate-500 pt-2 gap-1 text-center sm:text-left">
                            <span><i class="fa-solid fa-shield-heart text-brand-600 mr-1"></i> Cash or Card on Stall Pickup</span>
                            <span><i class="fa-solid fa-rotate-left text-brand-600 mr-1"></i> Cancel before cutoff</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center gap-4 sm:gap-5">
                <img src="{{ $product->farmer->avatar ?? 'https://images.unsplash.com/photo-1595273670150-bd0c3c392e46?auto=format&fit=crop&w=150&q=80' }}" alt="{{ $product->farmer->stall_name }}" class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl object-cover border-2 border-brand-500 shadow-md shrink-0">
                <div>
                    <h3 class="font-heading font-extrabold text-base sm:text-lg text-slate-900">
                        {{ $product->farmer->stall_name }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Operating at: <strong class="text-slate-800">{{ $product->farmer->market->market_name ?? 'Local Market' }}</strong> ({{ $product->farmer->operating_days }})
                    </p>
                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">{{ $product->farmer->bio }}</p>
                </div>
            </div>
            <a href="{{ route('farmers.show', $product->farmer_id) }}" class="w-full sm:w-auto text-center px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs whitespace-nowrap transition-colors">
                View Stall & All Produce &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pt-6">
            <div class="lg:col-span-7 space-y-6">
                <h3 class="font-heading font-extrabold text-xl text-slate-900">Customer Reviews for {{ $product->name }}</h3>
                <div class="space-y-4">
                    @forelse($product->reviews as $review)
                        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-900">{{ $review->customer->name ?? 'Shopper' }}</span>
                                <div class="flex items-center text-amber-400 text-xs">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $review->rating ? '' : 'text-slate-200' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $review->comment }}</p>
                            @if($review->farmer_reply)
                                <div class="p-2.5 rounded-xl bg-brand-50 border border-brand-200/60 text-[11px] text-brand-900">
                                    <strong>Farmer Reply:</strong> {{ $review->farmer_reply }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-6 bg-white rounded-3xl border border-slate-200 text-center text-xs text-slate-400">
                            No reviews yet for this product.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="font-heading font-bold text-base text-slate-900">Review this Produce</h4>
                    @auth
                        <form action="{{ route('products.review', $product->slug) }}" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Rating</label>
                                <select name="rating" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs font-bold text-amber-500">
                                    <option value="5">⭐⭐⭐⭐⭐ 5 Stars</option>
                                    <option value="4">⭐⭐⭐⭐ 4 Stars</option>
                                    <option value="3">⭐⭐⭐ 3 Stars</option>
                                    <option value="2">⭐⭐ 2 Stars</option>
                                    <option value="1">⭐ 1 Star</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Comment</label>
                                <textarea name="comment" rows="3" required placeholder="Taste, freshness, texture..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-brand-500"></textarea>
                            </div>
                            <button type="submit" class="w-full py-2.5 rounded-xl bg-brand-600 text-white font-bold text-xs hover:bg-brand-700 shadow-md">
                                Submit Review
                            </button>
                        </form>
                    @else
                        <p class="text-xs text-slate-500">Log in to leave a review for this product.</p>
                        <a href="{{ route('login') }}" class="block text-center py-2 rounded-xl bg-brand-600 text-white font-bold text-xs">Sign In</a>
                    @endauth
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function incrementQty() {
        const input = document.getElementById('detail-qty');
        const max = parseInt(input.getAttribute('max')) || 99;
        let val = parseInt(input.value) || 1;
        if (val < max) input.value = val + 1;
    }

    function decrementQty() {
        const input = document.getElementById('detail-qty');
        let val = parseInt(input.value) || 1;
        if (val > 1) input.value = val - 1;
    }
</script>
@endpush
