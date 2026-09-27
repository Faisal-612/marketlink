<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $farmer = Auth::user();
        $profile = $farmer->farmerProfile;

        $totalOrders = Order::where('farmer_id', $farmer->id)->count();
        $pendingOrders = Order::where('farmer_id', $farmer->id)->whereIn('order_status', ['placed', 'accepted'])->count();
        $completedOrders = Order::where('farmer_id', $farmer->id)->where('order_status', 'completed')->count();
        
        $totalRevenue = Order::where('farmer_id', $farmer->id)
            ->whereIn('order_status', ['completed', 'ready_for_pickup'])
            ->sum('total_amount');

        $activeProductsCount = Product::where('farmer_id', $farmer->id)->where('is_available', true)->count();

        $recentOrders = Order::where('farmer_id', $farmer->id)
            ->with(['customer', 'items'])
            ->latest()
            ->take(5)
            ->get();

        $bestSellers = OrderItem::whereHas('order', function ($q) use ($farmer) {
                $q->where('farmer_id', $farmer->id)->where('order_status', '!=', 'cancelled');
            })
            ->select('product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        $recentReviews = Review::where('farmer_id', $farmer->id)
            ->with('customer')
            ->latest()
            ->take(4)
            ->get();

        $totalProducts = $activeProductsCount;
        $totalReviews = Review::where('farmer_id', $farmer->id)->count();
        $averageRating = Review::where('farmer_id', $farmer->id)->avg('rating') ?: 5.0;

        return view('farmer.dashboard', compact(
            'farmer',
            'profile',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'activeProductsCount',
            'totalProducts',
            'totalReviews',
            'averageRating',
            'recentOrders',
            'bestSellers',
            'recentReviews'
        ));
    }
}
