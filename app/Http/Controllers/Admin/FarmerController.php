<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FarmerProfile;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = FarmerProfile::with(['user', 'market'])->withCount('products');

        if ($status) {
            $query->where('status', $status);
        }

        $farmers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.farmers.index', compact('farmers', 'status'));
    }

    public function approve($id)
    {
        $profile = FarmerProfile::findOrFail($id);
        $profile->status = 'approved';
        $profile->save();

        $user = $profile->user;
        $user->status = 'active';
        $user->save();

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Stall Registration Approved',
            'message' => 'Congratulations! Your farm stall profile has been verified and approved by the administrator. You can now publish products.',
            'link' => route('farmer.products.index'),
        ]);

        return back()->with('success', "Farmer '{$profile->stall_name}' approved successfully!");
    }

    public function suspend($id)
    {
        $profile = FarmerProfile::findOrFail($id);
        $profile->status = 'suspended';
        $profile->save();

        $user = $profile->user;
        $user->status = 'suspended';
        $user->save();

        return back()->with('warning', "Farmer '{$profile->stall_name}' has been suspended.");
    }

    public function activate($id)
    {
        $profile = FarmerProfile::findOrFail($id);
        $profile->status = 'approved';
        $profile->save();

        $user = $profile->user;
        $user->status = 'active';
        $user->save();

        return back()->with('success', "Farmer '{$profile->stall_name}' has been reactivated.");
    }
}
