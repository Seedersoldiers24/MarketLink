<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Market;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        $query = Market::where('is_active', true)->withCount('farmers');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('market_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('day')) {
            $day = $request->input('day');
            $query->where('operating_days', 'like', "%{$day}%");
        }

        $markets = $query->paginate(9)->withQueryString();

        // Prepare map coordinates GeoJSON/array for Leaflet Map
        $mapMarkers = $markets->map(function ($market) {
            return [
                'id' => $market->id,
                'name' => $market->market_name,
                'slug' => $market->slug,
                'lat' => $market->latitude,
                'lng' => $market->longitude,
                'address' => $market->address,
                'days' => $market->operating_days,
                'timings' => $market->timings,
                'url' => route('markets.show', $market->slug),
            ];
        });

        return view('pages.markets.index', compact('markets', 'mapMarkers'));
    }

    public function show($slug)
    {
        $market = Market::where('slug', $slug)
            ->where('is_active', true)
            ->with(['farmers.products' => function($q) {
                $q->where('is_sold_out', false)->take(4);
            }, 'farmers.reviews'])
            ->firstOrFail();

        return view('pages.markets.show', compact('market'));
    }
}
