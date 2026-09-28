@extends('layouts.dashboard')

@section('title', 'Manage Customer Profile | MarketLink')
@section('header_title', 'Customer Profile')
@section('header_subtitle', 'Update personal contact information for pre-order pickup communication')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
        <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
            <div class="w-16 h-16 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center font-extrabold text-2xl shadow-inner flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <h3 class="font-heading font-extrabold text-lg text-slate-900 truncate">{{ $user->name }}</h3>
                <p class="text-xs text-slate-500 truncate">{{ $user->email }} • <span class="capitalize font-bold text-brand-700">{{ $user->role }}</span></p>
            </div>
        </div>

        <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:outline-none focus:border-brand-500 font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Email Address (Immutable Login)</label>
                <input type="email" value="{{ $user->email }}" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl p-3 text-xs text-slate-500 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Contact Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:outline-none focus:border-brand-500 font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Default Street Address / Pickup City</label>
                <textarea name="address" rows="3" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:outline-none focus:border-brand-500 font-medium">{{ old('address', $user->address) }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs shadow-md shadow-brand-600/20 transition-all text-center">
                    Save Profile Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
