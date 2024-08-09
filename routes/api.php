<?php

use App\Http\Controllers\Dashboard\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'admin',
        'middleware' => ['role:admin'],
        'as' => 'admin.'], function() {
    //Route::get('/admin', [AdminController::class, 'index']);
    Route::get('settings/{setting}', [SettingController::class, 'show']);
    Route::put('settings/{setting}/update', [SettingController::class, 'update']);
});
