<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class CheckStudentRelationships
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
        // Check if user is a student and authenticated
        if (Auth::guard('student')->check()) {
            $courseTableExists = Schema::hasTable('student_courses');
            $quizTableExists = Schema::hasTable('student_quizzes');
            
            // Store the availability in session for later use in views and controllers
            session(['student_courses_available' => $courseTableExists]);
            session(['student_quizzes_available' => $quizTableExists]);
            
            // If specific routes require certain tables, redirect appropriately
            if (!$courseTableExists && $request->routeIs('student.courses.*')) {
                return redirect()->route('student.dashboard')
                    ->with('error', 'Course enrollment is not available at the moment.');
            }
            
            if (!$quizTableExists && $request->routeIs('student.quizzes.*')) {
                return redirect()->route('student.dashboard')
                    ->with('error', 'Quiz functionality is not available at the moment.');
            }
        }
        
        return $next($request);
    }
} 