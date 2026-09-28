<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Market;
use App\Models\Review;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['farmer.user', 'farmer.market', 'category', 'reviews']);

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $catSlug = $request->input('category');
            $query->whereHas('category', function($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        // Market filter
        if ($request->filled('market_id')) {
            $marketId = $request->input('market_id');
            $query->whereHas('farmer', function($q) use ($marketId) {
                $q->where('market_id', $marketId);
            });
        }

        // Day filter
        if ($request->filled('day')) {
            $day = $request->input('day');
            $query->whereHas('farmer', function($q) use ($day) {
                $q->where('operating_days', 'like', "%{$day}%");
            });
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        // Stock filter
        if ($request->filled('in_stock')) {
            $query->where('is_sold_out', false)->where('stock_quantity', '>', 0);
        }

        // Sorting
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        $markets = Market::where('is_active', true)->get();

        return view('pages.products.index', compact('products', 'categories', 'markets'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['farmer.user', 'farmer.market', 'category', 'reviews.customer'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Auth::user()->favorites()
                ->where('favoritable_type', Product::class)
                ->where('favoritable_id', $product->id)
                ->exists();
        }

        return view('pages.products.show', compact('product', 'relatedProducts', 'isFavorite'));
    }

    public function storeReview(Request $request, $slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to leave a review.');
        }

        $product = Product::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        Review::create([
            'customer_id' => Auth::id(),
            'product_id' => $product->id,
            'farmer_id' => $product->farmer_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Thank you! Your product review has been submitted.');
    }
}
