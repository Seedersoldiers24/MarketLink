<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\FarmerProfile;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please log in to complete your pickup pre-order.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Your basket is empty. Please add farm produce before checkout.');
        }

        // Group by farmer
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

        $user = Auth::user();
        return view('pages.checkout.index', compact('groupedCart', 'total', 'user'));
    }

    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $user = Auth::user();

        // Validate pickup details per farmer stall
        $request->validate([
            'pickup_dates' => 'required|array',
            'pickup_dates.*' => 'required|date|after_or_equal:today',
            'pickup_slots' => 'required|array',
            'pickup_slots.*' => 'required|string',
            'customer_notes' => 'nullable|array',
        ]);

        $pickupDates = $request->input('pickup_dates');
        $pickupSlots = $request->input('pickup_slots');
        $customerNotes = $request->input('customer_notes', []);

        // Group cart by farmer
        $farmerItems = [];
        foreach ($cart as $productId => $item) {
            $farmerItems[$item['farmer_id']][] = $item;
        }

        $createdOrders = [];

        DB::beginTransaction();
        try {
            foreach ($farmerItems as $farmerId => $items) {
                $farmer = FarmerProfile::findOrFail($farmerId);
                $pickupDate = $pickupDates[$farmerId] ?? now()->addDay()->format('Y-m-d');
                $pickupSlot = $pickupSlots[$farmerId] ?? '09:00 AM - 11:00 AM';
                $notes = $customerNotes[$farmerId] ?? null;

                // Calculate total
                $subtotal = 0;
                foreach ($items as $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                }

                // Calculate cutoff time: e.g. pickup day at midnight minus cutoff_hours
                $cutoff = Carbon::parse($pickupDate)->startOfDay()->subHours($farmer->cutoff_hours_before);

                $orderNumber = 'ML-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

                $order = Order::create([
                    'order_number' => $orderNumber,
                    'customer_id' => $user->id,
                    'farmer_id' => $farmer->id,
                    'market_id' => $farmer->market_id,
                    'total_amount' => $subtotal,
                    'pickup_date' => $pickupDate,
                    'pickup_time_slot' => $pickupSlot,
                    'order_status' => 'placed',
                    'payment_status' => 'Pay at Pickup (Cash/Card)',
                    'customer_notes' => $notes,
                    'cutoff_time' => $cutoff,
                ]);

                foreach ($items as $item) {
                    $product = Product::lockForUpdate()->find($item['id']);
                    if ($product) {
                        $product->decrement('stock_quantity', $item['quantity']);
                        if ($product->stock_quantity <= 0) {
                            $product->update(['is_sold_out' => true]);
                        }
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['price'],
                        'subtotal' => $item['price'] * $item['quantity'],
                    ]);
                }

                $createdOrders[] = $order;
            }

            DB::commit();
            session()->forget('cart');

            $firstOrderNumber = $createdOrders[0]->order_number ?? '';
            return redirect()->route('orders.confirmation', $firstOrderNumber)->with('success', 'Your farm pre-order was successfully placed!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error placing order: ' . $e->getMessage());
        }
    }

    public function confirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['farmer.market', 'items.product', 'customer'])
            ->firstOrFail();

        return view('pages.checkout.confirmation', compact('order'));
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::where('customer_id', Auth::id())->findOrFail($id);

        if (!$order->canBeCancelledOrModified()) {
            return back()->with('error', 'Order cannot be cancelled. The cutoff time has passed or order is already processed.');
        }

        // Restore stock
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock_quantity', $item->quantity);
                if ($product->is_sold_out) {
                    $product->update(['is_sold_out' => false]);
                }
            }
        }

        $order->update(['order_status' => 'cancelled']);

        return back()->with('success', 'Order #' . $order->order_number . ' has been cancelled successfully.');
    }

    public function updateNotes(Request $request, $id)
    {
        $order = Order::where('customer_id', Auth::id())->findOrFail($id);

        if (!$order->canBeCancelledOrModified()) {
            return back()->with('error', 'Order notes cannot be modified. Cutoff time has passed.');
        }

        $request->validate(['customer_notes' => 'required|string|max:500']);
        $order->update(['customer_notes' => $request->input('customer_notes')]);

        return back()->with('success', 'Pickup notes updated successfully.');
    }

    public function reorder($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        $cart = session()->get('cart', []);

        $addedCount = 0;
        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product && !$product->is_sold_out && $product->stock_quantity > 0) {
                $qty = min($item->quantity, $product->stock_quantity);
                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => (float) $product->price,
                    'unit' => $product->unit,
                    'image' => $product->image,
                    'quantity' => $qty,
                    'farmer_id' => $product->farmer_id,
                    'farmer_name' => $order->farmer->stall_name ?? 'Farmer Stall',
                ];
                $addedCount++;
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', "$addedCount item(s) re-added to your farm basket!");
    }
}
