@extends('layouts.app')

@section('title', 'Pre-Order Confirmed #' . $order->order_number . ' | MarketLink')

@section('content')
<div class="py-16 bg-slate-50 min-h-[75vh]">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden p-5 sm:p-8 md:p-12 text-center space-y-5 sm:space-y-6 animate-fade-in">
            
            <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl sm:text-4xl shadow-md shadow-emerald-500/20 animate-bounce">
                <i class="fa-solid fa-check"></i>
            </div>

            <div>
                <span class="text-xs font-extrabold uppercase tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    Pre-Order Confirmed
                </span>
                <h1 class="font-heading font-extrabold text-2xl sm:text-4xl text-slate-900 mt-3">
                    Thank You, {{ $order->customer->name }}!
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Your pre-order has been transmitted to the grower. They will harvest and prepare your basket for pickup.
                </p>
            </div>

            <div class="p-4 sm:p-6 rounded-2xl bg-slate-50 border border-slate-200 text-left space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Order Number</span>
                        <span class="font-mono font-extrabold text-sm sm:text-base text-brand-800">{{ $order->order_number }}</span>
                    </div>
                    <span class="text-xs font-bold px-2.5 sm:px-3 py-1 rounded-xl bg-amber-100 text-amber-800 border border-amber-300">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Farmer Stall</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $order->farmer->stall_name }}</span>
                        <span class="text-slate-500 block text-[11px]">{{ $order->farmer->stall_number ?? 'Stall Area' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Market Location</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $order->market->market_name ?? 'Springfield Market' }}</span>
                        <span class="text-slate-500 block text-[11px]">{{ $order->market->address ?? '' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Pickup Date</span>
                        <span class="font-bold text-brand-700 text-sm">{{ $order->pickup_date->format('l, F j, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Time Window</span>
                        <span class="font-bold text-brand-700 text-sm">{{ $order->pickup_time_slot }}</span>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block mb-2">Reserved Produce</span>
                    <div class="space-y-1.5 text-xs">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between text-slate-700">
                                <span>{{ $item->quantity }}x {{ $item->product->name ?? 'Produce' }}</span>
                                <span class="font-mono font-bold">${{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">Amount Due on Pickup:</span>
                    <span class="font-heading font-extrabold text-xl text-brand-800">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <p class="text-[11px] text-slate-400 leading-relaxed">
                You can review this order, update special instructions, or cancel before the cutoff time from your customer dashboard.
            </p>

            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('customer.dashboard') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/20 transition-all">
                    View in Customer Dashboard
                </a>
                <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                    Back to Main Page
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
