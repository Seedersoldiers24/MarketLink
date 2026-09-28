@extends('layouts.app')

@section('title', 'Select Pickup Slots & Place Pre-Order | MarketLink')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-widest text-brand-700">Pre-Order Confirmation</span>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 mt-1">Select Pickup Slots & Complete Pre-Order</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Configure your pickup date and morning/afternoon time window for each farmer stall.</p>
        </div>

        <form action="{{ route('orders.place') }}" method="POST" class="space-y-6 sm:space-y-8">
            @csrf

            <div class="space-y-6">
                @foreach($groupedCart as $farmerId => $group)
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 sm:p-6 space-y-4 sm:space-y-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-4 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-sm flex-shrink-0">
                                    <i class="fa-solid fa-store"></i>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-heading font-extrabold text-base text-slate-900 truncate">{{ $group['farmer']->stall_name }}</h3>
                                    <p class="text-xs text-slate-500 truncate">Market: {{ $group['farmer']->market->market_name ?? 'Springfield Market' }} • {{ $group['farmer']->stall_number ?? 'Stall Area' }}</p>
                                </div>
                            </div>
                            <span class="self-start sm:self-auto text-xs font-bold text-brand-700 bg-brand-50 px-3 py-1 rounded-xl border border-brand-200 flex-shrink-0">
                                Cutoff: {{ $group['farmer']->cutoff_hours_before }}h prior
                            </span>
                        </div>

                        <div class="space-y-2">
                            <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Reserved Produce:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($group['items'] as $item)
                                    <span class="bg-slate-50 text-slate-800 border border-slate-200 text-xs px-3 py-1 rounded-xl flex items-center gap-1.5">
                                        <strong class="text-slate-900">{{ $item['quantity'] }}x</strong> {{ $item['name'] }}
                                        <span class="text-slate-400 font-mono">(${{ number_format($item['price'] * $item['quantity'], 2) }})</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-slate-100">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Pickup Date *</label>
                                <input type="date" name="pickup_dates[{{ $farmerId }}]" value="{{ now()->addDays(2)->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs font-semibold focus:outline-none focus:border-brand-500">
                                <span class="text-[10px] text-slate-400 mt-1 block">Operating days: {{ $group['farmer']->operating_days }}</span>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Pickup Time Window *</label>
                                <select name="pickup_slots[{{ $farmerId }}]" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs font-semibold focus:outline-none focus:border-brand-500">
                                    @foreach($group['farmer']->pickup_slots_array as $slot)
                                        <option value="{{ $slot }}">{{ $slot }}</option>
                                    @endforeach
                                </select>
                                <span class="text-[10px] text-slate-400 mt-1 block">Express collection at designated stall</span>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Special Instructions for Farmer (Optional)</label>
                                <input type="text" name="customer_notes[{{ $farmerId }}]" placeholder="e.g. Please pick firmer berries, attending around 10am..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-brand-500">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <h3 class="font-heading font-extrabold text-lg text-slate-900">Contact & Pickup Verification</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Customer Name</span>
                        <span class="font-bold text-slate-900 text-sm">{{ $user->name }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Contact Number</span>
                        <span class="font-bold text-slate-900 text-sm">{{ $user->phone ?? 'Not provided' }}</span>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200/80 text-xs text-amber-900 space-y-1">
                    <div class="font-bold text-amber-800 flex items-center gap-1.5 text-sm">
                        <i class="fa-solid fa-coins text-amber-600"></i> Payment Settled in Person at Pickup
                    </div>
                    <p class="text-amber-800 leading-relaxed">
                        As per farmers market traditions and MarketLink policy, no online payment is taken today. You inspect your farm basket in person and pay the grower at the stall (Cash, Debit, or Credit Card).
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div>
                        <span class="text-xs text-slate-400 font-bold block uppercase">Grand Total (Pay at Pickup)</span>
                        <div class="font-heading font-extrabold text-3xl text-brand-800">
                            ${{ number_format($total, 2) }}
                        </div>
                    </div>

                    <button type="submit" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs shadow-xl shadow-brand-600/30 transition-all flex items-center justify-center gap-2 active:scale-95">
                        <i class="fa-solid fa-check text-sm"></i> Confirm & Place Pre-Order
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
