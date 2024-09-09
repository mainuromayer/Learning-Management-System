<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Course\Http\Controllers\CourseController;


Route::group(array('Module'=>'Course'), function () {
    Route::prefix('course')->group(function () {
    Route::match(['get', 'post'], '/', [CourseController::class, 'list'])->name('course.list');
     Route::get('create', [CourseController::class, 'create'])->name('course.create');
     Route::post('store', [CourseController::class, 'store'])->name('course.store');
     Route::get('edit/{id}', [CourseController::class, 'edit'])->name('course.edit');

    });
});
