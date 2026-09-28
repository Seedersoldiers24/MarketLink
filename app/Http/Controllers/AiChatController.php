<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Market;
use App\Models\FarmerProfile;

class AiChatController extends Controller
{
    public function reply(Request $request)
    {
        $message = strtolower(trim($request->input('message', '')));

        if (empty($message)) {
            return response()->json([
                'reply' => "Hello! I am your **MarketLink AI Assistant**. How can I help you today? You can ask about available produce, market timings, farmer pickup slots, or cutoff policies.",
                'suggestions' => ['Where can I get fresh strawberries?', 'What markets are open on Saturday?', 'How does pickup work?', 'Tell me about sourdough bread']
            ]);
        }

        // 1. Markets & Timings queries
        if (str_contains($message, 'market') || str_contains($message, 'timing') || str_contains($message, 'hour') || str_contains($message, 'open') || str_contains($message, 'saturday') || str_contains($message, 'sunday')) {
            $markets = Market::where('is_active', true)->get();
            $reply = "Here are our active farmers markets in Springfield:\n\n";
            foreach ($markets as $m) {
                $reply .= "• **{$m->market_name}** ({$m->city}): Open **{$m->operating_days}** from *{$m->timings}*. Located at *{$m->address}*.\n";
            }
            $reply .= "\nYou can view live maps and directions on the [Markets Directory](/markets).";

            return response()->json([
                'reply' => $reply,
                'suggestions' => ['What produce is in season?', 'How do I place a pre-order?', 'Show me local farmers']
            ]);
        }

        // 2. Pickup and pre-order queries
        if (str_contains($message, 'pickup') || str_contains($message, 'pre-order') || str_contains($message, 'how it works') || str_contains($message, 'order') || str_contains($message, 'pay') || str_contains($message, 'cutoff')) {
            $reply = "### How MarketLink Pre-Orders Work:\n\n"
                   . "1. **Browse & Add to Basket**: Choose fresh seasonal goods from local verified farmers.\n"
                   . "2. **Select Pickup Slot**: Pick your designated date and morning/afternoon time window at the farmer's stall.\n"
                   . "3. **Cut-off Times**: Each farmer has a cutoff (typically 8–14 hours before market day) so they can harvest and pack your fresh goods.\n"
                   . "4. **Zero Hassle Payment**: Orders are paid for in-person at the stall (Cash or Card) when you collect your farm-fresh basket!\n"
                   . "5. **Modifications**: You can easily cancel or update your order notes before the farmer cutoff time.";

            return response()->json([
                'reply' => $reply,
                'suggestions' => ['Find organic vegetables', 'View all markets', 'Recommend top farmers']
            ]);
        }

        // 3. Specific product searches (e.g. strawberries, sourdough, tomatoes, honey, cheese, apples)
        $keywords = ['strawberry', 'strawberries', 'tomato', 'tomatoes', 'sourdough', 'bread', 'honey', 'cheese', 'milk', 'egg', 'carrot', 'lettuce', 'basil', 'blueberry', 'blueberries', 'apple', 'butter', 'focaccia'];
        $foundKeyword = null;
        foreach ($keywords as $kw) {
            if (str_contains($message, $kw)) {
                $foundKeyword = $kw;
                break;
            }
        }

        if ($foundKeyword) {
            $searchTerm = rtrim($foundKeyword, 's');
            $products = Product::where('name', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%")
                ->with(['farmer.market'])
                ->take(3)
                ->get();

            if ($products->isNotEmpty()) {
                $reply = "I found matching fresh farm produce for you:\n\n";
                foreach ($products as $p) {
                    $stockText = $p->in_stock ? "In Stock ({$p->stock_quantity} {$p->unit} available)" : "Sold Out";
                    $farmerName = $p->farmer->stall_name ?? 'Local Farmer';
                    $marketName = $p->farmer->market->market_name ?? 'Farmers Market';
                    $reply .= "• **[{$p->name}](/products/{$p->slug})** — **\${$p->price}** per {$p->unit}\n"
                           . "  *Sold by:* {$farmerName} at {$marketName}\n"
                           . "  *Status:* {$stockText}\n\n";
                }
                $reply .= "Would you like me to add one of these to your basket?";

                return response()->json([
                    'reply' => $reply,
                    'suggestions' => ['View all products', 'Where is this market located?', 'How do I pick it up?']
                ]);
            }
        }

        // 4. Farmer queries
        if (str_contains($message, 'farmer') || str_contains($message, 'grower') || str_contains($message, 'stall')) {
            $farmers = FarmerProfile::where('is_approved', true)->with('market')->take(4)->get();
            $reply = "Here are some of our community-favorite verified farmers:\n\n";
            foreach ($farmers as $f) {
                $market = $f->market ? $f->market->market_name : 'Local Market';
                $reply .= "• **[{$f->stall_name}](/farmers/{$f->id})** — *{$f->contact_person}*\n"
                       . "  Stall at: {$market} (Operating: {$f->operating_days})\n"
                       . "  *Specialty:* {$f->bio}\n\n";
            }
            $reply .= "Visit our [Farmers Directory](/farmers) to explore their weekly stock!";

            return response()->json([
                'reply' => $reply,
                'suggestions' => ['Browse market stalls', 'Order fresh sourdough', 'Show organic honey']
            ]);
        }

        // 5. Default intelligent assistant response
        return response()->json([
            'reply' => "I understand you are asking about: *\"" . htmlspecialchars($request->input('message')) . "\"*.\n\n"
                     . "MarketLink connects you directly with Springfield's best local farmers markets! You can pre-order organic vegetables, ripe fruits, warm artisan breads, dairy, and pure wildflower honey for express pickup.\n\n"
                     . "Try asking:\n"
                     . "• \"*Which markets are open this Saturday?*\"\n"
                     . "• \"*Find sourdough bread*\"\n"
                     . "• \"*What is the pre-order cutoff policy?*\"",
            'suggestions' => ['Saturday Markets', 'Organic Strawberries', 'Artisan Bakery', 'Pickup Cutoff Info']
        ]);
    }
}
