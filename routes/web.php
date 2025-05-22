<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\Menu\MenuGroupController;
use App\Http\Controllers\Menu\MenuItemController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\PenghuniRumahController;
use App\Http\Controllers\RoleAndPermission\AssignPermissionController;
use App\Http\Controllers\RoleAndPermission\AssignUserToRoleController;
use App\Http\Controllers\RoleAndPermission\PermissionController;
use App\Http\Controllers\RoleAndPermission\RoleController;
use App\Http\Controllers\RumahController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', function () {
        return view('home');
    });

    Route::prefix('master-management')->group(function () {
        // rumah
        Route::resource('rumah', RumahController::class);
        Route::post('/rumah/list', [RumahController::class, 'list'])->name('rumah.list');
        Route::get('/rumah/{rumah}/penghuni-rumah', [PenghuniRumahController::class, 'createPenghuni'])->name('rumah.penghuni');
        Route::post('/rumah/{rumah}/penghuni-rumah', [PenghuniRumahController::class, 'storePenghuni'])->name('rumah.store.penghuni');
        Route::get('/rumah/{penghuniRumah}/penghuni-rumah/edit', [PenghuniRumahController::class, 'editPenghuni'])->name('rumah.penghuni.edit');
        Route::put('/rumah/{penghuniRumah}/penghuni-rumah', [PenghuniRumahController::class, 'updatePenghuni'])->name('rumah.penghuni.update');
        Route::delete('/rumah/{penghuniRumah}/penghuni-rumah', [PenghuniRumahController::class, 'destroyPenghuni'])->name('rumah.penghuni.destroy');
        Route::post('/rumah/{rumah}/penghuni/list', [PenghuniRumahController::class, 'listPenghuniRumah'])->name('rumah.penghuni.list');

        Route::resource('penghuni', PenghuniController::class);
        Route::post('/penghuni/list', [PenghuniController::class, 'list'])->name('penghuni.list');

        //iuran
        Route::resource('iuran', IuranController::class);
        Route::post('/iuran/list', [IuranController::class, 'list'])->name('iuran.list');
    });

    Route::prefix('transaksi-management')->group(function () {});

    Route::prefix('user-management')->group(function () {
        Route::resource('user', UserController::class);
        Route::post('/user/list', [UserController::class, 'list'])->name('user.list');
    });

    Route::prefix('menu-management')->group(function () {
        Route::resource('menu-group', MenuGroupController::class);
        Route::post('/menu-group/list', [MenuGroupController::class, 'list'])->name('menu-group.list');

        Route::resource('menu-item', MenuItemController::class);
        Route::post('/menu-item/list', [MenuItemController::class, 'list'])->name('menu-item.list');
    });

    Route::group(['prefix' => 'role-and-permission'], function () {
        //role
        Route::resource('role', RoleController::class);
        Route::post('/role/list', [RoleController::class, 'list'])->name('role.list');

        //permission
        Route::resource('permission', PermissionController::class);
        Route::post('/permission/list', [PermissionController::class, 'list'])->name('permission.list');

        //assign permission
        Route::get('assign', [AssignPermissionController::class, 'index'])->name('assign.index');
        Route::get('assign/create', [AssignPermissionController::class, 'create'])->name('assign.create');
        Route::get('assign/{role}/edit', [AssignPermissionController::class, 'edit'])->name('assign.edit');
        Route::put('assign/{role}', [AssignPermissionController::class, 'update'])->name('assign.update');
        Route::post('assign', [AssignPermissionController::class, 'store'])->name('assign.store');
        Route::post('/assign/list', [AssignPermissionController::class, 'list'])->name('assign.list');

        //assign user to role
        Route::get('assign-user', [AssignUserToRoleController::class, 'index'])->name('assign.user.index');
        Route::get('assign-user/create', [AssignUserToRoleController::class, 'create'])->name('assign.user.create');
        Route::post('assign-user', [AssignUserToRoleController::class, 'store'])->name('assign.user.store');
        Route::get('assign-user/{user}/edit', [AssignUserToRoleController::class, 'edit'])->name('assign.user.edit');
        Route::put('assign-user/{user}', [AssignUserToRoleController::class, 'update'])->name('assign.user.update');
        Route::post('/assign-user/list', [AssignUserToRoleController::class, 'list'])->name('assign.user.list');
    });
});
