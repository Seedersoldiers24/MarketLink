@extends('layouts.dashboard')

@section('title', 'Manage Farmers | MarketLink Admin')
@section('header_title', 'Farmer Stalls & Vendor Network')
@section('header_subtitle', 'Review applications, verify local growers, and manage stall approvals')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="font-heading font-extrabold text-base text-slate-900">Registered Farmers & Stalls</h3>
            <span class="text-xs text-slate-500 font-semibold">Total: {{ $farmers->total() }} Stalls</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider">
                        <th class="pb-3">Stall Name</th>
                        <th class="pb-3">Grower / Contact</th>
                        <th class="pb-3">Market Location</th>
                        <th class="pb-3">Schedule</th>
                        <th class="pb-3">Products</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium">
                    @forelse($farmers as $farmer)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 font-bold text-slate-900">{{ $farmer->stall_name }}</td>
                            <td class="py-3 text-slate-600">
                                <div>{{ $farmer->contact_person }}</div>
                                <div class="text-[11px] text-slate-400">{{ $farmer->contact_number }}</div>
                            </td>
                            <td class="py-3 text-slate-600">{{ $farmer->market->market_name ?? 'Unassigned' }}</td>
                            <td class="py-3 text-slate-600">{{ $farmer->operating_days }}</td>
                            <td class="py-3 text-slate-600">{{ $farmer->products->count() }} items</td>
                            <td class="py-3">
                                @if($farmer->is_approved)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Approved</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Pending Review</span>
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                <form action="{{ route('admin.farmers.toggle', $farmer->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-xl text-xs font-bold transition-all {{ $farmer->is_approved ? 'bg-rose-50 text-rose-700 hover:bg-rose-100' : 'bg-emerald-600 text-white hover:bg-emerald-700' }}">
                                        {{ $farmer->is_approved ? 'Suspend' : 'Approve' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">No farmers registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4">
            {{ $farmers->links() }}
        </div>
    </div>
</div>
@endsection
