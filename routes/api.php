<?php

use App\Http\Controllers\AlamatController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\FlipController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LisensiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ParfumController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/generate-refresh-token', 'generateNewToken');
});

Route::get('/testing-api', function () {
//    \Illuminate\Support\Facades\DB::table('users')->get();
    return response()->json([
        'status'    => true
    ]);
});

Route::middleware(JwtMiddleware::class)->group(function () {
    Route::get('/tes', function () {
        return response()->json([
            'status'    => true
        ]);
    });

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/verifikasi-otp', 'verifikasiOTP');
    });

    Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {
        Route::get('/status-transaksi', 'getStatusTransaksi');
        Route::get('/statistic-transaksi', 'statisticTransaksi');
        Route::get('/chart', 'chart');
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
        Route::delete('/', 'delete');
    });

    Route::prefix('diskon')->controller(DiskonController::class)->group(function () {
        Route::post('/', 'create');
        Route::get('/', 'find');
        Route::patch('/', 'update');
        Route::delete('/', 'delete');
    });

    Route::prefix('transaksi')->controller(TransaksiController::class)->group(function () {
        Route::post('/', 'create');
        Route::patch('/cancel', 'cancel');
        Route::patch('/', 'updateStatus');
        Route::get('/', 'listTransaksi');
        Route::get('/detail', 'detailTransaksi');
        Route::get('/history', 'historyTransaksi');
    });

    Route::prefix('chat')->controller(ChatController::class)->group(function () {
        Route::post('/', 'create');
        Route::get('/', 'getByOutletId');
    });

    Route::prefix('layanan')->controller(LayananController::class)->group(function () {
        Route::post('/', 'create');
        Route::get('/', 'find');
        Route::patch('/', 'update');
        Route::delete('/', 'delete');
    });

    Route::prefix('outlet')->controller(OutletController::class)->group(function () {
        Route::post('/pembayaran', 'perpanjangLisensi');
        Route::get('/user', 'findByUserId');
        Route::post('/', 'create');
        Route::get('/', 'findById');
        Route::get('/history-pembayaran', 'historyPembayaran');
        Route::get('/detail-pembayaran', 'findByNomorPembayaran');
    });

    Route::prefix('alamat')->controller(AlamatController::class)->group(function () {
        Route::get('/provinsi', 'getProvinsi');
        Route::get('/kota', 'getKota');
        Route::get('/kecamatan', 'getKecamatan');
        Route::get('/kelurahan', 'getKelurahan');
        Route::get('/kodepos', 'getKodepos');
    });

    Route::prefix('lisensi')->controller(LisensiController::class)->group(function () {
        Route::get('/', 'getLisensi');
    });

    Route::prefix('pengiriman')->controller(PengirimanController::class)->group(function () {
        Route::get('/', 'find');
        Route::post('/', 'create');
        Route::delete('/', 'delete');
        Route::patch('/', 'update');
    });

    Route::prefix('laporan')->controller(LaporanController::class)->group(function () {
        // Operasional API
        Route::get('/jumlah-transaksi', 'getTransaksi');
        Route::get('/layanan', 'getLayanan');
        Route::get('/parfum', 'getParfum');
        Route::get('/diskon', 'getDiskon');
        Route::get('/pembayaran', 'getPembayaran');
    });

    Route::prefix('notification')->controller(NotificationController::class)->group(function () {
        Route::get('/', 'findByUserId');
        Route::get('/count', 'countNotification');
    });

    Route::prefix('pegawai')->controller(PegawaiController::class)->group(function () {
        Route::post('/', 'create');
    });

    Route::prefix('inventory')->controller(InventoryController::class)->group(function () {
        Route::get('/', 'getInventory');

        Route::prefix('pembelian')->group(function () {
            Route::get('/', 'getPembelian');
            Route::post('/', 'createPembelian');
        });

        Route::prefix('supplier')->group(function () {
            Route::get('/', 'getSupplierByOutletId');
            Route::post('/', 'createSupplier');
        });

        Route::prefix('barang')->group(function () {
            Route::post('/', 'createBarang');
        });

        Route::prefix('satuan')->group(function () {
            Route::get('/', 'satuan');
        });
    });
});

Route::get('/callback/accept-payment', [FlipController::class, 'callbackAcceptPayment']);
Route::get('/test-s3', [OutletController::class, 'uploadProfile']);


