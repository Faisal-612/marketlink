<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $farmerId = Auth::id();
        $query = Product::where('farmer_id', $farmerId)->with('category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('farmer.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('farmer.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'unit' => 'required|string|in:kg,gram,bunch,piece,dozen,box,basket,jar',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|url|max:500',
            'is_weekly_template' => 'nullable|boolean',
        ]);

        Product::create([
            'farmer_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(5),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'unit' => $validated['unit'],
            'stock_quantity' => $validated['stock_quantity'],
            'is_available' => true,
            'is_sold_out' => $validated['stock_quantity'] == 0,
            'is_weekly_template' => $request->boolean('is_weekly_template'),
            'image' => $validated['image'] ?: 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=500&auto=format&fit=crop&q=60',
        ]);

        return redirect()->route('farmer.products.index')->with('success', 'Product listed successfully!');
    }

    public function edit($id)
    {
        $product = Product::where('farmer_id', Auth::id())->findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('farmer.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('farmer_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'unit' => 'required|string|in:kg,gram,bunch,piece,dozen,box,basket,jar',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|url|max:500',
            'is_available' => 'nullable|boolean',
            'is_weekly_template' => 'nullable|boolean',
        ]);

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'unit' => $validated['unit'],
            'stock_quantity' => $validated['stock_quantity'],
            'is_available' => $request->boolean('is_available'),
            'is_sold_out' => $validated['stock_quantity'] == 0,
            'is_weekly_template' => $request->boolean('is_weekly_template'),
            'image' => $validated['image'] ?: $product->image,
        ]);

        return redirect()->route('farmer.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::where('farmer_id', Auth::id())->findOrFail($id);
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }

    public function toggleSoldOut($id)
    {
        $product = Product::where('farmer_id', Auth::id())->findOrFail($id);
        $product->is_sold_out = !$product->is_sold_out;
        $product->is_available = !$product->is_sold_out;
        $product->save();

        $msg = $product->is_sold_out ? 'Item marked as Sold Out' : 'Item marked as Available';
        return back()->with('success', $msg);
    }

    public function applyWeeklyTemplate()
    {
        $products = Product::where('farmer_id', Auth::id())
            ->where('is_weekly_template', true)
            ->get();

        foreach ($products as $product) {
            $product->is_available = true;
            $product->is_sold_out = false;
            if ($product->stock_quantity == 0) {
                $product->stock_quantity = 25; // Default replenishment stock
            }
            $product->save();
        }

        return back()->with('success', 'Weekly stock template applied! All template items refreshed for upcoming market.');
    }
}
