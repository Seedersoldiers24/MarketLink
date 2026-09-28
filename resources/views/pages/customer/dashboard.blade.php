@extends('layouts.dashboard')

@section('title', 'My Customer Pre-Orders Dashboard | MarketLink')
@section('header_title', 'Customer Pre-Order Dashboard')
@section('header_subtitle', 'Track incoming pickup status, manage stall orders, and review past purchases')

@section('content')
<div class="space-y-8">
    
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-hover">
            <div class="w-10 h-10 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center text-lg">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <div class="font-heading font-extrabold text-2xl text-slate-900">{{ $stats['total_orders'] }}</div>
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Pre-Orders</div>
        </div>

        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-hover">
            <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="font-heading font-extrabold text-2xl text-slate-900">{{ $stats['active_orders'] }}</div>
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Active Pickups</div>
        </div>

        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-hover">
            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="font-heading font-extrabold text-2xl text-slate-900">{{ $stats['completed_orders'] }}</div>
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Completed Pickups</div>
        </div>

        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-hover">
            <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-heart"></i>
            </div>
            <div class="font-heading font-extrabold text-2xl text-slate-900">{{ $stats['saved_favorites'] }}</div>
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Saved Favorites</div>
        </div>
    </div>

    @if($activeOrders->isNotEmpty())
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-heading font-extrabold text-lg text-slate-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                    Active Weekend Pre-Orders Requiring Pickup ({{ $activeOrders->count() }})
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($activeOrders as $order)
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 sm:p-6 space-y-4 sm:space-y-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                            <div>
                                <span class="font-mono text-xs font-bold text-brand-700">#{{ $order->order_number }}</span>
                                <div class="text-xs font-extrabold text-slate-900 mt-0.5">{{ $order->farmer->stall_name }}</div>
                            </div>
                            <span class="self-start sm:self-auto text-xs font-extrabold px-3 py-1 rounded-xl border {{ $order->status_badge['bg'] }}">
                                {{ $order->status_badge['label'] }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div class="p-2.5 bg-slate-50 rounded-xl">
                                <span class="text-[10px] text-slate-400 block uppercase font-bold">Pickup Date</span>
                                <span class="font-bold text-slate-800">{{ $order->pickup_date->format('M d, Y') }}</span>
                            </div>
                            <div class="p-2.5 bg-slate-50 rounded-xl">
                                <span class="text-[10px] text-slate-400 block uppercase font-bold">Time Window</span>
                                <span class="font-bold text-slate-800">{{ $order->pickup_time_slot }}</span>
                            </div>
                            <div class="col-span-2 p-2.5 bg-slate-50 rounded-xl">
                                <span class="text-[10px] text-slate-400 block uppercase font-bold">Stall Location</span>
                                <span class="font-bold text-slate-800">{{ $order->market->market_name ?? 'Market' }} • {{ $order->farmer->stall_number ?? 'Stall Area' }}</span>
                            </div>
                        </div>

                        <div class="space-y-1.5 text-xs pt-1">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between text-slate-600">
                                    <span>{{ $item->quantity }}x {{ $item->product->name ?? 'Harvest Produce' }}</span>
                                    <span class="font-mono font-bold">${{ number_format($item->subtotal, 2) }}</span>
                                </div>
                            @endforeach
                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between font-bold text-slate-900">
                                <span>Amount on Pickup:</span>
                                <span class="text-brand-700 font-extrabold text-base">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>

                        @if($order->customer_notes)
                            <div class="text-[11px] p-2 bg-slate-50 rounded-xl text-slate-600 border border-slate-100">
                                <strong>My Notes:</strong> {{ $order->customer_notes }}
                            </div>
                        @endif

                        @if($order->farmer_notes)
                            <div class="text-[11px] p-2 bg-emerald-50 rounded-xl text-emerald-800 border border-emerald-200">
                                <strong>Farmer Message:</strong> {{ $order->farmer_notes }}
                            </div>
                        @endif

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3 text-xs">
                            @if($order->canBeCancelledOrModified())
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this pre-order?');">
                                    @csrf
                                    <button type="submit" class="px-3.5 py-1.5 rounded-xl border border-rose-200 text-rose-600 font-bold hover:bg-rose-50 transition-colors">
                                        Cancel Order
                                    </button>
                                </form>
                                <span class="text-[10px] text-emerald-600 font-bold">Cutoff Active</span>
                            @else
                                <span class="text-[10px] text-slate-400 font-medium">Cutoff reached (Ready for market pickup)</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden space-y-4 p-6">
        <div class="flex items-center justify-between">
            <h3 class="font-heading font-extrabold text-lg text-slate-900">Complete Pre-Order History</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-y border-slate-200">
                    <tr>
                        <th class="p-3.5">Order Ref</th>
                        <th class="p-3.5">Farmer & Market</th>
                        <th class="p-3.5">Pickup Date & Slot</th>
                        <th class="p-3.5">Total Amount</th>
                        <th class="p-3.5">Status</th>
                        <th class="p-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($orders as $o)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-3.5 font-mono font-bold text-slate-900">
                                #{{ $o->order_number }}
                            </td>
                            <td class="p-3.5">
                                <div class="font-bold text-slate-800">{{ $o->farmer->stall_name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $o->market->market_name ?? '' }}</div>
                            </td>
                            <td class="p-3.5">
                                <div class="text-slate-800">{{ $o->pickup_date->format('M d, Y') }}</div>
                                <div class="text-[11px] text-slate-500">{{ $o->pickup_time_slot }}</div>
                            </td>
                            <td class="p-3.5 font-bold text-slate-900">
                                ${{ number_format($o->total_amount, 2) }}
                            </td>
                            <td class="p-3.5">
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-extrabold border {{ $o->status_badge['bg'] }}">
                                    {{ $o->status_badge['label'] }}
                                </span>
                            </td>
                            <td class="p-3.5 text-right space-x-2">
                                <form action="{{ route('orders.reorder', $o->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs" title="Quick Re-Order">
                                        <i class="fa-solid fa-rotate-right mr-1"></i> Re-Order
                                    </button>
                                </form>

                                @if($o->order_status === 'completed' && $o->reviews->isEmpty())
                                    <a href="{{ route('farmers.show', $o->farmer_id) }}#review" class="px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 font-bold text-xs">
                                        Review
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                No pre-orders placed yet. <a href="{{ route('products.index') }}" class="text-brand-700 underline font-bold">Browse the weekly farm catalog &rarr;</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
