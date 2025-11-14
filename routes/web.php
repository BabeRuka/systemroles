<?php

declare(strict_types=1);

namespace BabeRuka\SystemRoles\Routes;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route; 
use BabeRuka\SystemRoles\Http\Controllers\SystemRoles\SystemRolesController;
use BabeRuka\SystemRoles\Http\Controllers\SystemRoles\SystemClassesController;
use BabeRuka\SystemRoles\Http\Controllers\SystemRoles\SystemRoutesController;
use BabeRuka\SystemRoles\Http\Controllers\SystemRoles\SystemMenusController;

Route::middleware(['web', 'auth'])->prefix('systemroles/admin')->group(function () {

        Route::get('/', [SystemRolesController::class, 'index'])->name('systemroles.admin.index');
        Route::get('/dashboard', [SystemRolesController::class, 'dashboard'])->name('systemroles.admin.dashboard');
        Route::prefix('roles')->group(function () {
        Route::get('/', [SystemRolesController::class, 'index'])->name('systemroles.admin.roles');
        Route::get('/index', [SystemRolesController::class, 'index'])->name('systemroles.admin.roles.index');
        Route::post('/store', [SystemRolesController::class, 'store'])->name('systemroles.admin.roles.store');
        Route::put('/update', [SystemRolesController::class, 'update'])->name('systemroles.admin.roles.update');
        Route::get('/manage', [SystemRolesController::class, 'manage'])->name('systemroles.admin.roles.manage');

        Route::get('/permissions', [SystemRolesController::class, 'permissionsIndex'])->name('systemroles.admin.roles.permissions');
        Route::post('/permissions/store', [SystemRolesController::class, 'permissionsStore'])->name('systemroles.admin.roles.permissions.store');
        Route::put('/permissions/update', [SystemRolesController::class, 'permissionsUpdate'])->name('systemroles.admin.roles.permissions.update');
        Route::get('/permissions/up', [SystemRolesController::class, 'moveInUp'])->name('systemroles.admin.roles.permissions.up');
        Route::get('/permissions/down', [SystemRolesController::class, 'moveInDown'])->name('systemroles.admin.roles.permissions.down');
        Route::get('/users', [SystemRolesController::class, 'users'])->name('systemroles.admin.roles.users');
        Route::post('/userdata', [SystemRolesController::class, 'userData'])->name('systemroles.admin.roles.users.userdata');
        Route::post('/user/assign', [SystemRolesController::class, 'assignRole'])->name('systemroles.admin.roles.user.assign');

        Route::get('/classes/index', [SystemClassesController::class, 'index'])->name('systemroles.admin.roles.classes.index');
        Route::get('/classes/manage', [SystemClassesController::class, 'manage'])->name('systemroles.admin.roles.classes.manage');
        Route::post('/classes/in/store', [SystemClassesController::class, 'store'])->name('systemroles.admin.roles.classes.in.store');
        Route::post('/classes/in/init', [SystemClassesController::class, 'systemClassesInit'])->name('systemroles.admin.roles.classes.in.init');

        Route::get('/routes/index', [SystemRoutesController::class, 'index'])->name('systemroles.admin.roles.routes.index');
        Route::get('/routes/manage', [SystemRoutesController::class, 'manage'])->name('systemroles.admin.roles.routes.manage');
        Route::post('/routes/init', [SystemRoutesController::class, 'controllerInit'])->name('systemroles.admin.roles.routes.init');   
        Route::post('/routes/store', [SystemRoutesController::class, 'store'])->name('systemroles.admin.roles.routes.store');

        Route::get('/menus/index', [SystemMenusController::class, 'index'])->name('systemroles.admin.menus.index');
        Route::get('/menus/items', [SystemMenusController::class, 'items'])->name('systemroles.admin.menus.items');   
        Route::get('/menus/manage', [SystemMenusController::class, 'manage'])->name('systemroles.admin.menus.manage'); 
        Route::get('/menus/items/manage', [SystemMenusController::class, 'manageItems'])->name('systemroles.admin.menus.items.manage');   
        Route::post('/menus/store', [SystemMenusController::class, 'store'])->name('systemroles.admin.menus.store');
        Route::post('/menus/assign', [SystemMenusController::class, 'assign'])->name('systemroles.admin.menus.assign');
        Route::post('/menus/items/store', [SystemMenusController::class, 'itemsStore'])->name('systemroles.admin.menus.items.store');
        Route::delete('/menus/destroy', [SystemMenusController::class, 'menuDestroy'])->name('systemroles.admin.menus.destroy');
        Route::delete('/menus/items/destroy', [SystemMenusController::class, 'menuItemDestroy'])->name('systemroles.admin.menus.items.destroy');

        Route::get('/menus/items/manage/sync', [SystemMenusController::class, 'syncMenuItemsSequence'])->name('systemroles.admin.menus.items.manage.sync');
        Route::get('/menus/items/manage/up', [SystemMenusController::class, 'moveMenuItemUp'])->name('systemroles.admin.menus.items.manage.up');
        Route::get('/menus/items/manage/down', [SystemMenusController::class, 'moveMenuItemDown'])->name('systemroles.admin.menus.items.manage.down');
   });

});
