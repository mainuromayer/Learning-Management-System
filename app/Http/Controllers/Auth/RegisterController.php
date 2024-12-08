<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modules\UserPermission\Models\Role;
use App\Modules\User\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle the registration logic
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required||confirmed',
            'role' => 'required|in:student,instructor',
        ]);

        try {
            // Create a new user
            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            
            // Assign the role based on selection
            $role = Role::where('slug', $validated['role'])->first();
            $user->role_id = $role->id;

            if ($validated['role'] === 'student') {
                $user->user_type = 'student';
            } elseif ($validated['role'] === 'instructor') {
                $user->user_type = 'instructor';
            }
            
            Log::info($user);
            $user->save();

            // Log the user in after registration
            Auth::login($user);

            // Redirect user to the appropriate dashboard based on role
            if ($user->role && $user->role->slug === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role && $user->role->slug === 'student') {
                return redirect()->route('student.dashboard');
            } elseif ($user->role && $user->role->slug === 'instructor') {
                return redirect()->route('instructor.dashboard');
            } else {
                return redirect()->route('home');
            }
        } catch (Exception $e) {
            Log::error("Error occurred in RegisterController@register: {$e->getMessage()}");
            return back()->with('error', 'Something went wrong during registration.');
        }
    }
}