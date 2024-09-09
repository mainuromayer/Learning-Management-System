<?php
use App\Modules\Instructor\Http\Controllers\InstructorController;
use Illuminate\Support\Facades\Route;

Route::group( array( 'Module' =>'Instructor', 'middleware' => ['auth'] ), function () {
    Route::prefix( 'instructor' )->group( function () {
        Route::match( array( 'get', 'post' ), '/', array( InstructorController::class, 'list' ) )->name( 'instructor.list' );
        Route::get( 'create', array( InstructorController::class, 'create' ) )->name( 'instructor.create' );
        Route::post( 'store', array( InstructorController::class, 'store' ) )->name( 'instructor.store' );
        Route::get( 'edit/{id}', array( InstructorController::class, 'edit' ) )->name( 'instructor.edit' );
    } );
} );
