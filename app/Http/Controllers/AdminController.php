<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function showRegistrationForm()
    {
        return view('admins.register');
    }

    public function register(Request $request)
    {
        try {
            Log::info('Admin registration attempt', $request->all());
            
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admins',
                'role' => 'nullable|string|max:50',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role ?? 'admin',
                'password' => Hash::make($request->password),
            ]);

            Auth::guard('admin')->login($admin);

            Log::info('Admin registration successful', ['id' => $admin->id]);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Registration successful! Welcome to the admin panel.');
        } catch (\Exception $e) {
            Log::error('Admin registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withInput()
                ->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }

    public function showLoginForm()
    {
        return view('admins.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'You have logged in successfully!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login.form')
            ->with('success', 'You have been logged out successfully!');
    }

    public function dashboard()
    {
        return view('admins.dashboard');
    }
} 