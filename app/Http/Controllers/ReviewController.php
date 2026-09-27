<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'nullable|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        $order = Order::where('customer_id', Auth::id())
            ->where('id', $validated['order_id'])
            ->firstOrFail();

        // Check if review already exists for this order
        $existing = Review::where('customer_id', Auth::id())
            ->where('order_id', $order->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already submitted a review for this order.');
        }

        Review::create([
            'customer_id' => Auth::id(),
            'farmer_id' => $order->farmer_id,
            'product_id' => $validated['product_id'] ?? null,
            'order_id' => $order->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'published',
        ]);

        return back()->with('success', 'Thank you for your rating and review!');
    }
}
