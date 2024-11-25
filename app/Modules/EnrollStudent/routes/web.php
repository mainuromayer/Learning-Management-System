<?php

use App\Modules\EnrollStudent\Http\Controllers\EnrollStudentController;
use Illuminate\Support\Facades\Route;

Route::group(['Module' => 'EnrollStudent', 'middleware' => ['auth']], function () {
    Route::prefix('enroll_student')->group(function () {
        Route::match(['get', 'post'], '/', [EnrollStudentController::class, 'list'])->name('enroll_student.list');
        Route::get('create', [EnrollStudentController::class, 'create'])->name('enroll_student.create');
        Route::post('store', [EnrollStudentController::class, 'store'])->name('enroll_student.store');
        Route::get('edit/{id}', [EnrollStudentController::class, 'edit'])->name('enroll_student.edit');
    });
});


