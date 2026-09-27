<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = User::where('role', 'customer')->withCount('customerOrders');

        if ($status) {
            $query->where('status', $status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('email', 'LIKE', '%' . $request->search . '%');
            });
        }

        $customers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.customers.index', compact('customers', 'status'));
    }

    public function toggleStatus($id)
    {
        $user = User::where('role', 'customer')->findOrFail($id);
        $user->status = $user->status === 'active' ? 'suspended' : 'active';
        $user->save();

        $action = $user->status === 'active' ? 'activated' : 'suspended';
        return back()->with('success', "Customer {$user->name} has been {$action}.");
    }
}
