@extends('layouts.dashboard')

@section('title', 'Produce Inventory & Weekly Harvest | ' . $farmer->stall_name)
@section('header_title', 'Produce Inventory & Harvest Stock')
@section('header_subtitle', 'Manage weekly harvest quantities, toggle sold-out statuses, and configure recurring templates')

@section('content')
<div class="space-y-8">
    
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h3 class="font-heading font-extrabold text-base text-slate-900">Current Stall Inventory</h3>
            <p class="text-xs text-slate-500">You have {{ $products->total() }} produce listings in your stall catalog.</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3 w-full md:w-auto">
            <form action="{{ route('farmer.products.apply_template') }}" method="POST" onsubmit="return confirm('Apply weekly template? This refreshes inventory for recurring harvest produce items.');" class="w-full sm:w-auto">
                @csrf
                <button type="submit" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrows-spin"></i> Apply Recurring Template
                </button>
            </form>

            <button type="button" onclick="document.getElementById('add-product-modal').classList.remove('hidden')" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-extrabold text-xs shadow-md shadow-brand-700/20 transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus"></i> Add New Produce
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between card-hover">
                <div>
                    
                    <div class="relative h-44 bg-slate-100 overflow-hidden">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-brand-700 text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded-full shadow-sm">
                            {{ $product->category->name ?? 'Produce' }}
                        </span>
                        @if($product->is_weekly_template)
                            <span class="absolute top-3 right-3 bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm" title="Auto-refreshes weekly">
                                <i class="fa-solid fa-repeat"></i> Recurring
                            </span>
                        @endif

                        <div class="absolute bottom-3 right-3">
                            @if($product->is_sold_out || $product->stock_quantity <= 0)
                                <span class="bg-rose-600 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-lg shadow-sm">
                                    Sold Out
                                </span>
                            @else
                                <span class="bg-emerald-600 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-lg shadow-sm">
                                    {{ $product->stock_quantity }} {{ $product->unit }} Available
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-5 space-y-3">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <h4 class="font-heading font-extrabold text-base text-slate-900 leading-snug">{{ $product->name }}</h4>
                                <span class="font-heading font-extrabold text-brand-800 text-lg">
                                    ${{ number_format($product->price, 2) }}
                                    <span class="text-xs font-normal text-slate-400">/ {{ $product->unit }}</span>
                                </span>
                            </div>
                        </div>

                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $product->description ?? 'Freshly harvested produce directly from farm.' }}
                        </p>

                        <div class="text-[11px] text-slate-400 pt-1 flex items-center gap-1">
                            <i class="fa-regular fa-clock"></i> Harvest: <strong class="text-slate-600">{{ $product->harvest_date ?? 'This Week' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="p-5 pt-0 border-t border-slate-100 flex items-center justify-between gap-2 mt-2">
                    <form action="{{ route('farmer.products.toggle_sold', $product->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-2 rounded-xl text-xs font-bold transition-all border {{ $product->is_sold_out ? 'border-emerald-200 text-emerald-700 bg-emerald-50 hover:bg-emerald-100' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                            {{ $product->is_sold_out ? 'Mark In Stock' : 'Mark Sold Out' }}
                        </button>
                    </form>

                    <form action="{{ route('farmer.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this produce item?');">
                        @csrf
                        <button type="submit" class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition-colors" title="Delete product">
                            <i class="fa-regular fa-trash-can text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full p-16 text-center bg-white rounded-3xl border border-slate-200 text-slate-400 space-y-3">
                <i class="fa-solid fa-leaf text-4xl text-slate-300"></i>
                <div class="text-sm font-bold text-slate-700">No produce items in your stall inventory yet.</div>
                <p class="text-xs text-slate-400">Click "Add New Produce" above to list items for weekend market pre-orders.</p>
            </div>
        @endforelse
    </div>

    <div class="pt-4">
        {{ $products->links() }}
    </div>
</div>

<div id="add-product-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 sm:p-8 space-y-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="font-heading font-extrabold text-xl text-slate-900">Add New Produce</h3>
                <p class="text-xs text-slate-500">List an item in your stall for customer pre-orders</p>
            </div>
            <button type="button" onclick="document.getElementById('add-product-modal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-800 flex items-center justify-center">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <form action="{{ route('farmer.products.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Produce Name *</label>
                <input type="text" name="name" required placeholder="e.g. Organic Roma Tomatoes" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Category *</label>
                    <select name="category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500 font-semibold">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Unit of Measure *</label>
                    <input type="text" name="unit" required placeholder="e.g. lb, bunch, dozen, loaf" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Price ($) *</label>
                    <input type="number" step="0.01" name="price" required placeholder="3.50" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500 font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Stock Quantity *</label>
                    <input type="number" name="stock_quantity" required placeholder="25" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500 font-mono">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Photo Image URL</label>
                <input type="url" name="image" placeholder="https://images.unsplash.com/..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Harvest Schedule</label>
                <input type="text" name="harvest_date" placeholder="e.g. Picked Friday Morning" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Produce Description</label>
                <textarea name="description" rows="3" placeholder="Describe taste, organic status, storage instructions..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-brand-500"></textarea>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                <label class="flex items-center gap-2 cursor-pointer font-bold text-slate-700">
                    <input type="checkbox" name="is_weekly_template" value="1" class="w-4 h-4 rounded text-brand-700 focus:ring-brand-500">
                    <span>Recurring Weekly Template Item</span>
                </label>
                <p class="text-[11px] text-slate-400 mt-1 pl-6">Allows quick auto-refresh of inventory every week with 1 click.</p>
            </div>

            <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3">
                <button type="button" onclick="document.getElementById('add-product-modal').classList.add('hidden')" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50 text-center">
                    Cancel
                </button>
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-extrabold shadow-md shadow-brand-700/20 text-center">
                    List Produce
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
