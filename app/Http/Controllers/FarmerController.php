<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FarmerProfile;
use App\Models\Market;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function index(Request $request)
    {
        $marketId = $request->query('market_id');
        $search = $request->query('search');

        $query = FarmerProfile::where('status', 'approved')
            ->with(['user', 'market', 'products' => function ($q) {
                $q->where('is_available', true);
            }]);

        if ($marketId) {
            $query->where('market_id', $marketId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('stall_name', 'LIKE', "%{$search}%")
                  ->orWhere('bio', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $farmers = $query->paginate(9);
        $markets = Market::where('status', 'active')->get();

        return view('farmers.index', compact('farmers', 'markets', 'marketId', 'search'));
    }

    public function show($id)
    {
        $farmerProfile = FarmerProfile::where('status', 'approved')
            ->with(['user', 'market', 'reviews.customer'])
            ->findOrFail($id);

        $products = $farmerProfile->products()
            ->where('is_available', true)
            ->with('category')
            ->get();

        $categories = Category::whereHas('products', function ($q) use ($farmerProfile) {
            $q->where('farmer_id', $farmerProfile->user_id);
        })->get();

        return view('farmers.show', compact('farmerProfile', 'products', 'categories'));
    }
}
