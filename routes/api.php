<?php
declare(strict_types=1);

namespace BabeRuka\SystemRoles\Routes;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route; 
use BabeRuka\SystemRoles\Http\Controllers\SystemRoles\SystemRolesController;
use BabeRuka\SystemRoles\Http\Controllers\SystemRoles\SystemClassesController;

Route::prefix('systemroles')->group(function () { 
    Route::post('/users/userdata', [SystemRolesController::class, 'userData'])->name('admin.users.userdata');
});
