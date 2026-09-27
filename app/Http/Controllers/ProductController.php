<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FarmerProfile;
use App\Models\Market;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category');
        $marketId = $request->query('market');
        $farmerId = $request->query('farmer');
        $search = $request->query('search');
        $sort = $request->query('sort', 'latest');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');

        $query = Product::where('is_available', true)
            ->whereHas('farmer', function ($q) {
                $q->where('status', 'active');
            })
            ->with(['farmer.farmerProfile.market', 'category']);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($farmerId) {
            $query->where('farmer_id', $farmerId);
        }

        if ($marketId) {
            $query->whereHas('farmer.farmerProfile', function ($q) use ($marketId) {
                $q->where('market_id', $marketId);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $markets = Market::where('status', 'active')->get();
        $farmers = FarmerProfile::where('status', 'approved')->with('user')->get();

        return view('products.index', compact(
            'products',
            'categories',
            'markets',
            'farmers',
            'categoryId',
            'marketId',
            'farmerId',
            'search',
            'sort',
            'minPrice',
            'maxPrice'
        ));
    }

    public function show($id)
    {
        $product = Product::where('is_available', true)
            ->with(['farmer.farmerProfile.market', 'category', 'reviews.customer'])
            ->findOrFail($id);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_available', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
