<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiKey;
use App\Http\Middleware\TokenJWT;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ParfumController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\PengirimanController;

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
            Route::patch('/layanan/{id}', 'edit');
            Route::delete('/layanan/{id}', 'delete');
        });

        Route::controller(ParfumController::class)->group(function () {
            Route::get('/parfum/toko/{toko_id}', 'findByToko');
            Route::post('/parfum', 'create');
            Route::get('/parfum/{id}', 'findById');
            Route::patch('/parfum/{id}', 'edit');
            Route::delete('/parfum/{id}', 'delete');
        });

        Route::controller(DiskonController::class)->group(function () {
            Route::get('/diskon/toko/{toko_id}', 'findByToko');
            Route::post('/diskon', 'create');
            Route::get('/diskon/{id}', 'findById');
            Route::patch('/diskon/{id}', 'edit');
            Route::delete('/diskon/{id}', 'delete');
        });

        Route::controller(PengirimanController::class)->group(function () {
            Route::get('/pengiriman/toko/{toko_id}', 'findByToko');
            Route::post('/pengiriman', 'create');
            Route::get('/pengiriman/{id}', 'findById');
            Route::patch('/pengiriman/{id}', 'edit');
            Route::delete('/pengiriman/{id}', 'delete');
        });
    });
});

