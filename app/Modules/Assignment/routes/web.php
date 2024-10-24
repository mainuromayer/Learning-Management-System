<?php

use App\Modules\Assignment\Http\Controllers\AssignmentController;
use Illuminate\Support\Facades\Route;

Route::group( array( 'Module' =>'Assignment', 'middleware' => ['auth'] ), function () {
    Route::prefix( 'assignment' )->group( function () {
        Route::match( array( 'get', 'post' ), '/', array( AssignmentController::class, 'list' ) )->name( 'assignment.list' );
        Route::get( 'create', array( AssignmentController::class, 'create' ) )->name( 'assignment.create' );
        Route::post( 'store', array( AssignmentController::class, 'store' ) )->name( 'assignment.store' );
        Route::get( 'edit/{id}', array( AssignmentController::class, 'edit' ) )->name( 'assignment.edit' );
    } );
} );
