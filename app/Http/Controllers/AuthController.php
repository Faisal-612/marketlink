<?php

namespace App\Http\Controllers;

use App\Models\FarmerProfile;
use App\Models\Market;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->status === 'suspended') {
                Auth::logout();
                return back()->with('error', 'Your account is suspended. Please contact admin.');
            }

            return $this->redirectBasedOnRole($user)->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister(Request $request)
    {
        $role = $request->query('role', 'customer');
        $markets = Market::where('status', 'active')->get();
        return view('auth.register', compact('role', 'markets'));
    }

    public function register(Request $request)
    {
        $role = $request->input('role', 'customer');

        // Auto-extract name, email, phone if passed with role prefix
        if (!$request->filled('name')) {
            $request->merge([
                'name' => $role === 'farmer' ? $request->input('farmer_name') : $request->input('customer_name')
            ]);
        }
        if (!$request->filled('email')) {
            $request->merge([
                'email' => $role === 'farmer' ? $request->input('farmer_email') : $request->input('customer_email')
            ]);
        }
        if (!$request->filled('phone')) {
            $request->merge([
                'phone' => $role === 'farmer' ? $request->input('farmer_phone') : $request->input('customer_phone')
            ]);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:30',
            'address' => 'nullable|string',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:customer,farmer',
        ];

        if ($role === 'farmer') {
            $rules['stall_name'] = 'required|string|max:255';
            $rules['market_id'] = 'nullable|exists:markets,id';
            $rules['bio'] = 'nullable|string';
            $rules['operating_days'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? 'Karachi, Pakistan',
            'password' => Hash::make($validated['password']),
            'role' => $role,
            'status' => $role === 'farmer' ? 'pending' : 'active', // Farmers require admin approval
        ]);

        if ($role === 'farmer') {
            FarmerProfile::create([
                'user_id' => $user->id,
                'market_id' => $request->input('market_id'),
                'stall_name' => $validated['stall_name'],
                'bio' => $request->input('bio'),
                'operating_days' => $request->input('operating_days', 'Saturday, Sunday'),
                'pickup_time_start' => '08:00',
                'pickup_time_end' => '14:00',
                'order_cutoff_hours' => 3,
                'status' => 'pending',
            ]);

            Auth::login($user);
            return redirect()->route('farmer.dashboard')->with('info', 'Registration submitted! Your stall is currently pending Admin verification before listings become public.');
        }

        Auth::login($user);
        return redirect()->route('customer.orders')->with('success', 'Registration successful! Welcome to MarketLink.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been successfully logged out.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'address' => 'required|string',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    private function redirectBasedOnRole(User $user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'farmer' => redirect()->route('farmer.dashboard'),
            default => redirect()->route('customer.orders'),
        };
    }
}
