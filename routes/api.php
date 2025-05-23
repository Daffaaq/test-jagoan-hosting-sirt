<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\API\IuranApiController;
use App\Http\Controllers\API\PenghuniApiController;
use App\Http\Controllers\API\PenghuniRumahApiController;
use App\Http\Controllers\API\RumahApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [AuthApiController::class, 'login']);

Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        Route::post('/auth/logout', [AuthApiController::class, 'logout']);
        Route::apiResource('rumah', RumahApiController::class)->names([
            'index' => 'api.rumah.index',
            'store' => 'api.rumah.store',
            'show' => 'api.rumah.show',
            'update' => 'api.rumah.update',
            'destroy' => 'api.rumah.destroy',
        ]);

        Route::apiResource('iuran', IuranApiController::class)->names([
            'index' => 'api.iuran.index',
            'store' => 'api.iuran.store',
            'show' => 'api.iuran.show',
            'update' => 'api.iuran.update',
            'destroy' => 'api.iuran.destroy',
        ]);

        Route::apiResource('penghuni', PenghuniApiController::class)->names([
            'index' => 'api.penghuni.index',
            'store' => 'api.penghuni.store',
            'show' => 'api.penghuni.show',
            'update' => 'api.penghuni.update',
            'destroy' => 'api.penghuni.destroy',
        ]);

        Route::get('rumah/{id}/penghuni-rumah', [PenghuniRumahApiController::class, 'index']);
        Route::post('rumah/{id}/penghuni-rumah', [PenghuniRumahApiController::class, 'store']);
        Route::put('rumah/{id}/penghuni-rumah/update', [PenghuniRumahApiController::class, 'update']);
        Route::delete('rumah/{id}/penghuni-rumah/delete', [PenghuniRumahApiController::class, 'destroy']);
    }
);
