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
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;

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
        Route::get('/user/generate-new-token/{id}', 'generateNewToken');
        Route::post('/verifikasi-otp', 'verifikasiOTP');
        Route::get('/generate-new-otp/{userId}', 'generateNewOTP');
        Route::post('/lupa-kata-sandi', 'lupaKataSandi');
        Route::get('/check-validate-email/{email}', 'checkValidateEmail');
        Route::post('/ganti-password', 'gantiPassword');
        Route::get('/user', 'getAllUser');
    });

    Route::middleware([TokenJWT::class])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/generate-new-token/{id}', 'generateNewToken');
        });

        Route::controller(TokoController::class)->group(function () {
            Route::get('/toko', 'getAll');
            Route::get('/toko/user/{userId}', 'findByUser');
            Route::get('/toko/{tokoId}', 'findById');
            Route::post('/toko', 'create');
            Route::get('/toko/pegawai/{userId}', 'getTokoPegawai');
            Route::get('/toko/histori-pembayaran-outlet/{userId}', 'historiPembayaranOutlet');
            Route::get('/toko/get-detail-pembayaran/{nomorPembayaran}', 'detailPembayaran');
            Route::post('/toko/upload-bukti-pembayaran', 'uploadBuktiPembayaran');
            Route::patch('/toko/konfirmasi-pembayaran/{id}', 'konfirmasiPembayaran');
            Route::post('/toko/perpanjang-lisensi', 'perpanjangLisensi');

            // Super Admin API
            Route::get('/toko/super-admin/get-histori-pembayaran', 'admin_historiPembayaranOutlet');
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

        Route::controller(PelangganController::class)->group(function () {
            Route::get('/pelanggan/toko/{toko_id}', 'findByToko');
            Route::post('/pelanggan', 'create');
            Route::get('/pelanggan/{id}', 'findById');
            Route::patch('/pelanggan/{id}', 'edit');
            Route::delete('/pelanggan/{id}', 'delete');
        });

        Route::controller(PembayaranController::class)->group(function () {
            Route::get('/pembayaran/toko/{toko_id}', 'findByToko');
            Route::post('/pembayaran', 'create');
            Route::get('/pembayaran/{id}', 'findById');
            Route::patch('/pembayaran/{id}', 'edit');
            Route::delete('/pembayaran/{id}', 'delete');
        });

        Route::controller(\App\Http\Controllers\TransaksiController::class)->group(function () {
            Route::get('/transaksi/toko/{id}', 'list');
            Route::get('/transaksi/toko/{id}/{status}', 'getTransaksiByStatus');
            Route::get('/transaksi/history/toko/{id}', 'getHistoryByTokoId');
            Route::get('/transaksi/{orderNumber}', 'findByOrderNumber');
            Route::post('/transaksi', 'create');
            Route::patch('/transaksi/{orderNumber}/{status}', 'prosesTransaksi');
        });

        Route::controller(\App\Http\Controllers\PegawaiController::class)->group(function () {
            Route::get('/pegawai/toko/{id}', 'getByTokoId');
            Route::post('/pegawai', 'create');
            Route::post('/absen-pegawai', 'createAbsen');
            Route::get('/data-absen-pegawai/{tokoId}', 'findAbsensiPegawai');
            Route::get('/absen-pegawai/{pegawai_id}', 'findByPegawaiId');
            Route::get('/absen-pegawai/{pegawai_id}/{start}/{selesai}', 'findByPegawaiIdCustomDate');
        });

        Route::controller(\App\Http\Controllers\PaymentController::class)->group(function () {
           Route::get('/get-payment-method', 'getPaymentMethod');
        });

        Route::controller(\App\Http\Controllers\DashboardController::class)->group(function () {
            Route::get('/get-top-transaksi-pelanggan/{tokoId}', 'getTopPelanggan');
            Route::get('/get-status-transaksi/{tokoId}', 'getStatusTransaksi');
            Route::get('/get-nominal-transaksi/{tokoId}', 'nominalTransaksiBulan');
            Route::get('/get-transaksi-harian/{tokoId}', 'transaksiHarian');
            Route::get('/get-chart-dashboard/{tokoId}', 'chartDashboard');
            Route::get('/get-chart-dashboard-mobile/{tokoId}', 'chartDashboardMobile');
        });

        Route::controller(\App\Http\Controllers\KodePosController::class)->group(function () {
            Route::get('/get-provinsi', 'getProvinsi');
            Route::get('/get-kota', 'getKota');
            Route::get('/get-kecamatan', 'getKecamatan');
            Route::get('/get-kelurahan', 'getKelurahan');
            Route::get('/get-kode-pos', 'getKodePos');
        });

        Route::controller(\App\Http\Controllers\LisensiController::class)->group(function () {
            Route::get('/get-lisensi', 'get');
        });

        Route::controller(\App\Http\Controllers\MetodePembayaranController::class)->group(function () {
            Route::get('/get-metode-pembayaran', 'get');
        });

        Route::controller(\App\Http\Controllers\ArtikelController::class)->group(function () {
            Route::get('/get-artikel', 'getArtikel');
            Route::get('/artikel-active', 'getArtikelActive');
            Route::get('/artikel-limit', 'getArtikelLimit');
            Route::post('/artikel', 'buatArtikel');
        });

        Route::controller(\App\Http\Controllers\LaporanController::class)->group(function () {
            Route::get('/laporan', 'getAll');
            Route::get('/laporan/{userId}', 'findById');
            Route::post('/laporan', 'create');
            Route::patch('/laporan', 'update');
        });

        Route::controller(\App\Http\Controllers\BarangController::class)->group(function () {
            Route::post('/barang', 'create');
            Route::patch('/barang', 'updateBarang');
            Route::patch('/barang/tambah-stok', 'tambahStok');
            Route::patch('/barang/kurangi-stok', 'kurangiStok');
            Route::get('/barang/histori-pembelian/{tokoId}', 'historiPembelian');
            Route::get('/barang/histori-penggunaan/{tokoId}', 'historiPenggunaan');
            Route::get('/barang/stok/{tokoId}', 'listStokBarang');
        });

        Route::controller(\App\Http\Controllers\ChatController::class)->group(function () {
            Route::post('/chat', 'create');
            Route::get('/chat/{tokoId}', 'getChat');
        });

        Route::controller(\App\Http\Controllers\LaporanTransaksiController::class)->group(function () {
            Route::get('/laporan/transaksi-hari-ini/{tokoId}', 'ops_transaksi');
            Route::get('/laporan/transaksi-by-date/{tokoId}/{start}/{finish}', 'ops_transaksiByDate');

            Route::get('/laporan/layanan/{tokoId}', 'ops_layanan');
            Route::get('/laporan/parfum/{tokoId}', 'ops_parfum');
            Route::get('/laporan/diskon/{tokoId}', 'ops_diskon');
            Route::get('/laporan/pembayaran/{tokoId}', 'ops_pembayaran');
        });
    });
});

