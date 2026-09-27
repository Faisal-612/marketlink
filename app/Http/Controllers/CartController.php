<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = max(1, (int) $request->input('quantity', 1));

        $product = Product::with('farmer.farmerProfile.market')->findOrFail($productId);

        if (!$product->is_available || $product->is_sold_out) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This item is currently sold out or unavailable.',
                ], 422);
            }
            return back()->with('error', 'This item is currently sold out or unavailable.');
        }

        $cart = session()->get('cart', []);

        if (!empty($cart)) {
            $firstItem = reset($cart);
            if ($firstItem['farmer_id'] != $product->farmer_id) {
                $msg = 'Pre-orders are placed per farmer stall. Please complete or clear your current basket before ordering from another stall.';
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $msg,
                    ], 422);
                }
                return back()->with('error', $msg);
            }
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'unit' => $product->unit,
                'quantity' => $quantity,
                'image' => $product->image_url,
                'farmer_id' => $product->farmer_id,
                'stall_name' => $product->farmer->farmerProfile->stall_name ?? 'Local Farm',
                'market_name' => $product->farmer->farmerProfile->market->name ?? 'Farmers Market',
            ];
        }

        session()->put('cart', $cart);

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;
        foreach ($cart as $it) {
            $totalPrice += $it['price'] * $it['quantity'];
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Added {$product->name} to basket!",
                'cartCount' => $totalItems,
                'uniqueCount' => count($cart),
                'totalPrice' => $totalPrice,
            ]);
        }

        return back()->with('success', "Added {$product->name} to your pre-order basket!");
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $quantities = $request->input('quantities', []);

        foreach ($quantities as $id => $qty) {
            $qty = (int) $qty;
            if ($qty > 0 && isset($cart[$id])) {
                $cart[$id]['quantity'] = $qty;
            } elseif ($qty <= 0 && isset($cart[$id])) {
                unset($cart[$id]);
            }
        }

        session()->put('cart', $cart);

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;
        $subtotals = [];
        foreach ($cart as $id => $it) {
            $sub = $it['price'] * $it['quantity'];
            $totalPrice += $sub;
            $subtotals[$id] = number_format($sub, 2);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully.',
                'cartCount' => $totalItems,
                'totalPrice' => number_format($totalPrice, 2),
                'subtotals' => $subtotals,
            ]);
        }

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove($id, Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;
        foreach ($cart as $it) {
            $totalPrice += $it['price'] * $it['quantity'];
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from basket.',
                'cartCount' => $totalItems,
                'totalPrice' => number_format($totalPrice, 2),
                'isEmpty' => empty($cart),
            ]);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear(Request $request)
    {
        session()->forget('cart');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Basket cleared.',
                'cartCount' => 0,
            ]);
        }

        return back()->with('success', 'Cart cleared.');
    }
}
