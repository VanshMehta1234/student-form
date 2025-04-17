<?php

namespace App\Http\Controllers;

use App\Models\Educator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducatorAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:educator')->only(['showLoginForm', 'login']);
        $this->middleware('auth:educator')->only(['dashboard', 'logout']);
        
        // Prevent access when logged in as student
        $this->middleware(function ($request, $next) {
            if (Auth::guard('student')->check()) {
                return redirect()->route('student.dashboard')
                    ->with('error', 'Please logout as student first to access educator features.');
            }
            return $next($request);
        })->only(['showLoginForm', 'login']);
    }

    public function showLoginForm()
    {
        return view('educators.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::guard('educator')->attempt($credentials, $request->filled('remember'))) {
            // Clear any session data that might interfere with login
            $request->session()->regenerate();
            
            return redirect()->intended(route('educator.dashboard'))
                ->with('success', 'You have been successfully logged in.');
        }

        return back()->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('educator')->logout();
        $request->session()->invalidate();
        return redirect()->route('educator.login.form');
    }

    public function dashboard()
    {
        return view('educators.dashboard');
    }
} 