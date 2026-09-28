@extends('layouts.dashboard')

@section('title', 'Customer Accounts | MarketLink Admin')
@section('header_title', 'Buyer & Customer Accounts')
@section('header_subtitle', 'View registered marketplace customers, order histories, and account status')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="font-heading font-extrabold text-base text-slate-900">Registered Buyers</h3>
            <span class="text-xs text-slate-500 font-semibold">Total: {{ $customers->total() }} Users</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider">
                        <th class="pb-3">Name</th>
                        <th class="pb-3">Contact</th>
                        <th class="pb-3">Orders Placed</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 font-bold text-slate-900">{{ $customer->name }}</td>
                            <td class="py-3 text-slate-600">
                                <div>{{ $customer->email }}</div>
                                <div class="text-[11px] text-slate-400">{{ $customer->phone }}</div>
                            </td>
                            <td class="py-3 text-slate-600">{{ $customer->orders_count }} Pre-Orders</td>
                            <td class="py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $customer->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </td>
                            <td class="py-3 text-right">
                                <form action="{{ route('admin.customers.toggle', $customer->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-xl text-xs font-bold transition-all {{ $customer->status === 'active' ? 'bg-rose-50 text-rose-700 hover:bg-rose-100' : 'bg-emerald-600 text-white hover:bg-emerald-700' }}">
                                        {{ $customer->status === 'active' ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No customers registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection
