@extends('layouts.app')

@section('title', $farmer->stall_name . ' - Weekly Stock & Profile | MarketLink')

@section('content')

<div class="bg-gradient-to-r from-brand-900 via-brand-800 to-slate-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-5">
                <img src="{{ $farmer->avatar ?? 'https://images.unsplash.com/photo-1595273670150-bd0c3c392e46?auto=format&fit=crop&w=200&q=80' }}" alt="{{ $farmer->stall_name }}" class="w-16 h-16 sm:w-24 sm:h-24 rounded-3xl object-cover border-4 border-white/20 shadow-xl bg-white flex-shrink-0">
                <div>
                    <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                        <h1 class="font-heading font-extrabold text-2xl sm:text-4xl text-white">{{ $farmer->stall_name }}</h1>
                        @if($farmer->stall_number)
                            <span class="bg-white/10 text-white text-xs font-bold px-2.5 py-1 rounded-lg border border-white/10">
                                {{ $farmer->stall_number }}
                            </span>
                        @endif
                    </div>
                    <p class="text-xs sm:text-sm text-brand-200 mt-1 flex flex-wrap items-center gap-x-2 gap-y-0.5">
                        <span>Grower: <strong>{{ $farmer->contact_person }}</strong></span>
                        @if($farmer->market)
                            <span class="hidden sm:inline">•</span>
                            <a href="{{ route('markets.show', $farmer->market->slug) }}" class="underline hover:text-white font-semibold">
                                <i class="fa-solid fa-map-pin"></i> {{ $farmer->market->market_name }}
                            </a>
                        @endif
                    </p>
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-2 text-xs">
                        <span class="text-amber-400 font-bold flex items-center gap-1">
                            <i class="fa-solid fa-star"></i> {{ $farmer->averageRating() }} ({{ $farmer->reviews->count() }} Reviews)
                        </span>
                        <span class="hidden sm:inline">•</span>
                        <span class="text-emerald-400 font-semibold"><i class="fa-solid fa-circle-check"></i> Verified Farm Stall</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 sm:gap-3 w-full md:w-auto">
                @auth
                    <form action="{{ route('customer.favorites.toggle') }}" method="POST" class="flex-1 sm:flex-initial">
                        @csrf
                        <input type="hidden" name="type" value="farmer">
                        <input type="hidden" name="id" value="{{ $farmer->id }}">
                        <button type="submit" class="w-full sm:w-auto px-4 py-2.5 rounded-2xl {{ $isFavorite ? 'bg-rose-500 text-white' : 'bg-white/10 text-white hover:bg-white/20' }} font-bold text-xs border border-white/10 shadow-sm transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-heart {{ $isFavorite ? 'text-white' : 'text-rose-400' }}"></i>
                            <span>{{ $isFavorite ? 'Saved' : 'Favorite' }}</span>
                        </button>
                    </form>
                @endauth

                <a href="#produce-section" class="flex-1 sm:flex-initial text-center px-4 sm:px-5 py-2.5 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-lg transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-basket-shopping"></i> Pre-Order Stock
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8 sm:space-y-12">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
        <div class="p-5 sm:p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center gap-2 text-xs font-bold text-brand-700 uppercase tracking-wider">
                <i class="fa-solid fa-calendar-days"></i> Market Operating Days
            </div>
            <div class="font-heading font-extrabold text-base sm:text-lg text-slate-900">{{ $farmer->operating_days }}</div>
            <p class="text-xs text-slate-500">Stall opens on these designated market days for produce pickup.</p>
        </div>

        <div class="p-5 sm:p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center gap-2 text-xs font-bold text-brand-700 uppercase tracking-wider">
                <i class="fa-solid fa-clock"></i> Stall Pickup Windows
            </div>
            <div class="flex flex-wrap gap-1.5 pt-1">
                @foreach($farmer->pickup_slots_array as $slot)
                    <span class="bg-brand-50 text-brand-800 border border-brand-200 text-xs font-bold px-2.5 py-1 rounded-xl">
                        {{ $slot }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="p-5 sm:p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center gap-2 text-xs font-bold text-amber-700 uppercase tracking-wider">
                <i class="fa-solid fa-hourglass-half"></i> Pre-Order Cutoff Rule
            </div>
            <div class="font-heading font-extrabold text-base sm:text-lg text-slate-900">{{ $farmer->cutoff_hours_before }} Hours Before Pickup</div>
            <p class="text-xs text-slate-500">Orders must be placed or modified before this cutoff so the farmer can harvest fresh.</p>
        </div>
    </div>

    @if($farmer->bio)
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <h3 class="font-heading font-bold text-base text-slate-900 mb-2">Our Farming Heritage & Growing Philosophy</h3>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $farmer->bio }}</p>
    </div>
    @endif

    <div id="produce-section">
        <div class="flex items-center justify-between mb-6">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-widest text-brand-700">Available This Week</span>
                <h2 class="font-heading font-extrabold text-2xl text-slate-900 mt-0.5">
                    Weekly Stock Catalog ({{ $farmer->products->count() }})
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($farmer->products as $product)
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm card-hover flex flex-col justify-between">
                    <div class="relative h-48 bg-slate-100 overflow-hidden">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-brand-600 text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded-full shadow-sm">
                            {{ $product->category->name ?? 'Harvest' }}
                        </span>
                        @if($product->in_stock)
                            <span class="absolute bottom-3 right-3 bg-white/90 backdrop-blur-md text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                In Stock: {{ $product->stock_quantity }} {{ $product->unit }}
                            </span>
                        @else
                            <span class="absolute bottom-3 right-3 bg-rose-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                Sold Out
                            </span>
                        @endif
                    </div>

                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-heading font-extrabold text-base text-slate-900">
                                <a href="{{ route('products.show', $product->slug) }}" class="hover:text-brand-700 transition-colors">{{ $product->name }}</a>
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $product->description }}</p>
                            @if($product->harvest_date)
                                <div class="mt-2 text-[11px] text-brand-800 font-semibold flex items-center gap-1">
                                    <i class="fa-solid fa-leaf text-brand-600"></i> {{ $product->harvest_date }}
                                </div>
                            @endif
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 block uppercase">Stall Price</span>
                                <div class="font-heading font-extrabold text-lg text-slate-900 leading-none">
                                    ${{ number_format($product->price, 2) }}
                                    <span class="text-xs font-normal text-slate-500">/ {{ $product->unit }}</span>
                                </div>
                            </div>

                            @if($product->in_stock)
                                <button onclick="addToCartAjax({{ $product->id }}, 1)" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-600/20 transition-all flex items-center gap-1.5 active:scale-95">
                                    <i class="fa-solid fa-plus text-[10px]"></i> Add to Pre-Order
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
                <div class="col-span-full py-12 text-center text-slate-400 italic">No products listed by this farmer for this week.</div>
            @endforelse
        </div>
    </div>

    <div class="pt-8 border-t border-slate-200">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-7 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-extrabold uppercase tracking-widest text-brand-700">Customer Feedback</span>
                        <h3 class="font-heading font-extrabold text-xl text-slate-900 mt-0.5">
                            Customer Reviews ({{ $farmer->reviews->count() }})
                        </h3>
                    </div>
                    <span class="text-amber-500 font-extrabold text-sm flex items-center gap-1 bg-amber-50 px-3 py-1 rounded-xl border border-amber-200">
                        <i class="fa-solid fa-star"></i> {{ $farmer->averageRating() }} / 5.0
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse($farmer->reviews as $review)
                        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($review->customer->name ?? 'C', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900">{{ $review->customer->name ?? 'Verified Shopper' }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $review->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center text-amber-400 text-xs">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $review->rating ? '' : 'text-slate-200' }}"></i>
                                    @endfor
                                </div>
                            </div>

                            <p class="text-xs text-slate-700 leading-relaxed">{{ $review->comment }}</p>

                            @if($review->farmer_reply)
                                <div class="mt-3 bg-brand-50/70 p-3 rounded-2xl border border-brand-200/60 text-xs text-brand-900 space-y-1">
                                    <div class="font-bold text-brand-800 flex items-center gap-1">
                                        <i class="fa-solid fa-reply"></i> Reply from {{ $farmer->stall_name }}:
                                    </div>
                                    <p class="text-[11px] text-brand-800">{{ $review->farmer_reply }}</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white p-8 rounded-3xl border border-slate-200 text-center text-slate-400 text-xs">
                            No reviews yet for this farm stall. Be the first to order and leave a review!
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm sticky top-28 space-y-4">
                    <h3 class="font-heading font-extrabold text-lg text-slate-900">Leave a Review</h3>
                    <p class="text-xs text-slate-500">Rate your pre-order experience and product quality from {{ $farmer->stall_name }}.</p>

                    @auth
                        <form action="{{ route('farmers.review', $farmer->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Your Rating</label>
                                <select name="rating" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-brand-500 font-bold text-amber-500">
                                    <option value="5">⭐⭐⭐⭐⭐ 5 Stars (Exceptional)</option>
                                    <option value="4">⭐⭐⭐⭐ 4 Stars (Very Good)</option>
                                    <option value="3">⭐⭐⭐ 3 Stars (Average)</option>
                                    <option value="2">⭐⭐ 2 Stars (Below Expectation)</option>
                                    <option value="1">⭐ 1 Star (Poor)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Review Comment</label>
                                <textarea name="comment" rows="4" required placeholder="Describe produce freshness, pickup convenience, stall experience..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:outline-none focus:border-brand-500"></textarea>
                            </div>

                            <button type="submit" class="w-full py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/20 transition-all">
                                Submit Feedback
                            </button>
                        </form>
                    @else
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-3">
                            <p class="text-xs text-slate-600 font-semibold">Please log in to your MarketLink customer account to submit a review.</p>
                            <a href="{{ route('login') }}" class="inline-block px-5 py-2 rounded-xl bg-brand-600 text-white font-bold text-xs">
                                Sign In to Review
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
