<?php

namespace App\Http\Controllers;

use App\Http\Services\DashboardService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected DashboardService $dashboardService
    ) {}

    public function getTopPelanggan($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->dashboardService->getTopPelanggan($toko_id);
        return $this->responseService->responseWithData(true, 'Get Top Transaksi Pelanggan Bulanan Successfully', $result, 200);
    }

    public function getStatusTransaksi($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->dashboardService->getStatusTransaksi($toko_id);
        return $this->responseService->responseWithData(true, 'Get Status Transaksi Successfully', $result, 200);
    }

    public function nominalTransaksiBulan($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->dashboardService->nominalTransaksiBulan($toko_id);
        return $this->responseService->responseWithData(true, 'Get Nominal Transaksi Successfully', $result, 200);
    }

    public function transaksiHarian($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->dashboardService->transaksiHarian($toko_id);
        return $this->responseService->responseWithData(true, 'Get Transaksi Harian Successfully', $result, 200);
    }

    public function chartDashboard($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->dashboardService->chartDashboard($toko_id);
        return $this->responseService->responseWithData(true, 'Get Transaksi Harian Successfully', $result, 200);
    }
}
