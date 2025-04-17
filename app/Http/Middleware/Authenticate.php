<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if ($request->is('student/*')) {
                return route('student.login.form');
            }
            
            if ($request->is('educator/*')) {
                return route('educator.login.form');
            }
            
            return route('login');
        }
    }
} 