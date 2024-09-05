<?php
use App\Modules\User\Http\Controllers\UserController;
use App\Modules\User\Http\Controllers\UserProfileController;
use App\Modules\User\Http\Controllers\AuthPasswordController;
use Illuminate\Support\Facades\Route;

Route::group( array( 'Module' => 'User','middleware'=>['auth'] ), function () {
    Route::prefix( 'user' )->group( function () {
        Route::match( array( 'get', 'post' ), '/', array( UserController::class, 'list' ) )->name( 'user.list' );
        Route::get( 'create', array( UserController::class, 'create' ) )->name( 'user.create' );
        Route::post( 'store', array( UserController::class, 'store' ) )->name( 'user.store' );
        Route::get( 'edit/{id}', array( UserController::class, 'edit' ) )->name( 'user.edit' );
    } );
    Route::get( 'profile', array( UserProfileController::class, 'profile' ) )->name( 'profile.view' );
    Route::post( 'profile/update', array( UserProfileController::class, 'update' ) )->name( 'profile.update' );
    Route::get( 'reset_password', array( AuthPasswordController::class, 'reset_password' ) )->name( 'reset_password.view' );
    Route::post( 'reset_password/update', array( AuthPasswordController::class, 'update_password' ) )->name( 'reset_password.update' );
} );

