<?php

namespace App\Modules\Dashboard\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InstructorDashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('instructor');
    }

    public function index()
    {
        return view('Dashboard::instructor.dashboard');
    }

    // public function manageUsers()
    // {
    //     // Logic to manage users
    //     return view('admin.users');
    // }

    // public function settings()
    // {
    //     // Admin settings page
    //     return view('admin.settings');
    // }
}
