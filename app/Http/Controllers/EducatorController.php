<?php

namespace App\Http\Controllers;

use App\Models\Educator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EducatorController extends Controller
{
    public function __construct()
    {
        // Prevent access when logged in as student
        $this->middleware(function ($request, $next) {
            if (Auth::guard('student')->check()) {
                return redirect()->route('student.dashboard')
                    ->with('error', 'Please logout as student first to access educator features.');
            }
            return $next($request);
        })->only(['showRegistrationForm', 'register']);
        
        // Guest middleware for registration
        $this->middleware('guest:educator')->only(['showRegistrationForm', 'register']);
        
        // Admin middleware for admin functions
        $this->middleware(['auth:educator', 'admin'])->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
    }

    public function showRegistrationForm()
    {
        return view('educators.register');
    }

    public function register(Request $request)
    {
        try {
            Log::info('Educator registration attempt', $request->all());
            
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:educators',
                'qualification' => 'required|string|max:255',
                'bio' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'nullable|string|in:educator,admin',
            ]);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'qualification' => $request->qualification,
                'bio' => $request->bio,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'educator',
            ];

            $educator = Educator::create($data);

            Auth::guard('educator')->login($educator);

            Log::info('Educator registration successful', ['id' => $educator->id]);

            return redirect()->route('educator.dashboard')
                ->with('success', 'Registration successful! Welcome to the platform.');
        } catch (\Exception $e) {
            Log::error('Educator registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withInput()
                ->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }
    
    /**
     * Display a listing of all educators.
     * Admin only method.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $educators = Educator::latest()->paginate(10);
        return view('educators.admin.index', compact('educators'));
    }
    
    /**
     * Show the form for creating a new educator.
     * Admin only method.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('educators.admin.create');
    }
    
    /**
     * Store a newly created educator.
     * Admin only method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:educators',
            'qualification' => 'required|string|max:255',
            'bio' => 'required|string',
            'role' => 'required|string|in:educator,admin',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        Educator::create([
            'name' => $request->name,
            'email' => $request->email,
            'qualification' => $request->qualification,
            'bio' => $request->bio,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('educator.manage')
            ->with('success', 'Educator created successfully');
    }
    
    /**
     * Show the form for editing the specified educator.
     * Admin only method.
     *
     * @param  \App\Models\Educator  $educator
     * @return \Illuminate\Http\Response
     */
    public function edit(Educator $educator)
    {
        return view('educators.admin.edit', compact('educator'));
    }
    
    /**
     * Update the specified educator in storage.
     * Admin only method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Educator  $educator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Educator $educator)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:educators,email,' . $educator->id,
            'qualification' => 'required|string|max:255',
            'bio' => 'required|string',
            'role' => 'required|string|in:educator,admin',
        ]);
        
        $educator->update([
            'name' => $request->name,
            'email' => $request->email,
            'qualification' => $request->qualification,
            'bio' => $request->bio,
            'role' => $request->role,
        ]);
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            
            $educator->update([
                'password' => Hash::make($request->password),
            ]);
        }
        
        return redirect()->route('educator.manage')
            ->with('success', 'Educator updated successfully');
    }
    
    /**
     * Remove the specified educator from storage.
     * Admin only method.
     *
     * @param  \App\Models\Educator  $educator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Educator $educator)
    {
        // Don't allow deleting yourself
        if ($educator->id === Auth::guard('educator')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        $educator->delete();
        
        return redirect()->route('educator.manage')
            ->with('success', 'Educator deleted successfully');
    }
} 