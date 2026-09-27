<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->format('Y-m-d'));

        // Orders summary by status
        $ordersByStatus = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select('order_status', DB::raw('COUNT(id) as count'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('order_status')
            ->get();

        // Revenue by Market
        $revenueByMarket = DB::table('orders')
            ->join('users', 'orders.farmer_id', '=', 'users.id')
            ->join('farmer_profiles', 'users.id', '=', 'farmer_profiles.user_id')
            ->join('markets', 'farmer_profiles.market_id', '=', 'markets.id')
            ->whereBetween('orders.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('orders.order_status', '!=', 'cancelled')
            ->select('markets.name as market_name', 'markets.city', DB::raw('COUNT(orders.id) as total_orders'), DB::raw('SUM(orders.total_amount) as total_revenue'))
            ->groupBy('markets.id', 'markets.name', 'markets.city')
            ->orderByDesc('total_revenue')
            ->get();

        // Top Active Farmers
        $topFarmers = DB::table('orders')
            ->join('users', 'orders.farmer_id', '=', 'users.id')
            ->join('farmer_profiles', 'users.id', '=', 'farmer_profiles.user_id')
            ->whereBetween('orders.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('orders.order_status', '!=', 'cancelled')
            ->select('users.name as farmer_name', 'farmer_profiles.stall_name', DB::raw('COUNT(orders.id) as orders_count'), DB::raw('SUM(orders.total_amount) as revenue'))
            ->groupBy('users.id', 'users.name', 'farmer_profiles.stall_name')
            ->orderByDesc('revenue')
            ->take(8)
            ->get();

        $totalPeriodOrders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count();
        $totalPeriodRevenue = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('order_status', '!=', 'cancelled')
            ->sum('total_amount');

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'ordersByStatus',
            'revenueByMarket',
            'topFarmers',
            'totalPeriodOrders',
            'totalPeriodRevenue'
        ));
    }
}
