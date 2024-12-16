<?php

use App\Modules\Quiz\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::group(['Module'=>'Quiz', 'middleware'=>['auth']], function (){
    Route::prefix( 'quiz' )->group( function () {
        Route::match( array( 'get', 'post' ), '/', array( QuizController::class, 'list' ) )->name( 'quiz.list' );
        Route::get( 'create', array( QuizController::class, 'create' ) )->name( 'quiz.create' );
        Route::post( 'store', array( QuizController::class, 'store' ) )->name( 'quiz.store' );
        Route::get( 'edit/{id}', array( QuizController::class, 'edit' ) )->name( 'quiz.edit' );
    } );
} );
