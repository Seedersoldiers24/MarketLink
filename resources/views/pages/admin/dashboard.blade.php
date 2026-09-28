@extends('layouts.dashboard')

@section('title', 'Administrator Central Command | MarketLink')
@section('header_title', 'System Administrator Portal')
@section('header_subtitle', 'Platform overview, pending approvals, order management, and network analytics')

@section('content')
<div class="space-y-8">
    
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-hover">
            <div class="w-10 h-10 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center text-lg">
                <i class="fa-solid fa-tractor"></i>
            </div>
            <div class="font-heading font-extrabold text-2xl text-slate-900">{{ $stats['total_farmers'] }}</div>
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Farmers ({{ $stats['approved_farmers'] }} Active)</div>
        </div>

        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-hover">
            <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg">
                <i class="fa-solid fa-user-clock"></i>
            </div>
            <div class="font-heading font-extrabold text-2xl text-amber-600">{{ $stats['pending_farmers'] }}</div>
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Pending Approvals</div>
        </div>

        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-hover">
            <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="font-heading font-extrabold text-2xl text-slate-900">{{ $stats['total_customers'] }}</div>
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Registered Buyers</div>
        </div>

        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-hover">
            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg">
                <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <div class="font-heading font-extrabold text-2xl text-emerald-700">${{ number_format($stats['total_revenue'], 2) }}</div>
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Gross GMV</div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/20 text-brand-300 text-[11px] font-bold uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-brand-400 animate-pulse"></span>
                System Operational
            </div>
            <h3 class="font-heading font-extrabold text-xl text-white">MarketLink Platform Management</h3>
            <p class="text-xs text-slate-300 max-w-xl">
                Active Markets: <strong>{{ $stats['total_markets'] }}</strong> • Total Pre-Orders Processed: <strong>{{ $stats['total_orders'] }}</strong> • Reviews: <strong>{{ $stats['total_reviews'] }}</strong>
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.farmers') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs transition-all flex items-center gap-2">
                <i class="fa-solid fa-user-check"></i> Review Farmers ({{ $stats['pending_farmers'] }})
            </a>
            <a href="{{ route('admin.markets') }}" class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-extrabold text-xs shadow-md transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Add Market
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-heading font-extrabold text-base text-slate-900">Pending Farmer Applications</h3>
                    <p class="text-xs text-slate-500">Farmers awaiting administrative verification</p>
                </div>
                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">
                    {{ $pendingFarmers->count() }} Pending
                </span>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($pendingFarmers as $pending)
                    <div class="py-4 flex items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="text-sm font-bold text-slate-900">{{ $pending->stall_name }}</div>
                            <div class="text-xs text-slate-500">{{ $pending->user->name ?? 'N/A' }} • {{ $pending->contact_number }}</div>
                            <div class="text-[11px] text-brand-700 bg-brand-50 px-2 py-0.5 rounded inline-block">
                                {{ $pending->operating_days }}
                            </div>
                        </div>
                        <form action="{{ route('admin.farmers.toggle', $pending->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition-all flex items-center gap-1">
                                <i class="fa-solid fa-check"></i> Approve
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-400 space-y-2">
                        <i class="fa-solid fa-circle-check text-3xl text-emerald-500"></i>
                        <p class="text-xs font-medium">All farmer registrations have been verified and approved.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-7 bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-heading font-extrabold text-base text-slate-900">Recent Pre-Orders</h3>
                    <p class="text-xs text-slate-500">Real-time marketplace transactions across Springfield</p>
                </div>
                <a href="{{ route('admin.reports') }}" class="text-xs font-bold text-brand-700 hover:underline">
                    View Reports &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider">
                            <th class="pb-3">Order #</th>
                            <th class="pb-3">Customer</th>
                            <th class="pb-3">Stall</th>
                            <th class="pb-3">Total</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 font-medium">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-3 font-bold text-slate-800">{{ $order->order_number }}</td>
                                <td class="py-3 text-slate-600">{{ $order->customer->name ?? 'Guest Buyer' }}</td>
                                <td class="py-3 text-slate-600">{{ $order->farmer->stall_name ?? 'Farm Stall' }}</td>
                                <td class="py-3 font-bold text-slate-900">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold capitalize
                                        @if($order->order_status === 'completed') bg-emerald-100 text-emerald-800
                                        @elseif($order->order_status === 'ready_for_pickup') bg-blue-100 text-blue-800
                                        @elseif($order->order_status === 'accepted') bg-indigo-100 text-indigo-800
                                        @elseif($order->order_status === 'cancelled') bg-rose-100 text-rose-800
                                        @else bg-amber-100 text-amber-800 @endif">
                                        {{ str_replace('_', ' ', $order->order_status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">No orders recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
