<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FarmerProfile;
use App\Models\Market;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFarmers = User::where('role', 'farmer')->count();
        $pendingFarmers = FarmerProfile::where('status', 'pending')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalMarkets = Market::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('order_status', ['completed', 'ready_for_pickup', 'accepted'])->sum('total_amount');

        $recentOrders = Order::with(['customer', 'farmer.farmerProfile'])
            ->latest()
            ->take(6)
            ->get();

        $pendingApprovals = FarmerProfile::where('status', 'pending')
            ->with(['user', 'market'])
            ->take(5)
            ->get();

        $topFarmers = Order::where('order_status', '!=', 'cancelled')
            ->select('farmer_id', DB::raw('COUNT(id) as total_orders'), DB::raw('SUM(total_amount) as revenue'))
            ->groupBy('farmer_id')
            ->orderByDesc('revenue')
            ->with('farmer.farmerProfile')
            ->take(5)
            ->get();

        $totalProducts = Product::count();
        $totalCategories = \App\Models\Category::count();
        $pendingOrders = Order::whereIn('order_status', ['placed', 'accepted'])->count();
        $markets = Market::withCount('farmerProfiles')->take(4)->get();

        return view('admin.dashboard', compact(
            'totalFarmers',
            'pendingFarmers',
            'totalCustomers',
            'totalMarkets',
            'totalProducts',
            'totalCategories',
            'pendingOrders',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'pendingApprovals',
            'topFarmers',
            'markets'
        ));
    }
}
