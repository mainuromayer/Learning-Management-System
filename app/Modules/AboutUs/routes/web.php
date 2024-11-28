<?php

use App\Modules\AboutUs\Http\Controllers\AboutUsController;
use Illuminate\Support\Facades\Route;

Route::group(['Module' => 'AboutUs', 'middleware' => ['auth']], function () {
    Route::prefix('about_us')->group(function () {
        // GET method for displaying the form (create or edit)
        Route::get('/', [AboutUsController::class, 'index'])->name('about_us.index');
        
        // POST method for submitting the form (storing or updating data)
        Route::post('/', [AboutUsController::class, 'store'])->name('about_us.store');

        Route::post('/remove_image', [AboutUsController::class, 'removeImage'])->name('about_us.remove_image');
    });
});

