<?php
use App\Modules\Dashboard\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::group(array('Module'=>'Dashboard','middleware' => ['web', 'auth']), function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});