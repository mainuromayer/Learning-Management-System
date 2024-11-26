<?php

namespace App\Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{

    public function __construct()
    {
        // You can also apply the 'admin' middleware here if needed
        $this->middleware('admin');
    }

    public function index()
    {
        return view('Dashboard::dashboard');
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
