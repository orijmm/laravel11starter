<?php

use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
//Route::middleware(['auth:sanctum'])->group(function () {
    ####USERS   
    Route::apiResource('users', UserController::class);
    Route::get('users/list/select', [UserController::class, 'listSelect'])->name('users.select');
    ####ROLES
    Route::apiResource('roles', RoleController::class);
//});



Route::group([
    'prefix' => 'admin',
    'middleware' => ['role:admin'],
    'as' => 'admin.'
], function () {
    //Route::get('/admin', [AdminController::class, 'index']);
    Route::get('settings/{setting}', [SettingController::class, 'show']);
    Route::put('settings/{setting}/update', [SettingController::class, 'update']);
});
