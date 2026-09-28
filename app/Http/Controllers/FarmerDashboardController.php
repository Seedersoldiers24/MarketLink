<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\FarmerProfile;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\Market;

class FarmerDashboardController extends Controller
{
    protected function getFarmerProfile(): FarmerProfile
    {
        $profile = Auth::user()->farmerProfile;
        if (!$profile) {
            $profile = FarmerProfile::create([
                'user_id' => Auth::id(),
                'stall_name' => Auth::user()->name . "'s Farm Stall",
                'contact_person' => Auth::user()->name,
                'contact_number' => Auth::user()->phone ?? '+1 (555) 000-0000',
                'operating_days' => 'Saturday & Sunday',
                'pickup_windows' => '08:00 AM - 10:00 AM, 10:00 AM - 12:00 PM, 12:00 PM - 02:00 PM',
                'cutoff_hours_before' => 12,
                'is_approved' => true,
            ]);
        }
        return $profile;
    }

    public function index()
    {
        $farmer = $this->getFarmerProfile();

        $totalOrders = Order::where('farmer_id', $farmer->id)->count();
        $pendingOrders = Order::where('farmer_id', $farmer->id)->where('order_status', 'placed')->count();
        $acceptedOrders = Order::where('farmer_id', $farmer->id)->where('order_status', 'accepted')->count();
        $readyOrders = Order::where('farmer_id', $farmer->id)->where('order_status', 'ready_for_pickup')->count();
        $completedOrders = Order::where('farmer_id', $farmer->id)->where('order_status', 'completed')->count();
        $totalRevenue = Order::where('farmer_id', $farmer->id)->whereIn('order_status', ['completed', 'accepted', 'ready_for_pickup'])->sum('total_amount');

        // Best selling products
        $bestSellers = Product::where('farmer_id', $farmer->id)
            ->withCount(['orderItems as total_sold' => function($q) {
                $q->select(\DB::raw('COALESCE(SUM(quantity), 0)'));
            }])
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $recentOrders = Order::where('farmer_id', $farmer->id)
            ->with(['customer', 'items.product'])
            ->latest()
            ->take(5)
            ->get();

        return view('pages.farmer.dashboard', compact(
            'farmer', 'totalOrders', 'pendingOrders', 'acceptedOrders',
            'readyOrders', 'completedOrders', 'totalRevenue', 'bestSellers', 'recentOrders'
        ));
    }

    public function orders(Request $request)
    {
        $farmer = $this->getFarmerProfile();
        $query = Order::where('farmer_id', $farmer->id)->with(['customer', 'items.product', 'reviews']);

        if ($request->filled('status')) {
            $query->where('order_status', $request->input('status'));
        }

        if ($request->filled('date')) {
            $query->whereDate('pickup_date', $request->input('date'));
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('pages.farmer.orders', compact('farmer', 'orders'));
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        $farmer = $this->getFarmerProfile();
        $order = Order::where('farmer_id', $farmer->id)->findOrFail($orderId);

        $request->validate([
            'order_status' => 'required|in:accepted,ready_for_pickup,completed,cancelled',
            'farmer_notes' => 'nullable|string|max:500',
        ]);

        $order->order_status = $request->input('order_status');
        if ($request->filled('farmer_notes')) {
            $order->farmer_notes = $request->input('farmer_notes');
        }
        $order->save();

        return back()->with('success', "Order #{$order->order_number} status updated to: " . ucfirst(str_replace('_', ' ', $order->order_status)));
    }

    public function products()
    {
        $farmer = $this->getFarmerProfile();
        $products = Product::where('farmer_id', $farmer->id)->with('category')->latest()->paginate(12);
        $categories = Category::all();

        return view('pages.farmer.products', compact('farmer', 'products', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $farmer = $this->getFarmerProfile();

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'price' => 'required|numeric|min:0.1',
            'unit' => 'required|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
            'harvest_date' => 'nullable|string|max:100',
            'image' => 'nullable|url|max:500',
            'is_weekly_template' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['name']) . '-' . rand(100, 999);

        Product::create([
            'farmer_id' => $farmer->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'unit' => $validated['unit'],
            'stock_quantity' => $validated['stock_quantity'],
            'is_sold_out' => ($validated['stock_quantity'] <= 0),
            'is_weekly_template' => $request->has('is_weekly_template'),
            'harvest_date' => $validated['harvest_date'] ?? 'Fresh Farm Harvest',
            'image' => $validated['image'] ?: 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=600&q=80',
        ]);

        return back()->with('success', 'Product listed successfully in your weekly stock!');
    }

    public function updateProduct(Request $request, $id)
    {
        $farmer = $this->getFarmerProfile();
        $product = Product::where('farmer_id', $farmer->id)->findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'price' => 'required|numeric|min:0.1',
            'unit' => 'required|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
            'harvest_date' => 'nullable|string|max:100',
            'image' => 'nullable|url|max:500',
            'is_sold_out' => 'nullable|boolean',
            'is_weekly_template' => 'nullable|boolean',
        ]);

        $product->category_id = $validated['category_id'];
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->unit = $validated['unit'];
        $product->stock_quantity = $validated['stock_quantity'];
        $product->description = $validated['description'] ?? null;
        $product->harvest_date = $validated['harvest_date'] ?? null;
        if (!empty($validated['image'])) {
            $product->image = $validated['image'];
        }
        $product->is_sold_out = $request->has('is_sold_out') || ($validated['stock_quantity'] <= 0);
        $product->is_weekly_template = $request->has('is_weekly_template');
        $product->save();

        return back()->with('success', "Produce '{$product->name}' updated successfully.");
    }

    public function toggleSoldOut($id)
    {
        $farmer = $this->getFarmerProfile();
        $product = Product::where('farmer_id', $farmer->id)->findOrFail($id);
        $product->is_sold_out = !$product->is_sold_out;
        $product->save();

        $status = $product->is_sold_out ? 'marked as Sold Out' : 'marked as In Stock';
        return back()->with('success', "'{$product->name}' is now {$status}.");
    }

    public function applyWeeklyTemplate()
    {
        $farmer = $this->getFarmerProfile();
        $templateProducts = Product::where('farmer_id', $farmer->id)
            ->where('is_weekly_template', true)
            ->get();

        foreach ($templateProducts as $product) {
            $product->stock_quantity = 30; // reset weekly template stock
            $product->is_sold_out = false;
            $product->save();
        }

        return back()->with('success', "Weekly stock template applied! " . count($templateProducts) . " recurring items refreshed for this week's market.");
    }

    public function destroyProduct($id)
    {
        $farmer = $this->getFarmerProfile();
        $product = Product::where('farmer_id', $farmer->id)->findOrFail($id);
        $product->delete();

        return back()->with('success', 'Product removed from stock listing.');
    }

    public function profile()
    {
        $farmer = $this->getFarmerProfile();
        $markets = Market::where('is_active', true)->get();
        return view('pages.farmer.profile', compact('farmer', 'markets'));
    }

    public function updateProfile(Request $request)
    {
        $farmer = $this->getFarmerProfile();

        $validated = $request->validate([
            'stall_name' => 'required|string|max:150',
            'stall_number' => 'nullable|string|max:50',
            'contact_person' => 'required|string|max:100',
            'contact_number' => 'required|string|max:30',
            'market_id' => 'nullable|exists:markets,id',
            'operating_days' => 'required|string|max:100',
            'pickup_windows' => 'required|string|max:300',
            'cutoff_hours_before' => 'required|integer|min:1|max:72',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'bio' => 'nullable|string|max:1500',
        ]);

        $farmer->update($validated);

        return back()->with('success', 'Stall profile and pickup windows updated successfully.');
    }

    public function reviews()
    {
        $farmer = $this->getFarmerProfile();
        $reviews = Review::where('farmer_id', $farmer->id)
            ->with(['customer', 'product'])
            ->latest()
            ->paginate(10);

        return view('pages.farmer.reviews', compact('farmer', 'reviews'));
    }

    public function replyReview(Request $request, $reviewId)
    {
        $farmer = $this->getFarmerProfile();
        $review = Review::where('farmer_id', $farmer->id)->findOrFail($reviewId);

        $request->validate(['farmer_reply' => 'required|string|max:1000']);

        $review->update([
            'farmer_reply' => $request->input('farmer_reply'),
            'farmer_replied_at' => now(),
        ]);

        return back()->with('success', 'Response posted to customer review.');
    }
}
