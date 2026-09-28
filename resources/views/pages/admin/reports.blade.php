@extends('layouts.dashboard')

@section('title', 'Platform Reports | MarketLink Admin')
@section('header_title', 'Market Analytics & Audit Reports')
@section('header_subtitle', 'Sales revenue metrics, market location summaries, and platform transaction audit logs')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h3 class="font-heading font-extrabold text-lg text-slate-900">Platform Analytics</h3>
            <p class="text-xs text-slate-500">Gross revenue generated across local Springfield markets</p>
        </div>
        <form action="{{ route('admin.reports.generate') }}" method="POST" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-file-invoice-dollar"></i> Generate New Platform Audit
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <h4 class="font-heading font-extrabold text-sm text-slate-900">Revenue by Farmers Market</h4>
            <div class="divide-y divide-slate-100 text-xs font-medium">
                @foreach($marketRevenue as $mr)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <div class="font-bold text-slate-800">{{ $mr['market_name'] }}</div>
                            <div class="text-[11px] text-slate-400">{{ $mr['city'] }} • {{ $mr['orders_count'] }} Pre-Orders</div>
                        </div>
                        <div class="font-heading font-extrabold text-sm text-emerald-700">
                            ${{ number_format($mr['revenue'], 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <h4 class="font-heading font-extrabold text-sm text-slate-900">Top 5 Farmer Stalls by Sales</h4>
            <div class="divide-y divide-slate-100 text-xs font-medium">
                @foreach($topFarmers as $tf)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <div class="font-bold text-slate-800">{{ $tf['stall_name'] }}</div>
                            <div class="text-[11px] text-slate-400">Grower: {{ $tf['contact_person'] }} • {{ $tf['orders_count'] }} Orders</div>
                        </div>
                        <div class="font-heading font-extrabold text-sm text-brand-700">
                            ${{ number_format($tf['revenue'], 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
        <h4 class="font-heading font-extrabold text-sm text-slate-900">Archived Audit Reports</h4>
        <div class="divide-y divide-slate-100 text-xs font-medium">
            @forelse($reports as $rep)
                <div class="py-3 flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="font-bold text-slate-900">{{ $rep->title }}</div>
                        <p class="text-slate-600">{{ $rep->summary }}</p>
                        <div class="text-[10px] text-slate-400">Archived: {{ $rep->created_at->format('M d, Y H:i A') }}</div>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase">Verified</span>
                </div>
            @empty
                <div class="py-8 text-center text-slate-400">No generated reports in archive. Click button above to generate.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
