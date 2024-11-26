<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccess
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
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user has the 'admin' role
        if ($user->role && $user->role->slug !== 'admin') {
            // Redirect to a different page if the user is not an admin
            return redirect()->route('home')->with('error', 'You do not have access to this page');
        }

        // Proceed to the requested route if the user is an admin
        return $next($request);
    }
}

