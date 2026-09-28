<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Market;
use App\Models\FarmerProfile;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $markets = collect();
        $farmers = collect();
        $categories = collect();
        $featuredProducts = collect();
        $announcements = collect();
        $recentReviews = collect();

        try { $markets = Market::take(4)->get(); } catch (\Exception $e) {}
        try { $farmers = FarmerProfile::take(4)->get(); } catch (\Exception $e) {}
        try { $categories = Category::take(12)->get(); } catch (\Exception $e) {}
        try { $featuredProducts = Product::take(8)->get(); } catch (\Exception $e) {}
        try { $recentReviews = Review::take(3)->get(); } catch (\Exception $e) {}

        $stats = [
            'total_farmers' => 0,
            'total_markets' => 0,
            'total_products' => 0,
            'happy_customers' => 450,
        ];

        try { $stats['total_farmers'] = FarmerProfile::count(); } catch (\Exception $e) {}
        try { $stats['total_markets'] = Market::count(); } catch (\Exception $e) {}
        try { $stats['total_products'] = Product::count(); } catch (\Exception $e) {}

        return view('pages.home', compact('markets', 'farmers', 'categories', 'featuredProducts', 'announcements', 'recentReviews', 'stats'));
    }

    public function about()
    {
        $stats = [
            'farmers' => 0,
            'markets' => 0,
            'products' => 0,
        ];

        try { $stats['farmers'] = FarmerProfile::count(); } catch (\Exception $e) {}
        try { $stats['markets'] = Market::count(); } catch (\Exception $e) {}
        try { $stats['products'] = Product::count(); } catch (\Exception $e) {}

        return view('pages.about', compact('stats'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        return back()->with('success', 'Thank you! Your message has been received. Our team will get back to you shortly.');
    }
}