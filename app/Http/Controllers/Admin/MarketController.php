<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index()
    {
        $markets = Market::withCount('farmerProfiles')->latest()->get();
        return view('admin.markets.index', compact('markets'));
    }

    public function create()
    {
        return view('admin.markets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'operating_days' => 'required|string',
            'opening_time' => 'required|string',
            'closing_time' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|url',
        ]);

        Market::create($validated);
        return redirect()->route('admin.markets.index')->with('success', 'Farmers Market added successfully!');
    }

    public function edit($id)
    {
        $market = Market::findOrFail($id);
        return view('admin.markets.edit', compact('market'));
    }

    public function update(Request $request, $id)
    {
        $market = Market::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'operating_days' => 'required|string',
            'opening_time' => 'required|string',
            'closing_time' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        $market->update($validated);
        return redirect()->route('admin.markets.index')->with('success', 'Market updated successfully!');
    }

    public function destroy($id)
    {
        $market = Market::findOrFail($id);
        $market->delete();
        return back()->with('success', 'Market deleted successfully.');
    }
}
