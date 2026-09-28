@extends('layouts.dashboard')

@section('title', 'Manage Markets | MarketLink Admin')
@section('header_title', 'Farmers Markets Directory')
@section('header_subtitle', 'Configure market locations, operating schedules, geo-coordinates, and vendor quotas')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
        <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-brand-600"></i> Add New Farmers Market
        </h3>

        <form action="{{ route('admin.markets.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs font-medium">
            @csrf
            <div>
                <label class="block text-slate-600 font-bold mb-1">Market Name *</label>
                <input type="text" name="market_name" required placeholder="e.g. Oakridge Valley Farmers Market" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5">
            </div>
            <div>
                <label class="block text-slate-600 font-bold mb-1">Address *</label>
                <input type="text" name="address" required placeholder="123 Orchard Way" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5">
            </div>
            <div>
                <label class="block text-slate-600 font-bold mb-1">City *</label>
                <input type="text" name="city" required value="Springfield" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5">
            </div>
            <div>
                <label class="block text-slate-600 font-bold mb-1">Operating Days *</label>
                <input type="text" name="operating_days" required placeholder="Saturday & Sunday" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5">
            </div>
            <div>
                <label class="block text-slate-600 font-bold mb-1">Timings *</label>
                <input type="text" name="timings" required placeholder="08:00 AM - 02:00 PM" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-slate-600 font-bold mb-1">Latitude *</label>
                    <input type="number" step="any" name="latitude" required value="37.7749" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5">
                </div>
                <div>
                    <label class="block text-slate-600 font-bold mb-1">Longitude *</label>
                    <input type="number" step="any" name="longitude" required value="-122.4194" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5">
                </div>
            </div>
            <div class="sm:col-span-2 lg:col-span-3 flex justify-end">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md transition-all">
                    Save Market Location
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
        <h3 class="font-heading font-extrabold text-base text-slate-900">Existing Market Locations</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider">
                        <th class="pb-3">Market</th>
                        <th class="pb-3">City & Address</th>
                        <th class="pb-3">Schedule</th>
                        <th class="pb-3">Stalls</th>
                        <th class="pb-3">Orders</th>
                        <th class="pb-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium">
                    @forelse($markets as $market)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 font-bold text-slate-900">{{ $market->market_name }}</td>
                            <td class="py-3 text-slate-600">{{ $market->address }}, {{ $market->city }}</td>
                            <td class="py-3 text-slate-600">{{ $market->operating_days }} ({{ $market->timings }})</td>
                            <td class="py-3 text-slate-600">{{ $market->farmers_count }} stalls</td>
                            <td class="py-3 text-slate-600">{{ $market->orders_count }} orders</td>
                            <td class="py-3 text-right">
                                <form action="{{ route('admin.markets.destroy', $market->id) }}" method="POST" onsubmit="return confirm('Remove market?');" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold transition-all">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No markets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pt-4">
            {{ $markets->links() }}
        </div>
    </div>
</div>
@endsection
