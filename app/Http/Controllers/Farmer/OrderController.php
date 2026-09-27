<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $farmerId = Auth::id();
        $status = $request->query('status');
        $date = $request->query('date');

        $query = Order::where('farmer_id', $farmerId)
            ->with(['customer', 'items.product']);

        if ($status) {
            $query->where('order_status', $status);
        }

        if ($date) {
            $query->whereDate('pickup_date', $date);
        }

        $orders = $query->latest()->paginate(12)->withQueryString();

        return view('farmer.orders.index', compact('orders', 'status', 'date'));
    }

    public function show($id)
    {
        $order = Order::where('farmer_id', Auth::id())
            ->with(['customer', 'items.product'])
            ->findOrFail($id);

        return view('farmer.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('farmer_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'order_status' => 'required|in:accepted,ready_for_pickup,completed,cancelled',
            'farmer_notes' => 'nullable|string',
            'payment_status' => 'nullable|in:pay_at_pickup_pending,paid_at_pickup',
        ]);

        $order->order_status = $validated['order_status'];
        if ($request->filled('farmer_notes')) {
            $order->farmer_notes = $validated['farmer_notes'];
        }
        if ($request->filled('payment_status')) {
            $order->payment_status = $validated['payment_status'];
        }

        // If completed, automatically mark payment as collected
        if ($validated['order_status'] === 'completed') {
            $order->payment_status = 'paid_at_pickup';
        }

        // If cancelled, restore stock
        if ($validated['order_status'] === 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    Product::where('id', $item->product_id)->increment('stock_quantity', $item->quantity);
                }
            }
        }

        $order->save();

        // Notify customer
        Notification::create([
            'user_id' => $order->customer_id,
            'title' => 'Order Status Updated: ' . $order->status_label,
            'message' => "Your pre-order #{$order->order_number} is now {$order->status_label}.",
            'link' => route('customer.orders.show', $order->id),
        ]);

        return back()->with('success', "Order #{$order->order_number} status updated to: " . $order->status_label);
    }
}
