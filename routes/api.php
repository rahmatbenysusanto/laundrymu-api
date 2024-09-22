<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\FlipController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ParfumController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TransaksiController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware(JwtMiddleware::class)->group(function () {
    Route::get('/tes', function () {
        return response()->json([
            'status'    => true
        ]);
    });

    Route::prefix('parfum')->controller(ParfumController::class)->group(function () {
        Route::post('/', 'create');
        Route::get('/', 'find');
        Route::patch('/', 'update');
        Route::delete('/', 'delete');
    });

    Route::prefix('pembayaran')->controller(PembayaranController::class)->group(function () {
        Route::post('/', 'create');
        Route::get('/', 'find');
        Route::patch('/', 'update');
        Route::delete('/', 'delete');
    });

    Route::prefix('flip')->controller(FlipController::class)->group(function () {
        Route::get('/get-balance', 'getBalance');
        Route::get('/get-all-payment', 'getAllPayment');
    });

    Route::prefix('pelanggan')->controller(PelangganController::class)->group(function () {
        Route::post('/', 'create');
        Route::get('/', 'find');
        Route::patch('/', 'update');
    });

    Route::prefix('transaksi')->controller(TransaksiController::class)->group(function () {
        Route::post('/', 'create');
        Route::patch('/cancel', 'cancel');
        Route::patch('/', 'update');
    });

    Route::prefix('chat')->controller(ChatController::class)->group(function () {
        Route::post('/', 'create');
        Route::get('/', 'getByOutboundId');
    });

    Route::prefix('layanan')->controller(LayananController::class)->group(function () {
        Route::post('/', 'create');
        Route::get('/', 'find');
        Route::patch('/', 'update');
        Route::delete('/', 'delete');
    });

    Route::prefix('outlet')->controller(OutletController::class)->group(function () {
        Route::post('/pembayaran', 'perpanjangLisensi');
    });
});

Route::get('/callback/accept-payment', [FlipController::class, 'callbackAcceptPayment']);


