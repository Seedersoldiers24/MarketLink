@extends('layouts.dashboard')

@section('title', 'Stall Settings & Profile | ' . $farmer->stall_name)
@section('header_title', 'Stall Settings & Logistics')
@section('header_subtitle', 'Configure stall location, operating days, pickup time slots, and pre-order cutoff window')

@section('content')
<div class="max-w-4xl space-y-8">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h3 class="font-heading font-extrabold text-xl text-slate-900">Farm Stall Details</h3>
                <p class="text-xs text-slate-500">Public profile details displayed to buyers in the farmers market directory</p>
            </div>
            <div class="flex items-center gap-2">
                @if($farmer->is_approved)
                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-check"></i> Approved Stall
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-clock"></i> Verification Pending
                    </span>
                @endif
            </div>
        </div>

        <form action="{{ route('farmer.profile.update') }}" method="POST" class="space-y-6 text-xs">
            @csrf

            <div class="space-y-4">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Business Identity</div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Stall / Business Name *</label>
                        <input type="text" name="stall_name" value="{{ old('stall_name', $farmer->stall_name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500 font-semibold text-slate-800">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Stall Number / Location Tag</label>
                        <input type="text" name="stall_number" value="{{ old('stall_number', $farmer->stall_number) }}" placeholder="e.g. Stall #14 (North Pavilion)" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Contact Person *</label>
                        <input type="text" name="contact_person" value="{{ old('contact_person', $farmer->contact_person) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Contact Phone Number *</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number', $farmer->contact_number) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500">
                    </div>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Market Schedule & Pickup Logistics</div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 mb-1">Affiliated Farmers Market</label>
                        <select name="market_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500 font-semibold text-slate-800">
                            <option value="">Select affiliated market...</option>
                            @foreach($markets as $m)
                                <option value="{{ $m->id }}" {{ $farmer->market_id == $m->id ? 'selected' : '' }}>
                                    {{ $m->market_name }} ({{ $m->operating_days }} • {{ $m->city }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Stall Operating Days *</label>
                        <input type="text" name="operating_days" value="{{ old('operating_days', $farmer->operating_days) }}" required placeholder="e.g. Saturday, Sunday" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Pre-Order Cutoff (Hours Before Pickup) *</label>
                        <input type="number" name="cutoff_hours_before" value="{{ old('cutoff_hours_before', $farmer->cutoff_hours_before) }}" min="1" max="72" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500 font-mono">
                        <span class="text-[10px] text-slate-400 mt-1 block">Orders lock this many hours before pickup for harvesting.</span>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 mb-1">Pickup Time Slots (Comma-separated) *</label>
                        <input type="text" name="pickup_windows" value="{{ old('pickup_windows', $farmer->pickup_windows) }}" required placeholder="08:00 AM - 10:00 AM, 10:00 AM - 12:00 PM, 12:00 PM - 02:00 PM" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500 font-medium">
                    </div>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Farm Story & Agricultural Practices</div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Farm Bio & Specialties</label>
                    <textarea name="bio" rows="4" placeholder="Share your regenerative farming methods, family history, heirloom crops..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500 leading-relaxed">{{ old('bio', $farmer->bio) }}</textarea>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end">
                <button type="submit" class="px-8 py-3 rounded-2xl bg-brand-700 hover:bg-brand-800 text-white font-extrabold text-xs shadow-md shadow-brand-700/20 transition-all">
                    Save Stall Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
