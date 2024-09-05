<?php
use App\Modules\UserPermission\Http\Controllers\UserPermissionController;
use Illuminate\Support\Facades\Route;


Route::group(array('Module'=>'UserPermission', 'middleware' => ['auth']), function () {
    Route::prefix('settings/user-permission')->group(function () {
        Route::get('/', [UserPermissionController::class, 'index'])->name('user-permission'); 
        Route::post('load_module_permission', [UserPermissionController::class, 'modulePermission'])->name('module_permission');
        Route::post('store', [UserPermissionController::class, 'store'])->name('user-permission.store'); 
    });
});
