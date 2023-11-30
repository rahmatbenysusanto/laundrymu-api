<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiKey;
use App\Http\Middleware\TokenJWT;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\LayananController;

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

Route::middleware([ApiKey::class])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('/user/register', 'create');
        Route::post('/user/login', 'login');
    });

    Route::middleware([TokenJWT::class])->group(function () {
        Route::controller(TokoController::class)->group(function () {
            Route::get('/toko', 'getAll');
            Route::get('/toko/user/{userId}', 'findByUser');
            Route::get('/toko/{tokoId}', 'findById');
            Route::post('/toko', 'create');
        });

        Route::controller(LayananController::class)->group(function () {
            Route::get('/layanan/toko/{toko_id}', 'findByToko');
            Route::post('/layanan', 'create');
            Route::get('/layanan/{id}', 'findById');
            Route::patch('/layanan', 'edit');
            Route::delete('/layanan/{id}', 'delete');
        });
    });
});
