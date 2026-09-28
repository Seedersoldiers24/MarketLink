@extends('layouts.dashboard')

@section('title', 'My Favorite Farmers & Produce | MarketLink')
@section('header_title', 'Saved Favorites')
@section('header_subtitle', 'Quick access to your preferred farmers and harvest items')

@section('content')
<div class="space-y-10">
    
    <div class="space-y-4">
        <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-store text-brand-600"></i> Favorite Farmers & Stalls ({{ $favFarmers->count() }})
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($favFarmers as $farmer)
                <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between card-hover">
                    <div class="flex items-center gap-3">
                        <img src="{{ $farmer->avatar ?? 'https://images.unsplash.com/photo-1595273670150-bd0c3c392e46?auto=format&fit=crop&w=150&q=80' }}" alt="{{ $farmer->stall_name }}" class="w-12 h-12 rounded-2xl object-cover border border-slate-200">
                        <div>
                            <h4 class="font-heading font-bold text-sm text-slate-900">
                                <a href="{{ route('farmers.show', $farmer->id) }}" class="hover:text-brand-700">{{ $farmer->stall_name }}</a>
                            </h4>
                            <p class="text-[11px] text-slate-500">{{ $farmer->market->market_name ?? 'Local Market' }}</p>
                        </div>
                    </div>

                    <a href="{{ route('farmers.show', $farmer->id) }}" class="px-3 py-1.5 rounded-xl bg-brand-50 hover:bg-brand-100 text-brand-800 font-bold text-xs">
                        View &rarr;
                    </a>
                </div>
            @empty
                <div class="col-span-full p-8 bg-white rounded-3xl border border-slate-200 text-center text-slate-400 text-xs">
                    No favorite farmers saved yet. Click the heart icon on any farmer profile to save them here!
                </div>
            @endforelse
        </div>
    </div>

    <div class="space-y-4">
        <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-apple-whole text-brand-600"></i> Favorite Harvest Produce ({{ $favProducts->count() }})
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($favProducts as $product)
                <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between gap-4 card-hover">
                    <div class="flex items-center gap-3">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-14 h-14 rounded-2xl object-cover border border-slate-100">
                        <div>
                            <h4 class="font-heading font-bold text-xs text-slate-900 line-clamp-1">
                                <a href="{{ route('products.show', $product->slug) }}" class="hover:text-brand-700">{{ $product->name }}</a>
                            </h4>
                            <div class="text-xs font-extrabold text-brand-700 mt-0.5">
                                ${{ number_format($product->price, 2) }} / {{ $product->unit }}
                            </div>
                        </div>
                    </div>

                    <button onclick="addToCartAjax({{ $product->id }}, 1)" class="px-3 py-1.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-sm flex-shrink-0">
                        Pre-Order
                    </button>
                </div>
            @empty
                <div class="col-span-full p-8 bg-white rounded-3xl border border-slate-200 text-center text-slate-400 text-xs">
                    No favorite products saved yet.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
