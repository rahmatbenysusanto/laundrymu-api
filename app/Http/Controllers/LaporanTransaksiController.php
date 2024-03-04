<?php

namespace App\Http\Controllers;

use App\Http\Services\LaporanTransaksiService;
use App\Http\Services\ResponseService;
use App\Jobs\LogSlackJob;
use Illuminate\Http\Request;

class LaporanTransaksiController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected LaporanTransaksiService $laporanTransaksiService
    ) {}

    public function ops_transaksi($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->laporanTransaksiService->ops_transaksi($toko_id);
        return $this->responseService->responseWithData(true, 'Get laporan transaksi successfully', $result, 200);
    }

    public function ops_transaksiByDate($toko_id, $start, $finish): \Illuminate\Http\JsonResponse
    {
        $result = $this->laporanTransaksiService->ops_transaksiByDate($toko_id, $start, $finish);
        return $this->responseService->responseWithData(true, 'Get laporan transaksi successfully', $result, 200);
    }

    public function ops_layanan($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->laporanTransaksiService->ops_layanan($toko_id);
        return $this->responseService->responseWithData(true, 'Get laporan layanan successfully', $result, 200);
    }

    public function ops_parfum($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->laporanTransaksiService->ops_parfum($toko_id);
        return $this->responseService->responseWithData(true, 'Get laporan parfum successfully', $result, 200);
    }

    public function ops_diskon($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->laporanTransaksiService->ops_diskon($toko_id);
        return $this->responseService->responseWithData(true, 'Get laporan diskon successfully', $result, 200);
    }

    public function ops_pembayaran($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->laporanTransaksiService->ops_pembayaran($toko_id);
        return $this->responseService->responseWithData(true, 'Get laporan pembayaran successfully', $result, 200);
    }
}
