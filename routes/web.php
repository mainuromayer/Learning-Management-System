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
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login-check', [LoginController::class, 'logincheck'])->name('login.check');
});


Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/instructor_page', [FrontendController::class, 'instructorPage'])->name('instructor_page');

Route::get('/instructor_details/{id}', [FrontendController::class, 'instructorDetails'])->name('instructor_details');
Route::get('/courses_page', [FrontendController::class, 'coursesPage'])->name('courses_page');


Route::get( 'logout', array( LoginController::class, 'logout' ) )->name( 'logout' );



Route::get( 'logs', array( \Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index' ) );
