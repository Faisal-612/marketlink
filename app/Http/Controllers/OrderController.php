<?php

namespace App\Http\Controllers;

use App\Models\FarmerProfile;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('info', 'Your cart is empty. Please select products to pre-order.');
        }

        $firstItem = reset($cart);
        $farmerProfile = FarmerProfile::where('user_id', $firstItem['farmer_id'])
            ->with(['market', 'user'])
            ->firstOrFail();

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Generate next 5 pickup date options based on operating days
        $pickupDates = [];
        $opDays = explode(',', $farmerProfile->operating_days ?? 'Saturday, Sunday');
        $opDays = array_map('trim', $opDays);

        for ($i = 0; $i < 14; $i++) {
            $date = now()->addDays($i);
            $dayName = $date->format('l');
            if (in_array($dayName, $opDays)) {
                $pickupDates[] = [
                    'date' => $date->format('Y-m-d'),
                    'label' => $date->format('l, M d, Y'),
                ];
            }
        }

        // Generate time slots
        $rawStart = $farmerProfile->pickup_time_start ?: '08:00';
        $rawEnd = $farmerProfile->pickup_time_end ?: '14:00';
        
        $startTs = strtotime($rawStart);
        $endTs = strtotime($rawEnd);
        
        if (!$startTs || !$endTs || $endTs <= $startTs) {
            $startTs = strtotime('08:00');
            $endTs = strtotime('14:00');
        }

        $timeSlots = [];
        $current = $startTs;
        while ($current < $endTs) {
            $next = strtotime('+1 hour', $current);
            if ($next > $endTs) {
                $next = $endTs;
            }
            $fromStr = date("g:i A", $current);
            $toStr = date("g:i A", $next);
            $timeSlots[] = [
                'slot' => "$fromStr - $toStr",
                'from_hour' => (int)date('H', $current),
                'to_hour' => (int)date('H', $next),
                'to_minute' => (int)date('i', $next),
            ];
            $current = $next;
        }

        if (empty($timeSlots)) {
            $timeSlots[] = [
                'slot' => '8:00 AM - 12:00 PM (Morning Slot)',
                'from_hour' => 8,
                'to_hour' => 12,
                'to_minute' => 0,
            ];
        }

        $todayDate = now()->format('Y-m-d');
        $currentHour = (int)now()->format('H');
        $currentMinute = (int)now()->format('i');

        return view('orders.checkout', compact('cart', 'total', 'farmerProfile', 'pickupDates', 'timeSlots', 'todayDate', 'currentHour', 'currentMinute'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time_slot' => 'required|string',
            'customer_notes' => 'nullable|string|max:500',
        ]);

        $firstItem = reset($cart);
        $farmerId = $firstItem['farmer_id'];

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number' => 'ML-' . strtoupper(Str::random(8)),
                'customer_id' => Auth::id(),
                'farmer_id' => $farmerId,
                'total_amount' => $total,
                'pickup_date' => $validated['pickup_date'],
                'pickup_time_slot' => $validated['pickup_time_slot'],
                'order_status' => 'placed',
                'payment_status' => 'pay_at_pickup_pending',
                'customer_notes' => $validated['customer_notes'],
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'unit_price' => $item['price'],
                    'unit' => $item['unit'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Reduce stock
                $product = Product::find($item['id']);
                if ($product && $product->stock_quantity >= $item['quantity']) {
                    $product->decrement('stock_quantity', $item['quantity']);
                }
            }

            // Create notification for farmer
            Notification::create([
                'user_id' => $farmerId,
                'title' => 'New Pre-Order Received!',
                'message' => "Order #{$order->order_number} has been placed by " . Auth::user()->name . " for pickup on {$order->pickup_date->format('M d, Y')}.",
                'link' => route('farmer.orders.show', $order->id),
            ]);

            DB::commit();
            session()->forget('cart');

            return redirect()->route('customer.orders.show', $order->id)
                ->with('success', 'Your pre-order has been placed successfully! Remember, payment is settled at pickup.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place pre-order: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $orders = Order::where('customer_id', Auth::id())
            ->with(['farmer.farmerProfile.market', 'items'])
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('customer_id', Auth::id())
            ->with(['farmer.farmerProfile.market', 'items.product', 'customer'])
            ->findOrFail($id);

        return view('customer.orders.show', compact('order'));
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::where('customer_id', Auth::id())->findOrFail($id);

        if (!in_array($order->order_status, ['placed', 'accepted'])) {
            return back()->with('error', 'This order cannot be cancelled as it is already ' . $order->order_status);
        }

        $order->order_status = 'cancelled';
        $order->cancelled_reason = $request->input('reason', 'Cancelled by customer before cutoff');
        $order->save();

        // Restore stock
        foreach ($order->items as $item) {
            if ($item->product_id) {
                Product::where('id', $item->product_id)->increment('stock_quantity', $item->quantity);
            }
        }

        // Notify farmer
        Notification::create([
            'user_id' => $order->farmer_id,
            'title' => 'Pre-Order Cancelled',
            'message' => "Order #{$order->order_number} was cancelled by customer.",
            'link' => route('farmer.orders.show', $order->id),
        ]);

        return back()->with('success', 'Order cancelled successfully.');
    }

    public function reorder($id)
    {
        $order = Order::where('customer_id', Auth::id())->with('items.product')->findOrFail($id);

        $cart = [];
        foreach ($order->items as $item) {
            if ($item->product && $item->product->is_available) {
                $cart[$item->product_id] = [
                    'id' => $item->product_id,
                    'name' => $item->product_name,
                    'price' => (float) $item->unit_price,
                    'unit' => $item->unit,
                    'quantity' => $item->quantity,
                    'image' => $item->product->image,
                    'farmer_id' => $order->farmer_id,
                    'stall_name' => $order->farmer->farmerProfile->stall_name ?? 'Local Farm',
                    'market_name' => $order->farmer->farmerProfile->market->name ?? 'Farmers Market',
                ];
            }
        }

        if (empty($cart)) {
            return back()->with('error', 'None of the items from this previous order are currently available.');
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Previous order items added to your cart!');
    }
}
