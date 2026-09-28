@extends('layouts.dashboard')

@section('title', 'Master Produce Categories | MarketLink Admin')
@section('header_title', 'Master Produce Categories')
@section('header_subtitle', 'Organize seasonal crops, root vegetables, baked goods, and orchard categories')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
        <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-brand-600"></i> Create Master Category
        </h3>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs font-medium">
            @csrf
            <div>
                <label class="block text-slate-600 font-bold mb-1">Category Name *</label>
                <input type="text" name="name" required placeholder="e.g. Heirloom Vegetables" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5">
            </div>
            <div>
                <label class="block text-slate-600 font-bold mb-1">Icon (Font Awesome class) *</label>
                <input type="text" name="icon" required value="fa-carrot" placeholder="fa-carrot" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5">
            </div>
            <div>
                <label class="block text-slate-600 font-bold mb-1">Image URL (Optional)</label>
                <input type="url" name="image" placeholder="https://..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5">
            </div>
            <div class="sm:col-span-3 flex justify-end">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md transition-all">
                    Save Category
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($categories as $cat)
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-sm space-y-3 card-hover text-center">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center text-xl">
                    <i class="fa-solid {{ $cat->icon }}"></i>
                </div>
                <div>
                    <h4 class="font-heading font-extrabold text-sm text-slate-900">{{ $cat->name }}</h4>
                    <p class="text-[11px] text-slate-500">{{ $cat->products_count }} Products Listed</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
