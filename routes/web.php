<?php

declare(strict_types=1);

namespace BabeRuka\SystemRoles\Routes;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route; 
use BabeRuka\SystemRoles\Http\Controllers\SystemRoles\SystemRolesController;
use BabeRuka\SystemRoles\Http\Controllers\SystemRoles\SystemClassesController;

Route::prefix('systemroles/admin')->group(function () { 

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
    });

});