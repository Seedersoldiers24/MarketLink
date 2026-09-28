@extends('layouts.app')

@section('title', 'Meet Our Local Farmers - Farm Stalls Directory | MarketLink')

@section('content')

<div class="bg-gradient-to-b from-brand-50/60 to-slate-50 py-10 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-100 text-brand-800 text-xs font-bold uppercase tracking-wider mb-2">
                    <i class="fa-solid fa-store"></i> Verified Local Growers
                </div>
                <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900">Farmers Directory</h1>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">Connect directly with the growers behind your food. Check their weekly stalls, operating days, and reserve farm-fresh produce.</p>
            </div>

            <form action="{{ route('farmers.index') }}" method="GET" class="w-full md:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                <div class="relative w-full sm:w-56">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search farmer or stall..." class="w-full bg-white border border-slate-200 rounded-2xl px-3.5 py-2 pl-9 text-xs focus:outline-none focus:border-brand-500 shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                </div>

                <div class="flex flex-wrap sm:flex-nowrap items-center gap-2">
                    <select name="market_id" onchange="this.form.submit()" class="flex-1 sm:flex-initial bg-white border border-slate-200 rounded-2xl px-3 py-2 text-xs focus:outline-none focus:border-brand-500 shadow-sm font-semibold text-slate-700">
                        <option value="">All Markets</option>
                        @foreach($markets as $m)
                            <option value="{{ $m->id }}" {{ request('market_id') == $m->id ? 'selected' : '' }}>{{ $m->market_name }}</option>
                        @endforeach
                    </select>

                    <select name="day" onchange="this.form.submit()" class="flex-1 sm:flex-initial bg-white border border-slate-200 rounded-2xl px-3 py-2 text-xs focus:outline-none focus:border-brand-500 shadow-sm font-semibold text-slate-700">
                        <option value="">All Days</option>
                        <option value="Saturday" {{ request('day') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                        <option value="Sunday" {{ request('day') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        <option value="Wednesday" {{ request('day') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="Tuesday" {{ request('day') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="Friday" {{ request('day') == 'Friday' ? 'selected' : '' }}>Friday</option>
                    </select>

                    <button type="submit" class="px-4 py-2 rounded-2xl bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs shadow-sm">
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'market_id', 'day']))
                        <a href="{{ route('farmers.index') }}" class="px-3 py-2 rounded-2xl bg-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-300">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($farmers as $farmer)
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm card-hover flex flex-col justify-between">
                <div>
                    
                    <div class="h-28 bg-gradient-to-r from-brand-700 via-brand-600 to-emerald-600 relative p-4 flex items-end">
                        <div class="absolute -bottom-8 left-6">
                            <img src="{{ $farmer->avatar ?? 'https://images.unsplash.com/photo-1595273670150-bd0c3c392e46?auto=format&fit=crop&w=150&q=80' }}" alt="{{ $farmer->stall_name }}" class="w-16 h-16 rounded-2xl object-cover border-4 border-white shadow-md bg-white">
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="bg-black/30 backdrop-blur-md text-white text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider">
                                {{ $farmer->market->market_name ?? 'Local Market' }}
                            </span>
                        </div>
                    </div>

                    <div class="pt-10 p-6 space-y-3">
                        <div>
                            <div class="flex items-center justify-between">
                                <h3 class="font-heading font-extrabold text-lg text-slate-900 leading-snug">
                                    <a href="{{ route('farmers.show', $farmer->id) }}" class="hover:text-brand-700 transition-colors">{{ $farmer->stall_name }}</a>
                                </h3>
                                <span class="text-amber-500 font-extrabold text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-star"></i> {{ $farmer->averageRating() }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Led by <strong>{{ $farmer->contact_person }}</strong>
                                @if($farmer->stall_number) • <span class="text-slate-700 font-semibold">{{ $farmer->stall_number }}</span>@endif
                            </p>
                        </div>

                        <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                            {{ $farmer->bio }}
                        </p>

                        <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-2 text-xs">
                            <div class="p-2 rounded-xl bg-slate-50">
                                <span class="text-[10px] text-slate-400 font-bold block uppercase">Operating Days</span>
                                <span class="font-bold text-slate-800 text-[11px]">{{ $farmer->operating_days }}</span>
                            </div>
                            <div class="p-2 rounded-xl bg-slate-50">
                                <span class="text-[10px] text-slate-400 font-bold block uppercase">Active Produce</span>
                                <span class="font-bold text-brand-700 text-[11px]">{{ $farmer->products->count() }} Items Listed</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0 border-t border-slate-100 mt-2">
                    <a href="{{ route('farmers.show', $farmer->id) }}" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs flex items-center justify-center gap-2 transition-colors">
                        <span>Visit Stall & Pre-Order</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-500">
                <i class="fa-solid fa-tractor text-4xl text-slate-300 mb-3"></i>
                <p class="font-bold text-base">No farmers match the selected filters.</p>
                <a href="{{ route('farmers.index') }}" class="text-xs text-brand-700 underline font-semibold mt-2 inline-block">Reset filters</a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $farmers->links() }}
    </div>
</div>
@endsection
