<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Tenant;
use App\Enums\UserRole;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');



        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Verify tenant is assigned (critical for multi-tenant security)
            if (!$user->tenant_id) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => ['Tenant not assigned to this user.'],
                ]);
            }

            // Store tenant in session for global scope use (avoids recursion)
            $request->session()->put('tenant_id', $user->tenant_id);

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => [__('auth.failed')],
        ]);
    }

    /**
     * Show the registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     * Creates both Tenant and User for new restaurant
     */
    public function register(Request $request)
    {
        $request->validate([
            'restaurant_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            // Create new Tenant (Restaurant)
            $tenant = Tenant::create([
                'name' => $request->restaurant_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subscribtion_type' => 'basic',
                'subscribtion_created' => now(),
                'is_subscribe' => true,
            ]);

            // Create User assigned to Tenant with OWNER role
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => UserRole::OWNER->value,
                'tenant_id' => $tenant->id,
                'phone' => $request->phone,
                'is_active' => true,
            ]);

            // Automatically log in the new user and set tenant
            Auth::login($user);
            session(['tenant_id' => $user->tenant_id]);

            return redirect('/dashboard')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            return back()->withErrors(['registration' => 'An error occurred during registration: ' . $e->getMessage()]);
        }
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        session()->forget('tenant_id');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
