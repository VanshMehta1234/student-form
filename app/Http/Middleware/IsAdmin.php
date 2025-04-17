<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        // Check if user is authenticated as educator and has admin role
        if (Auth::guard('educator')->check() && Auth::guard('educator')->user()->isAdmin()) {
            return $next($request);
        }
        
        return redirect()->route('educator.dashboard')
            ->with('error', 'You do not have admin privileges to access this area.');
    }
} 