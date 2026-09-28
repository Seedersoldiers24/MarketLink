<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FarmerProfile;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $groupedCart = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $total += $item['price'] * $item['quantity'];
            $farmerId = $item['farmer_id'];
            if (!isset($groupedCart[$farmerId])) {
                $farmer = FarmerProfile::with('market')->find($farmerId);
                $groupedCart[$farmerId] = [
                    'farmer' => $farmer,
                    'items' => [],
                    'subtotal' => 0,
                ];
            }
            $groupedCart[$farmerId]['items'][$productId] = $item;
            $groupedCart[$farmerId]['subtotal'] += $item['price'] * $item['quantity'];
        }

        return view('pages.cart.index', compact('groupedCart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $qty = $request->input('quantity', 1);

        $product = Product::with('farmer')->findOrFail($productId);

        if ($product->is_sold_out || $product->stock_quantity < 1) {
            return back()->with('error', 'Sorry, this product is currently sold out.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $newQty = $cart[$productId]['quantity'] + $qty;
            if ($newQty > $product->stock_quantity) {
                return back()->with('error', "Only {$product->stock_quantity} {$product->unit} available in stock.");
            }
            $cart[$productId]['quantity'] = $newQty;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float) $product->price,
                'unit' => $product->unit,
                'image' => $product->image,
                'quantity' => $qty,
                'farmer_id' => $product->farmer_id,
                'farmer_name' => $product->farmer->stall_name ?? 'Local Farmer',
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$product->name} added to your basket!",
                'cartCount' => array_sum(array_column($cart, 'quantity')),
                'cartTotal' => array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0),
            ]);
        }

        return back()->with('success', "{$product->name} added to your basket!");
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $product = Product::find($productId);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($product && $quantity > $product->stock_quantity) {
                return back()->with('error', "Only {$product->stock_quantity} available.");
            }
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Basket updated successfully.');
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item removed from basket.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Basket cleared.');
    }
}
