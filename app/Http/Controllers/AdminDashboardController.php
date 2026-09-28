<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\FarmerProfile;
use App\Models\Market;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use App\Models\Category;
use App\Models\Announcement;
use App\Models\Report;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_farmers' => FarmerProfile::count(),
            'approved_farmers' => FarmerProfile::where('is_approved', true)->count(),
            'pending_farmers' => FarmerProfile::where('is_approved', false)->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_markets' => Market::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::whereIn('order_status', ['completed', 'accepted', 'ready_for_pickup'])->sum('total_amount'),
            'total_reviews' => Review::count(),
        ];

        $recentOrders = Order::with(['customer', 'farmer', 'market'])->latest()->take(6)->get();
        $pendingFarmers = FarmerProfile::where('is_approved', false)->with('user')->get();
        $recentReviews = Review::with(['customer', 'farmer', 'product'])->latest()->take(5)->get();

        return view('pages.admin.dashboard', compact('stats', 'recentOrders', 'pendingFarmers', 'recentReviews'));
    }

    public function farmers()
    {
        $farmers = FarmerProfile::with(['user', 'market', 'products'])->latest()->paginate(10);
        return view('pages.admin.farmers', compact('farmers'));
    }

    public function toggleFarmerApproval($id)
    {
        $farmer = FarmerProfile::findOrFail($id);
        $farmer->is_approved = !$farmer->is_approved;
        $farmer->save();

        $action = $farmer->is_approved ? 'approved' : 'suspended';
        return back()->with('success', "Farmer '{$farmer->stall_name}' has been {$action}.");
    }

    public function customers()
    {
        $customers = User::where('role', 'customer')->withCount('orders')->latest()->paginate(10);
        return view('pages.admin.customers', compact('customers'));
    }

    public function toggleCustomerStatus($id)
    {
        $user = User::where('role', 'customer')->findOrFail($id);
        $user->status = ($user->status === 'active') ? 'deactivated' : 'active';
        $user->save();

        return back()->with('success', "Customer account {$user->name} status changed to {$user->status}.");
    }

    public function markets()
    {
        $markets = Market::withCount(['farmers', 'orders'])->paginate(10);
        return view('pages.admin.markets', compact('markets'));
    }

    public function storeMarket(Request $request)
    {
        $validated = $request->validate([
            'market_name' => 'required|string|max:150',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'operating_days' => 'required|string|max:100',
            'timings' => 'required|string|max:100',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|url|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['market_name']) . '-' . rand(100, 999);
        $validated['image'] = $validated['image'] ?: 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=800&q=80';

        Market::create($validated);

        return back()->with('success', 'Market created and mapped successfully.');
    }

    public function updateMarket(Request $request, $id)
    {
        $market = Market::findOrFail($id);
        $validated = $request->validate([
            'market_name' => 'required|string|max:150',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'operating_days' => 'required|string|max:100',
            'timings' => 'required|string|max:100',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|url|max:500',
        ]);

        $market->update($validated);

        return back()->with('success', "Market '{$market->market_name}' updated successfully.");
    }

    public function destroyMarket($id)
    {
        $market = Market::findOrFail($id);
        $market->delete();

        return back()->with('success', 'Market removed from platform.');
    }

    public function moderation()
    {
        $reviews = Review::with(['customer', 'farmer', 'product'])->latest()->paginate(15);
        $products = Product::with(['farmer', 'category'])->latest()->paginate(15);

        return view('pages.admin.moderation', compact('reviews', 'products'));
    }

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Review moderated and removed.');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'Product moderated and removed from platform.');
    }

    public function reports()
    {
        $reports = Report::with('generator')->latest()->get();

        $marketRevenue = Market::with('orders')->get()->map(function($market) {
            return [
                'market_name' => $market->market_name,
                'city' => $market->city,
                'orders_count' => $market->orders->count(),
                'revenue' => $market->orders->whereIn('order_status', ['completed', 'accepted', 'ready_for_pickup'])->sum('total_amount'),
            ];
        });

        $topFarmers = FarmerProfile::withCount('orders')
            ->with(['user', 'orders'])
            ->get()
            ->map(function($f) {
                return [
                    'stall_name' => $f->stall_name,
                    'contact_person' => $f->contact_person,
                    'orders_count' => $f->orders_count,
                    'revenue' => $f->orders->whereIn('order_status', ['completed', 'accepted', 'ready_for_pickup'])->sum('total_amount'),
                ];
            })
            ->sortByDesc('revenue')
            ->take(5);

        return view('pages.admin.reports', compact('reports', 'marketRevenue', 'topFarmers'));
    }

    public function generateReport(Request $request)
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('order_status', ['completed', 'accepted', 'ready_for_pickup'])->sum('total_amount');
        $farmersCount = FarmerProfile::count();
        $customersCount = User::where('role', 'customer')->count();

        Report::create([
            'generated_by' => auth()->id(),
            'report_type' => 'platform_summary',
            'title' => 'Official MarketLink Platform Audit & Sales Report - ' . date('M Y'),
            'summary' => "Total gross orders: {$totalOrders}, aggregate farm payout: \${$totalRevenue}. Active network: {$farmersCount} farmer stalls across Springfield.",
            'data' => [
                'total_revenue' => $totalRevenue,
                'total_orders' => $totalOrders,
                'active_farmers' => $farmersCount,
                'active_customers' => $customersCount,
                'generated_at' => now()->toDateTimeString(),
            ],
        ]);

        return back()->with('success', 'New audit report generated and archived successfully.');
    }

    public function categories()
    {
        $categories = Category::withCount('products')->get();
        return view('pages.admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'icon' => 'required|string|max:50',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|url|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['image'] = $validated['image'] ?: 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=600&q=80';

        Category::create($validated);

        return back()->with('success', 'Master Category created successfully.');
    }

    public function announcements()
    {
        $announcements = Announcement::with('admin')->latest()->paginate(10);
        return view('pages.admin.announcements', compact('announcements'));
    }

    public function storeAnnouncement(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
            'target_role' => 'required|in:all,customer,farmer',
        ]);

        Announcement::create([
            'admin_id' => auth()->id(),
            'title' => $validated['title'],
            'message' => $validated['message'],
            'target_role' => $validated['target_role'],
            'is_active' => true,
        ]);

        return back()->with('success', 'Platform broadcast announcement published successfully.');
    }

    public function deleteAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return back()->with('success', 'Announcement removed.');
    }
}
