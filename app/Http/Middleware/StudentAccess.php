<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user has the 'student' role and user_type is 'student'
        if ($user->user_type !== 'student' || !$user->role || $user->role->slug !== 'student') {
            // Redirect to a different page if not a student
            return redirect()->route('home')->with('error', 'You do not have access to this page');
        }

        // Proceed to the requested route if both conditions are met
        return $next($request);
    }
}

