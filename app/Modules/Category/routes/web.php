<?php

use App\Modules\Category\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group( array( 'Module' =>'Category', 'middleware' => ['auth'] ), function () {
    Route::prefix( 'category' )->group( function () {
        Route::match( array( 'get', 'post' ), '/', array( CategoryController::class, 'list' ) )->name( 'category.list' );
        Route::get( 'create', array( CategoryController::class, 'create' ) )->name( 'category.create' );
        Route::post( 'store', array( CategoryController::class, 'store' ) )->name( 'category.store' );
        Route::get( 'edit/{id}', array( CategoryController::class, 'edit' ) )->name( 'category.edit' );
    } );
} );
