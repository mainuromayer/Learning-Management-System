<?php

use App\Modules\Lesson\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;

Route::group(['Module' => 'Lesson', 'middleware' => ['auth']], function () {
    Route::prefix('lesson')->group(function () {
        Route::match(['get', 'post'], '/', [LessonController::class, 'list'])->name('lesson.list');
        Route::get('create', [LessonController::class, 'create'])->name('lesson.create');
        Route::post('store', [LessonController::class, 'store'])->name('lesson.store');
        Route::get('edit/{id}', [LessonController::class, 'edit'])->name('lesson.edit');
    });
});

