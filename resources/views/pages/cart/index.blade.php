@extends('layouts.app')

@section('title', 'Your Pre-Order Basket | MarketLink')

@section('content')
<div class="py-12 bg-slate-50 min-h-[70vh]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-widest text-brand-700">Harvest Basket</span>
            <h1 class="font-heading font-extrabold text-3xl text-slate-900 mt-1">Review Your Pre-Orders</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Produce is grouped by farmer stall for tailored pickup dates and time windows.</p>
        </div>

        @if(empty($groupedCart))
            <div class="bg-white p-16 rounded-3xl border border-slate-200 text-center space-y-4 shadow-sm">
                <div class="w-20 h-20 mx-auto rounded-3xl bg-brand-50 text-brand-600 flex items-center justify-center text-3xl">
                    <i class="fa-solid fa-basket-shopping"></i>
                </div>
                <h3 class="font-heading font-extrabold text-xl text-slate-800">Your farm basket is empty</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">Explore this week's harvest from local Springfield farmers and reserve fresh goods for pickup.</p>
                <div class="pt-2">
                    <a href="{{ route('products.index') }}" class="px-6 py-3 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/20 inline-flex items-center gap-2">
                        <i class="fa-solid fa-apple-whole"></i> Browse Farm Catalog
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-6">
                @foreach($groupedCart as $farmerId => $group)
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                        
                        <div class="p-4 bg-slate-50 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    <i class="fa-solid fa-store"></i>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-heading font-bold text-sm text-slate-900 truncate">{{ $group['farmer']->stall_name ?? 'Farmer Stall' }}</h4>
                                    <p class="text-[11px] text-slate-500 truncate">Market: {{ $group['farmer']->market->market_name ?? 'Springfield Market' }} • Operating: {{ $group['farmer']->operating_days ?? 'Weekend' }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-extrabold text-brand-700 flex-shrink-0">Subtotal: ${{ number_format($group['subtotal'], 2) }}</span>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @foreach($group['items'] as $productId => $item)
                                <div class="p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-14 h-14 rounded-2xl object-cover border border-slate-100 shadow-sm flex-shrink-0">
                                        <div>
                                            <h5 class="text-sm font-bold text-slate-900">
                                                <a href="{{ route('products.show', $item['slug']) }}" class="hover:text-brand-700">{{ $item['name'] }}</a>
                                            </h5>
                                            <div class="text-xs text-slate-500 mt-0.5">
                                                ${{ number_format($item['price'], 2) }} / {{ $item['unit'] }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 sm:gap-6 w-full sm:w-auto justify-between sm:justify-end pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                                        
                                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center gap-1">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99" class="w-14 bg-slate-50 border border-slate-200 rounded-xl p-1.5 text-xs text-center font-bold">
                                            <button type="submit" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs" title="Update Quantity">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                            </button>
                                        </form>

                                        <div class="font-heading font-extrabold text-sm text-slate-900 w-auto sm:w-20 text-right">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </div>

                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                            <button type="submit" class="text-slate-400 hover:text-rose-500 p-1.5 transition-colors">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-5 sm:gap-6">
                    <div>
                        <div class="text-xs text-slate-500 font-semibold">Total Pre-Order Amount (Pay at Pickup)</div>
                        <div class="font-heading font-extrabold text-2xl sm:text-3xl text-brand-800">
                            ${{ number_format($total, 2) }}
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3 w-full sm:w-auto">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full sm:w-auto px-4 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors text-center">
                                Clear Basket
                            </button>
                        </form>

                        <a href="{{ route('orders.checkout') }}" class="w-full sm:w-auto px-6 sm:px-8 py-3.5 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs shadow-lg shadow-brand-600/20 transition-all flex items-center justify-center gap-2 text-center">
                            <span>Proceed to Pickup Schedule</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
