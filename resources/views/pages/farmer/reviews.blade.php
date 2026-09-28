@extends('layouts.dashboard')

@section('title', 'Customer Reviews & Feedback | ' . $farmer->stall_name)
@section('header_title', 'Customer Ratings & Reviews')
@section('header_subtitle', 'Monitor customer feedback, star ratings, and post verified grower replies')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <h3 class="font-heading font-extrabold text-base text-slate-900">Total Reviews Received</h3>
            <p class="text-xs text-slate-500">Shoppers leave verified ratings after their weekend pickup</p>
        </div>
        <div class="text-right">
            <div class="flex items-center gap-1.5 text-amber-500 font-heading font-extrabold text-2xl">
                <i class="fa-solid fa-star"></i>
                <span>{{ $farmer->averageRating() }}</span>
            </div>
            <span class="text-xs text-slate-400 font-medium">Average Rating</span>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($reviews as $review)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="flex items-start justify-between gap-4 pb-3 border-b border-slate-100">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-slate-900">{{ $review->customer->name ?? 'Verified Buyer' }}</span>
                            <span class="text-[11px] text-slate-400">• {{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($review->product)
                            <div class="text-[11px] text-brand-700 font-semibold mt-0.5">
                                Product: {{ $review->product->name }}
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center text-amber-400 text-xs">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="fa-solid fa-star"></i>
                            @else
                                <i class="fa-regular fa-star text-slate-200"></i>
                            @endif
                        @endfor
                    </div>
                </div>

                <p class="text-xs text-slate-600 leading-relaxed">
                    {{ $review->comment }}
                </p>

                @if($review->farmer_reply)
                    <div class="p-3 bg-brand-50/70 border border-brand-200 rounded-2xl text-xs space-y-1">
                        <div class="font-bold text-brand-900 text-[11px] flex items-center gap-1.5">
                            <i class="fa-solid fa-reply text-brand-700"></i> Your Stall Reply
                            <span class="font-normal text-slate-400 text-[10px]">({{ $review->farmer_replied_at ? \Carbon\Carbon::parse($review->farmer_replied_at)->format('M d, Y') : '' }})</span>
                        </div>
                        <p class="text-brand-950">{{ $review->farmer_reply }}</p>
                    </div>
                @else
                    
                    <form action="{{ route('farmer.reviews.reply', $review->id) }}" method="POST" class="pt-2 flex items-center gap-2">
                        @csrf
                        <input type="text" name="farmer_reply" required placeholder="Write a response to this review..." class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-brand-500">
                        <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-all whitespace-nowrap">
                            Post Reply
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div class="p-12 text-center bg-white rounded-3xl border border-slate-200 text-slate-400 space-y-3">
                <i class="fa-regular fa-star text-4xl text-slate-300"></i>
                <div class="text-sm font-bold text-slate-700">No customer reviews yet.</div>
                <p class="text-xs text-slate-400">When customers complete order pickups at your stall, their ratings will display here.</p>
            </div>
        @endforelse
    </div>

    <div class="pt-4">
        {{ $reviews->links() }}
    </div>
</div>
@endsection
