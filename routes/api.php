<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pages\ComponentController;
use App\Http\Controllers\Pages\ComponentTypeController;
use App\Http\Controllers\Pages\MenuController;
use App\Http\Controllers\Pages\PagesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Pages\TemplateController;
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
    Route::get('/roles/list', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/search', [RoleController::class, 'search'])->middleware('throttle:400,1')->name('roles.search');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    //Abilities (Permissions)
    Route::get('/roles/allbilities', [RoleController::class, 'allAbilities'])->name('roles.ability.all');
    Route::post('/roles/{role}/abilitytorole', [RoleController::class, 'assignAbilityToRole'])->name('roles.ability.role');
    Route::get('/roles/{ability}/editability', [RoleController::class, 'editAbility'])->name('roles.ability.edit');
    Route::post('/roles/add/ability', [RoleController::class, 'createAbility'])->name('roles.create.ability');
    Route::put('/roles/{ability}/editability', [RoleController::class, 'updateAbility'])->name('roles.ability.update');
    Route::delete('/roles/{ability}/deleteability', [RoleController::class, 'deleteAbility'])->name('roles.ability.delete');
    Route::get('/roles/abilities/select', [RoleController::class, 'abilitiesSelect'])->name('roles.ability.select');

    /**
     * Settings Admin
     */
    Route::resource('settingad', SettingController::class)->except('show');
    Route::put('/settingad/{setting}/logo', [SettingController::class, 'updateLogo']);

    /**
     * Pages and Templates
     */
    Route::prefix('pages')->group(function () {
        Route::apiResource('templates', TemplateController::class);
        #Menu
        Route::apiResource('menus', MenuController::class);
        #Menu Items
        Route::get('menus/{menu}/showitem/{menuitem}', [MenuController::class, 'showItem'])->name('menus.showitem');
        Route::post('menus/{menu}/storeitem', [MenuController::class, 'storeItem'])->name('menu.store.item');
        Route::patch('menus/{menu}/updateitem/{menuitem}', [MenuController::class, 'updateItem'])->name('menu.update.item');
        Route::delete('menus/{menuitem}/deleteitem', [MenuController::class, 'deleteItem'])->name('menu.delete.item');
        #components and type of components
        Route::apiResource('componenttype', ComponentTypeController::class);
        Route::apiResource('components', ComponentController::class);
        Route::get('component/type/filename', [ComponentTypeController::class, 'listFilename'])->name('get.typecomponents.filename');

        ##PAGES
        Route::apiResource('page', PagesController::class)->except('show');
        #sections
        Route::get('page/sections', [PagesController::class, 'listSection'])->name('page.list.sections');
        Route::post('page/{page}/storesection', [PagesController::class, 'storeSection'])->name('page.store.section');
        Route::get('page/{page}/section/{section}', [PagesController::class, 'showSection'])->name('page.show.section');
        Route::patch('page/updatesection/{section}', [PagesController::class, 'updateSection'])->name('page.update.section');
        Route::patch('page/checkhome/{page}', [PagesController::class, 'checkHomePage'])->name('page.check.home');
        Route::delete('page/{page}/deletesection/{section}', [PagesController::class, 'deleteSection'])->name('page.delete.section');
        Route::patch('page/updaterows/{section}', [PagesController::class, 'updateRows'])->name('page.section.updaterows');
        #Columns
        Route::get('page/column/{column}', [PagesController::class, 'getColumnData'])->name('pages.store.column.component');
        Route::patch('page/update/column/{column}', [PagesController::class, 'updateColumn'])->name('pages.update.column');
        #Components in columns
        Route::post('page/column/{column}/storecomponent', [PagesController::class, 'addComponentToColumn'])->name('page.store.column.component');
        Route::patch('page/savecontents/{column}', [PagesController::class, 'saveComponentContent'])->name('pages.save.component.content');
    });
});


### Website public routes ####
Route::get('menus/searchname', [MenuController::class, 'showByName'])->name('menus.search.name');
Route::get('page/{page}', [PagesController::class, 'show'])->name('page.show');
Route::get('settingad/{settingad}', [SettingController::class, 'show'])->name('settingad.show');
Route::get('getpage/{id?}', [PagesController::class, 'displayPageItems'])->name('display.getpage');

## Ubicaciones
Route::get('languages', function (Request $request) {
    $languages = [];
    $action = World::languages([
        'search' => $request->search, // Aquí pasas el término de búsqueda
    ]);
    if ($action->success) {
        //Se trasnforma a id/label
        $languages = Data::formatCollectionForSelect($action->data, 'code', 'name_native');
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

Route::get('testing', function () {
    //Testing route

    return response()->json(['data' => 'test'], 200);
});
