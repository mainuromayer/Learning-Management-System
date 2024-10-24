<?php

use App\Modules\Lesson\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;

Route::group( array( 'Module' =>'Lesson', 'middleware' => ['auth'] ), function () {
    Route::prefix( 'lesson' )->group( function () {
        Route::match( array( 'get', 'post' ), '/', array( LessonController::class, 'list' ) )->name( 'lesson.list' );
        Route::get( 'create', array( LessonController::class, 'create' ) )->name( 'lesson.create' );
        Route::post( 'store', array( LessonController::class, 'store' ) )->name( 'lesson.store' );
        Route::get( 'edit/{id}', array( LessonController::class, 'edit' ) )->name( 'lesson.edit' );
    } );
} );
