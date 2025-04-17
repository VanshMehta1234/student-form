<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:student')->except('logout', 'dashboard');
        
        // Prevent access when logged in as educator
        $this->middleware(function ($request, $next) {
            if (Auth::guard('educator')->check()) {
                return redirect()->route('educator.dashboard')
                    ->with('error', 'Please logout as educator first to access student features.');
            }
            return $next($request);
        })->only(['showLoginForm', 'login', 'showRegistrationForm', 'register']);
    }

    public function showLoginForm()
    {
        return view('students.login');
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

        if (Auth::guard('student')->attempt($credentials, $request->filled('remember'))) {
            // Clear any session data that might interfere with login
            $request->session()->regenerate();
            
            return redirect()->intended(route('student.dashboard'))
                ->with('success', 'You have been successfully logged in.');
        }

        return back()->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    public function showRegistrationForm()
    {
        return view('students.register');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'password' => 'required|string|min:8|confirmed',
            'dob' => 'required|date',
            'phone' => 'required|string|min:10',
            'course' => 'required|string|max:255'
        ]);

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'dob' => $request->dob,
            'phone' => $request->phone,
            'course' => $request->course
        ]);

        Auth::guard('student')->login($student);

        return redirect()->route('student.dashboard')
            ->with('success', 'Registration successful! Welcome to the platform.');
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        return redirect()->route('student.login.form');
    }

    public function dashboard()
    {
        return view('students.dashboard');
    }
} 