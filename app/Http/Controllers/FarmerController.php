<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FarmerProfile;
use App\Models\Market;
use App\Models\Review;

class FarmerController extends Controller
{
    public function index(Request $request)
    {
        $query = FarmerProfile::where('is_approved', true)->with(['user', 'market', 'reviews', 'products']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('stall_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        if ($request->filled('market_id')) {
            $query->where('market_id', $request->input('market_id'));
        }

        if ($request->filled('day')) {
            $day = $request->input('day');
            $query->where('operating_days', 'like', "%{$day}%");
        }

        $farmers = $query->paginate(9)->withQueryString();
        $markets = Market::where('is_active', true)->get();

        return view('pages.farmers.index', compact('farmers', 'markets'));
    }

    public function show($id)
    {
        $farmer = FarmerProfile::where('is_approved', true)
            ->with(['user', 'market', 'products.category', 'reviews.customer'])
            ->findOrFail($id);

        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Auth::user()->favorites()
                ->where('favoritable_type', FarmerProfile::class)
                ->where('favoritable_id', $farmer->id)
                ->exists();
        }

        return view('pages.farmers.show', compact('farmer', 'isFavorite'));
    }

    public function storeReview(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to leave a review.');
        }

        $farmer = FarmerProfile::findOrFail($id);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        Review::create([
            'customer_id' => Auth::id(),
            'farmer_id' => $farmer->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Thank you! Your review has been published.');
    }
}
