<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FrontendController;
use App\Modules\Dashboard\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */


Route::middleware('guest')->group(function () {
    Route::get('/', [FrontendController::class, 'frontend'])->name('home');
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login-check', [LoginController::class, 'logincheck'])->name('login.check');
});


Route::get( 'logout', array( LoginController::class, 'logout' ) )->name( 'logout' );



Route::get( 'logs', array( \Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index' ) );
