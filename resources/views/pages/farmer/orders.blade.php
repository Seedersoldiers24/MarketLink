@extends('layouts.dashboard')

@section('title', 'Manage Customer Pre-Orders | ' . $farmer->stall_name)
@section('header_title', 'Stall Pre-Orders Management')
@section('header_subtitle', 'Review incoming reservations, update packing status, and coordinate pickup slots')

@section('content')
<div class="space-y-6">
    
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('farmer.orders') }}" class="flex flex-wrap items-center gap-3">
            <div>
                <select name="status" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 focus:outline-none focus:border-brand-500">
                    <option value="">All Statuses</option>
                    <option value="placed" {{ request('status') === 'placed' ? 'selected' : '' }}>Placed (Pending)</option>
                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="ready_for_pickup" {{ request('status') === 'ready_for_pickup' ? 'selected' : '' }}>Ready for Pickup</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 focus:outline-none focus:border-brand-500">
            </div>

            @if(request()->hasAny(['status', 'date']))
                <a href="{{ route('farmer.orders') }}" class="text-xs text-rose-600 font-bold hover:underline">
                    Reset Filter
                </a>
            @endif
        </form>

        <div class="text-xs font-bold text-slate-500 text-right">
            Total Orders Listed: {{ $orders->total() }}
        </div>
    </div>

    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4 transition-all hover:shadow-md">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-sm font-extrabold text-brand-800">#{{ $order->order_number }}</span>
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold uppercase border {{ $order->status_badge['bg'] ?? 'bg-slate-100 text-slate-700' }}">
                                {{ $order->status_badge['label'] ?? ucfirst($order->order_status) }}
                            </span>
                        </div>
                        <div class="text-xs font-semibold text-slate-500 mt-1">
                            Buyer: <strong class="text-slate-800">{{ $order->customer->name ?? 'Customer' }}</strong> 
                            @if(isset($order->customer->phone)) • {{ $order->customer->phone }} @endif
                        </div>
                    </div>

                    <div class="text-left sm:text-right">
                        <div class="text-xs text-slate-400 font-bold uppercase">Pickup Scheduled</div>
                        <div class="text-xs font-extrabold text-slate-900 mt-0.5">
                            <i class="fa-regular fa-calendar-check text-brand-600 mr-1"></i>
                            {{ $order->pickup_date ? $order->pickup_date->format('l, M d, Y') : 'Weekend' }} • {{ $order->pickup_time_slot }}
                        </div>
                    </div>
                </div>

                <div class="space-y-2 bg-slate-50/80 p-4 rounded-2xl border border-slate-100 text-xs">
                    <div class="font-bold text-slate-400 uppercase text-[10px] tracking-wider mb-1">Pre-Ordered Produce</div>
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-slate-800 font-medium">
                                <span class="w-6 h-6 rounded-md bg-white border border-slate-200 flex items-center justify-center font-bold text-brand-700 text-[11px]">{{ $item->quantity }}x</span>
                                <span>{{ $item->product->name ?? 'Farm Item' }}</span>
                                <span class="text-slate-400 text-[11px]">(${{ number_format($item->unit_price, 2) }}/ea)</span>
                            </div>
                            <span class="font-mono font-bold text-slate-900">${{ number_format($item->subtotal, 2) }}</span>
                        </div>
                    @endforeach

                    <div class="pt-2 mt-2 border-t border-slate-200/70 flex items-center justify-between font-bold text-slate-900">
                        <span>Total Due on Pickup:</span>
                        <span class="text-base font-extrabold text-brand-800 font-mono">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                @if($order->customer_notes)
                    <div class="text-xs p-3 bg-amber-50/60 rounded-xl border border-amber-200 text-amber-900">
                        <span class="font-bold"><i class="fa-regular fa-comment-dots mr-1"></i> Customer Special Request:</span> {{ $order->customer_notes }}
                    </div>
                @endif

                <form action="{{ route('farmer.orders.status', $order->id) }}" method="POST" class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                    @csrf
                    <div class="flex-1">
                        <input type="text" name="farmer_notes" value="{{ $order->farmer_notes }}" placeholder="Add note to customer (e.g. packed in brown box, stall table 3)..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-brand-500">
                    </div>

                    <div class="flex items-center gap-2">
                        <select name="order_status" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 focus:outline-none focus:border-brand-500">
                            <option value="placed" {{ $order->order_status === 'placed' ? 'selected' : '' }}>Placed</option>
                            <option value="accepted" {{ $order->order_status === 'accepted' ? 'selected' : '' }}>Accept Order</option>
                            <option value="ready_for_pickup" {{ $order->order_status === 'ready_for_pickup' ? 'selected' : '' }}>Ready for Pickup</option>
                            <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Completed (Picked up)</option>
                            <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs shadow-sm transition-all whitespace-nowrap">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        @empty
            <div class="p-12 text-center bg-white rounded-3xl border border-slate-200 text-slate-400 space-y-3">
                <i class="fa-solid fa-basket-shopping text-4xl text-slate-300"></i>
                <div class="text-sm font-bold text-slate-700">No orders found for the selected criteria.</div>
                <p class="text-xs text-slate-400">Pre-orders placed by customers will appear here with pickup slot details.</p>
            </div>
        @endforelse
    </div>

    <div class="pt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
