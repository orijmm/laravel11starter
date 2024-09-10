<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Utilities\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Nnjeim\World\World;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/sanctum/token', TokenController::class);

Route::middleware(['auth:sanctum', 'apply_locale'])->group(function () {

    /**
     * Auth related
     */
    Route::get('/users/auth', AuthController::class);

    /**
     * Users
     */
    Route::put('/users/{user}/avatar', [UserController::class, 'updateAvatar']);
    Route::resource('users', UserController::class);

    /**
     * Roles
     */
    Route::get('/roles/search', [RoleController::class, 'search'])->middleware('throttle:400,1');

    Route::resource('settingad', SettingController::class);
});

Route::get('testing', function () {
    $countries = World::countries();

    return response()->json(['data' => $countries], 200);
});

## Ubicaciones
Route::get('languages', function (Request $request) {
    $languages = [];
    $action = World::languages([
        'search' => $request->search, // Aquí pasas el término de búsqueda
    ]);
    if ($action->success) {
        //Se trasnforma a id/label
        $languages = Data::formatCollectionForSelect($action->data,'code', 'name_native');
    }
    return response()->json(['data' => $languages], 200);
});
Route::get('timezones', function (Request $request) {
    $timezones = [];
    $action = World::timezones([
        'search' => $request->search, // Aquí pasas el término de búsqueda
    ]);
    if ($action->success) {
        //Se trasnforma a id/label
        $timezones = Data::formatCollectionForSelect($action->data);
    }
    return response()->json(['data' => $timezones], 200);
});
Route::get('currencies', function (Request $request) {
    $currencies = [];
    $action = World::currencies([
        'search' => $request->search, // Aquí pasas el término de búsqueda
    ]);
    if ($action->success) {
        //Se trasnforma a id/label
        $currencies = Data::formatCollectionForSelect($action->data);
    }
    return response()->json(['data' => $currencies], 200);
});
Route::get('countries', function (Request $request) {
    $countries = [];
    $action = World::countries([
        'search' => $request->search, // Aquí pasas el término de búsqueda
    ]);
    if ($action->success) {
        //Se trasnforma a id/label
        $countries = Data::formatCollectionForSelect($action->data);
    }
    return response()->json(['data' => $countries], 200);
});
Route::get('states', function (Request $request) {
    $states = [];
    $action = World::states([
        'search' => $request->search, // Aquí pasas el término de búsqueda
    ]);
    if ($action->success) {
        //Se trasnforma a id/label
        $states = Data::formatCollectionForSelect($action->data);
    }
    return response()->json(['data' => $states], 200);
});
Route::get('cities', function (Request $request) {
    $cities = [];
    $action = World::cities([
        'search' => $request->search, // Aquí pasas el término de búsqueda
    ]);
    if ($action->success) {
        //Se trasnforma a id/label
        $cities = Data::formatCollectionForSelect($action->data);
    }
    return response()->json(['data' => $cities], 200);
});
