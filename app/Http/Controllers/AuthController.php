<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\FarmerProfile;
use App\Models\Market;

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

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account has been deactivated or suspended. Please contact admin.']);
            }

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors(['email' => 'Invalid email or password entered.'])->withInput();
    }



    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        $markets = Market::where('is_active', true)->get();
        return view('auth.register', compact('markets'));
    }

    public function register(Request $request)
    {
        $role = $request->input('role', 'customer');

        $rules = [
            'name' => 'required|string|max:150',
            'email' => 'required|string|email|max:191|unique:users',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:customer,farmer',
        ];

        if ($role === 'farmer') {
            $rules['stall_name'] = 'required|string|max:150';
            $rules['contact_person'] = 'required|string|max:100';
            $rules['market_id'] = 'nullable|exists:markets,id';
            $rules['operating_days'] = 'required|string|max:100';
            $rules['pickup_windows'] = 'required|string|max:300';
            $rules['bio'] = 'nullable|string|max:1000';
        }

        $validated = $request->validate($rules);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'role' => $role,
            'status' => 'active',
            'password' => Hash::make($validated['password']),
        ]);

        if ($role === 'farmer') {
            FarmerProfile::create([
                'user_id' => $user->id,
                'stall_name' => $validated['stall_name'],
                'contact_person' => $validated['contact_person'],
                'contact_number' => $validated['phone'],
                'address' => $validated['address'],
                'market_id' => $validated['market_id'] ?? null,
                'operating_days' => $validated['operating_days'],
                'pickup_windows' => $validated['pickup_windows'],
                'bio' => $validated['bio'] ?? null,
                'is_approved' => true,
            ]);
        }

        return redirect()->route('login')->with('success', 'Registration successful! Please sign in with your email and password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }

    protected function redirectBasedOnRole(User $user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'farmer' => redirect()->route('farmer.dashboard'),
            default => redirect()->route('customer.dashboard'),
        };
    }
}
