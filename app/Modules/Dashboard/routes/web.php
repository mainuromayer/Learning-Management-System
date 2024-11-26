<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Dashboard\Http\Controllers\DashboardController;
use App\Modules\Dashboard\Http\Controllers\StudentDashboardController;


// Admin routes
Route::group(['middleware' => ['web', 'auth', 'admin']], function () {
    // Admin dashboard route
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Any other routes you want to restrict to admin only
    Route::get('/admin/users', [DashboardController::class, 'manageUsers'])->name('admin.users');
    Route::get('/admin/settings', [DashboardController::class, 'settings'])->name('admin.settings');
});

// Student routes
Route::group(['middleware' => ['auth', 'student']], function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    // Other student routes...
});