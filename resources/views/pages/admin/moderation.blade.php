@extends('layouts.dashboard')

@section('title', 'Content Moderation | MarketLink Admin')
@section('header_title', 'Marketplace Content Moderation')
@section('header_subtitle', 'Review and moderate farmer produce listings, customer reviews, and inappropriate content')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-star text-amber-500"></i> Recent Reviews
            </h3>

            <div class="divide-y divide-slate-100 text-xs">
                @forelse($reviews as $rev)
                    <div class="py-3 flex items-start justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900">{{ $rev->customer->name ?? 'Buyer' }}</span>
                                <span class="text-amber-500 font-bold">★ {{ $rev->rating }}</span>
                            </div>
                            <p class="text-slate-600 italic">"{{ $rev->comment }}"</p>
                            <div class="text-[11px] text-slate-400">For: {{ $rev->product->product_name ?? 'Product' }} ({{ $rev->farmer->stall_name ?? 'Farmer' }})</div>
                        </div>
                        <form action="{{ route('admin.moderation.review.delete', $rev->id) }}" method="POST" onsubmit="return confirm('Delete review?');">
                            @csrf
                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold text-[11px]">
                                Remove
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400">No reviews to moderate.</div>
                @endforelse
            </div>
            {{ $reviews->links() }}
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-basket-shopping text-brand-600"></i> Produce Catalog Moderation
            </h3>

            <div class="divide-y divide-slate-100 text-xs">
                @forelse($products as $prod)
                    <div class="py-3 flex items-center justify-between gap-3">
                        <div class="space-y-1">
                            <div class="font-bold text-slate-900">{{ $prod->product_name }}</div>
                            <div class="text-slate-500">{{ $prod->farmer->stall_name ?? 'Stall' }} • ${{ number_format($prod->price, 2) }}/{{ $prod->unit }}</div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">{{ $prod->category->name ?? 'Category' }}</span>
                        </div>
                        <form action="{{ route('admin.moderation.product.delete', $prod->id) }}" method="POST" onsubmit="return confirm('Remove product from platform?');">
                            @csrf
                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold text-[11px]">
                                Remove
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400">No products found.</div>
                @endforelse
            </div>
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
