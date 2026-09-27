<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $farmerId = Auth::id();
        $reviews = Review::where('farmer_id', $farmerId)
            ->with(['customer', 'product', 'order'])
            ->latest()
            ->paginate(10);

        $totalReviews = Review::where('farmer_id', $farmerId)->count();
        $avgRating = round(Review::where('farmer_id', $farmerId)->avg('rating') ?: 0, 1);
        $pendingReplies = Review::where('farmer_id', $farmerId)->whereNull('farmer_reply')->count();
        $fiveStarCount = Review::where('farmer_id', $farmerId)->where('rating', 5)->count();

        return view('farmer.reviews.index', compact('reviews', 'totalReviews', 'avgRating', 'pendingReplies', 'fiveStarCount'));
    }

    public function reply(Request $request, $id)
    {
        $review = Review::where('farmer_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'farmer_reply' => 'required|string|max:1000',
        ]);

        $review->farmer_reply = $validated['farmer_reply'];
        $review->replied_at = now();
        $review->save();

        return back()->with('success', 'Response posted to customer review.');
    }
}
