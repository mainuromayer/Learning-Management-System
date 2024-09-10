<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Student\Http\Controllers\StudentController;


Route::group(array('Module'=>'Student','middleware' => ['auth']), function () {
    Route::prefix('student')->group(function () {
    Route::match(['get', 'post'], '/', [StudentController::class, 'list'])->name('student.list');
     Route::get('create', [StudentController::class, 'create'])->name('student.create');
     Route::post('store', [StudentController::class, 'store'])->name('student.store'); 
     Route::get('edit/{id}', [StudentController::class, 'edit'])->name('student.edit'); 

    });
});