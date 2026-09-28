<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Favorite;
use App\Models\FarmerProfile;
use App\Models\Product;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $orders = Order::where('customer_id', $user->id)
            ->with(['farmer.market', 'items.product', 'reviews'])
            ->latest()
            ->paginate(10);

        $activeOrders = Order::where('customer_id', $user->id)
            ->whereIn('order_status', ['placed', 'accepted', 'ready_for_pickup'])
            ->with(['farmer.market', 'items.product'])
            ->latest()
            ->get();

        $stats = [
            'total_orders' => Order::where('customer_id', $user->id)->count(),
            'active_orders' => $activeOrders->count(),
            'completed_orders' => Order::where('customer_id', $user->id)->where('order_status', 'completed')->count(),
            'saved_favorites' => Favorite::where('user_id', $user->id)->count(),
        ];

        return view('pages.customer.dashboard', compact('orders', 'activeOrders', 'stats', 'user'));
    }

    public function favorites()
    {
        $user = Auth::user();
        $favProducts = Favorite::where('user_id', $user->id)
            ->where('favoritable_type', Product::class)
            ->with('favoritable.farmer')
            ->get()
            ->pluck('favoritable')
            ->filter();

        $favFarmers = Favorite::where('user_id', $user->id)
            ->where('favoritable_type', FarmerProfile::class)
            ->with('favoritable.market')
            ->get()
            ->pluck('favoritable')
            ->filter();

        return view('pages.customer.favorites', compact('favProducts', 'favFarmers'));
    }

    public function toggleFavorite(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $type = $request->input('type'); // 'product' or 'farmer'
        $id = $request->input('id');

        $modelClass = ($type === 'farmer') ? FarmerProfile::class : Product::class;
        $existing = Favorite::where('user_id', Auth::id())
            ->where('favoritable_type', $modelClass)
            ->where('favoritable_id', $id)
            ->first();

        if ($existing) {
            $existing->delete();
            $msg = 'Removed from your favorites.';
            $saved = false;
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'favoritable_type' => $modelClass,
                'favoritable_id' => $id,
            ]);
            $msg = 'Saved to your favorites!';
            $saved = true;
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'saved' => $saved, 'message' => $msg]);
        }

        return back()->with('success', $msg);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('pages.customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:500',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }
}
