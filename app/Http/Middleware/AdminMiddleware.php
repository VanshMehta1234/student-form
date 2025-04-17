<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated as an educator
        if (!Auth::guard('educator')->check()) {
            return redirect()->route('educator.login.form');
        }

        // Check if the authenticated educator has admin role
        if (Auth::guard('educator')->user()->role !== 'admin') {
            return redirect()->route('educator.dashboard')
                ->with('error', 'You do not have permission to access this area.');
        }

        return $next($request);
    }
} 