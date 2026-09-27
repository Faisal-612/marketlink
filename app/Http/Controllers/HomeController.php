<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Faq;
use App\Models\FarmerProfile;
use App\Models\Market;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $featuredProducts = Product::where('is_available', true)
            ->whereHas('farmer', function ($q) {
                $q->where('status', 'active');
            })
            ->with(['farmer.farmerProfile', 'category'])
            ->latest()
            ->take(8)
            ->get();

        $featuredMarkets = Market::where('status', 'active')
            ->withCount(['farmerProfiles' => function ($q) {
                $q->where('status', 'approved');
            }])
            ->take(4)
            ->get();

        $topFarmers = FarmerProfile::where('status', 'approved')
            ->with(['user', 'market'])
            ->take(4)
            ->get();

        $recentReviews = Review::where('status', 'published')
            ->with(['customer', 'product', 'farmer.farmerProfile'])
            ->latest()
            ->take(4)
            ->get();

        $announcements = Announcement::where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact(
            'categories',
            'featuredProducts',
            'featuredMarkets',
            'topFarmers',
            'recentReviews',
            'announcements'
        ));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        return back()->with('success', 'Thank you for reaching out! Your message has been received.');
    }

    public function sitemap()
    {
        $markets = Market::where('status', 'active')->get();
        $categories = Category::where('is_active', true)->get();
        $farmers = FarmerProfile::where('status', 'approved')->with('user')->get();

        return view('pages.sitemap', compact('markets', 'categories', 'farmers'));
    }

    public function chatbotQuery(Request $request)
    {
        $query = strtolower(trim($request->input('message', '')));

        if (empty($query)) {
            return response()->json([
                'response' => 'Hello! I am your MarketLink Harvest Assistant. How can I help you discover fresh produce or farmers markets today?'
            ]);
        }

        // 1. Check for product queries
        $products = Product::where('is_available', true)
            ->where(function ($q) use ($query) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$query}%"])
                  ->orWhereRaw('LOWER(description) LIKE ?', ["%{$query}%"]);
            })
            ->with('farmer.farmerProfile')
            ->take(3)
            ->get();

        if ($products->count() > 0) {
            $list = $products->map(function ($p) {
                $stall = $p->farmer->farmerProfile->stall_name ?? 'Local Stall';
                return "• <strong>{$p->name}</strong> (Rs. {$p->price}/{$p->unit}) by <em>{$stall}</em>";
            })->implode('<br>');

            return response()->json([
                'response' => "I found these available fresh items for '<strong>" . htmlspecialchars($query) . "</strong>':<br>" . $list . "<br><br><a href='" . route('products.index', ['search' => $query]) . "' class='btn btn-sm btn-success mt-1'>View Products</a>"
            ]);
        }

        // 2. Check for Market / Location queries
        if (str_contains($query, 'market') || str_contains($query, 'timing') || str_contains($query, 'where') || str_contains($query, 'location') || str_contains($query, 'karachi') || str_contains($query, 'lahore') || str_contains($query, 'islamabad')) {
            $markets = Market::where('status', 'active')->take(3)->get();
            $mList = $markets->map(function ($m) {
                return "• <strong>{$m->name}</strong> ({$m->city}) - {$m->operating_days} [{$m->opening_time} - {$m->closing_time}]";
            })->implode('<br>');

            return response()->json([
                'response' => "Here are our active weekend farmers markets:<br>" . $mList . "<br><br><a href='" . route('markets.index') . "' class='btn btn-sm btn-success mt-1'>Open Interactive Map</a>"
            ]);
        }

        // 3. Check for pre-order / payment / how it works
        if (str_contains($query, 'order') || str_contains($query, 'pay') || str_contains($query, 'pickup') || str_contains($query, 'cancel')) {
            return response()->json([
                'response' => "<strong>How Pre-Ordering Works:</strong><br>1. Browse fresh produce and add to cart.<br>2. Choose your preferred pickup market day and time slot.<br>3. Submit the pre-order with zero advance payment.<br>4. Pick up and pay directly at the farmer's stall at the market!"
            ]);
        }

        // 4. Check FAQs from database
        $faq = Faq::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->whereRaw('LOWER(question) LIKE ?', ["%{$query}%"])
                  ->orWhereRaw('LOWER(answer) LIKE ?', ["%{$query}%"]);
            })
            ->first();

        if ($faq) {
            return response()->json([
                'response' => "<strong>" . htmlspecialchars($faq->question) . "</strong><br>" . htmlspecialchars($faq->answer)
            ]);
        }

        // Default response
        return response()->json([
            'response' => "You can ask me about: 'Find apples or tomatoes', 'Market timings and locations', 'How to pre-order', or 'How farmers can register'."
        ]);
    }
}
