@extends('layouts.dashboard')

@section('title', 'Farmer Stall Dashboard & Insights | MarketLink')
@section('header_title', $farmer->stall_name . ' - Farm Insights')
@section('header_subtitle', 'Monitor incoming pre-orders, manage weekly harvest inventory, and track sales revenue')

@section('content')
<div class="space-y-8">
    
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-hover">
            <div class="w-10 h-10 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center text-lg">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <div class="font-heading font-extrabold text-2xl text-slate-900">{{ $totalOrders }}</div>
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Pre-Orders</div>
        </div>

        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-hover">
            <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div class="font-heading font-extrabold text-2xl text-slate-900">{{ $pendingOrders }}</div>
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Pending Orders</div>
        </div>

        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-hover">
            <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg">
                <i class="fa-solid fa-shopping-bag"></i>
            </div>
            <div class="font-heading font-extrabold text-2xl text-slate-900">{{ $readyOrders }}</div>
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Ready for Pickup</div>
        </div>

        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-hover">
            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg">
                <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <div class="font-heading font-extrabold text-2xl text-emerald-700">${{ number_format($totalRevenue, 2) }}</div>
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Revenue Summary</div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-brand-800 to-brand-700 rounded-3xl p-6 sm:p-8 text-white shadow-lg flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h3 class="font-heading font-extrabold text-xl text-white">Upcoming Weekend Market Harvest</h3>
            <p class="text-xs text-brand-100 max-w-xl">
                Operating Days: <strong>{{ $farmer->operating_days }}</strong> • Cutoff Window: <strong>{{ $farmer->cutoff_hours_before }}h before pickup</strong>.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('farmer.products.apply_template') }}" method="POST" onsubmit="return confirm('Apply weekly template? This will refresh stock for recurring harvest items.');">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs transition-all flex items-center gap-2">
                    <i class="fa-solid fa-arrows-spin"></i> Apply Weekly Template
                </button>
            </form>
            <a href="{{ route('farmer.products') }}" class="px-5 py-2.5 rounded-xl bg-white text-brand-800 hover:bg-brand-50 font-extrabold text-xs shadow-md transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Manage Weekly Stock
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <div class="lg:col-span-5 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-fire text-amber-500"></i> Best-Selling Produce
                </h3>
                <span class="text-[11px] font-bold text-slate-400">By Pre-Orders</span>
            </div>

            <div class="space-y-3">
                @forelse($bestSellers as $best)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <img src="{{ $best->image }}" alt="{{ $best->name }}" class="w-10 h-10 rounded-xl object-cover">
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">{{ $best->name }}</h4>
                                <span class="text-[11px] text-slate-400">${{ number_format($best->price, 2) }} / {{ $best->unit }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-extrabold text-brand-700">{{ $best->total_sold ?? 0 }} sold</span>
                            <span class="text-[10px] text-slate-400 block">{{ $best->stock_quantity }} in stock</span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">No sales data recorded yet.</div>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-7 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-brand-600"></i> Recent Pre-Orders
                </h3>
                <a href="{{ route('farmer.orders') }}" class="text-xs font-bold text-brand-700 hover:underline">
                    View All Orders &rarr;
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentOrders as $order)
                    <div class="py-3.5 flex items-center justify-between gap-4 text-xs">
                        <div>
                            <div class="font-bold text-slate-800">
                                #{{ $order->order_number }} • {{ $order->customer->name ?? 'Customer' }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                Pickup: <strong>{{ $order->pickup_date->format('M d') }}</strong> ({{ $order->pickup_time_slot }})
                            </div>
                        </div>

                        <div class="text-right space-y-1">
                            <div class="font-extrabold text-slate-900">${{ number_format($order->total_amount, 2) }}</div>
                            <span class="inline-block px-2 py-0.5 rounded-lg text-[10px] font-extrabold border {{ $order->status_badge['bg'] }}">
                                {{ $order->status_badge['label'] }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">No incoming pre-orders yet.</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
