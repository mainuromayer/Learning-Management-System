<?php
use Illuminate\Support\Facades\Route;

use App\Modules\Dashboard\Http\Controllers\AdminDashboardController;
use App\Modules\Dashboard\Http\Controllers\StudentDashboardController;
use App\Modules\Dashboard\Http\Controllers\InstructorDashboardController;


// Admin routes
Route::group(['middleware' => ['web', 'auth', 'admin']], function () {
    // Admin dashboard route
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Any other routes you want to restrict to admin only
    Route::get('/admin/users', [AdminDashboardController::class, 'manageUsers'])->name('admin.users');
    Route::get('/admin/settings', [AdminDashboardController::class, 'settings'])->name('admin.settings');
});


Route::group(['middleware' => ['auth', 'student']], function () {
    // Student Dashboard Route
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    
    // Routes for courses, lessons, quizzes, and assignments
    Route::get('student/course/{courseId}', [StudentDashboardController::class, 'showCourse'])->name('course.show');
    Route::get('student/lesson/{lessonId}', [StudentDashboardController::class, 'showLesson'])->name('lesson.view');
    Route::get('student/quiz/{quizId}', [StudentDashboardController::class, 'takeQuiz'])->name('quiz.take');
    Route::get('student/assignment/{assignmentId}', [StudentDashboardController::class, 'viewAssignment'])->name('assignment.view');
});





// Instructor routes
// Instructor Routes
Route::group(['middleware' => ['auth', 'instructor']], function () {
    Route::get('/instructor/dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');
    Route::get('/instructor/course/{courseId}', [InstructorDashboardController::class, 'showCourse'])->name('instructor.course.index');
});
