<?php

namespace App\Http\Controllers;

use App\Models\Market;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->query('city');
        $day = $request->query('day');

        $query = Market::where('status', 'active')
            ->with(['farmerProfiles' => function ($q) {
                $q->where('status', 'approved')->with('user');
            }]);

        if ($city) {
            $query->where('city', $city);
        }

        if ($day) {
            $query->where('operating_days', 'LIKE', "%{$day}%");
        }

        $markets = $query->get();
        $cities = Market::where('status', 'active')->distinct()->pluck('city');

        return view('markets.index', compact('markets', 'cities', 'city', 'day'));
    }

    public function show($id)
    {
        $market = Market::with(['farmerProfiles' => function ($q) {
            $q->where('status', 'approved')->with(['user', 'products' => function ($pq) {
                $pq->where('is_available', true)->take(4);
            }]);
        }])->findOrFail($id);

        return view('markets.show', compact('market'));
    }
}
