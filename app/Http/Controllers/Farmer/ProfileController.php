<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\FarmerProfile;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $farmer = Auth::user();
        $profile = FarmerProfile::firstOrCreate(
            ['user_id' => $farmer->id],
            ['stall_name' => $farmer->name . ' Stall']
        );
        $markets = Market::where('status', 'active')->get();

        return view('farmer.profile.edit', compact('farmer', 'profile', 'markets'));
    }

    public function update(Request $request)
    {
        $farmer = Auth::user();
        $profile = $farmer->farmerProfile;

        $validated = $request->validate([
            'stall_name' => 'required|string|max:255',
            'market_id' => 'nullable|exists:markets,id',
            'stall_number' => 'nullable|string|max:50',
            'bio' => 'nullable|string',
            'operating_days' => 'required|string',
            'pickup_time_start' => 'required|string',
            'pickup_time_end' => 'required|string',
            'order_cutoff_hours' => 'required|integer|min:1|max:24',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'banner_image' => 'nullable|url|max:500',
        ]);

        $profile->update($validated);

        return back()->with('success', 'Stall profile and pickup schedule updated successfully!');
    }
}
