<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->with(['product.farmer.farmerProfile', 'farmer.farmerProfile.market'])
            ->get();

        return view('customer.favorites.index', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:product,farmer',
            'target_id' => 'required|integer',
        ]);

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('type', $validated['type'])
            ->where('target_id', $validated['target_id'])
            ->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'removed';
            $message = 'Removed from favorites.';
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'type' => $validated['type'],
                'target_id' => $validated['target_id'],
            ]);
            $status = 'added';
            $message = 'Saved to favorites!';
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => $status,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}
