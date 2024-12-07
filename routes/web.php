<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use App\Modules\Dashboard\Http\Controllers\DashboardController;

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
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register.store');
});


Route::get('/', [FrontendController::class, 'home'])->name('home');

Route::get('/instructor_page', [FrontendController::class, 'instructorPage'])->name('instructor_page');
Route::get('/instructor_details/{id}', [FrontendController::class, 'instructorDetails'])->name('instructor_details');

Route::get('/courses_page', [FrontendController::class, 'coursesPage'])->name('courses_page');
Route::get('/course_details/{id}', [FrontendController::class, 'courseDetails'])->name('course_details');
// Route for course enrollment
Route::get('/course_enroll/{id}', [FrontendController::class, 'enrollCourse'])->name('course_enroll');


Route::get('/about_page', [FrontendController::class, 'aboutUs'])->name('about_page');

Route::get('/category_page', [FrontendController::class, 'categoryPage'])->name('category_page');
Route::get('/category_details/{id}', [FrontendController::class, 'categoryDetails'])->name('category.details');



Route::get( 'logout', array( LoginController::class, 'logout' ) )->name( 'logout' );



Route::get( 'logs', array( \Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index' ) );
