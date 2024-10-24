<?php

use App\Modules\Section\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

Route::group(['Module'=>'Section', 'middleware'=>['auth']], function (){
    Route::prefix('section')->group(function (){
        Route::match(['get','post'], '/',[SectionController::class,'list'])->name('section.list');
        Route::get('create',[SectionController::class,'create'])->name('section.create');
        Route::post('store',[SectionController::class,'store'])->name('section.store');
        Route::get('edit/{id}',[SectionController::class,'edit'])->name('section.edit');
    });
});
