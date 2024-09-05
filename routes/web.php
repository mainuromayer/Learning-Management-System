<?php

use App\Http\Controllers\Auth\LoginController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::get('/', function () {
        return redirect()->route('login');
    })->name('home');
    Route::post('login-check', [LoginController::class, 'logincheck'])->name('login.check');
});


Route::get( 'logout', array( LoginController::class, 'logout' ) )->name( 'logout' );



Route::get( 'logs', array( \Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index' ) );
