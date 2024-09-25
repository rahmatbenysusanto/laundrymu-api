<?php

namespace App\Http\Controllers;

use App\Http\Service\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function getStatusTransaksi(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->dashboardService->getStatusTransaksi($request->query('outlet_id'));

            return response()->json([
                'status'    => true,
                'message'   => 'Get Status Transaksi Successfully',
                'data'      => $result
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Status Transaksi Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function statisticTransaksi(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->dashboardService->statisticTransaksi($request->query('outlet_id'), $request->query('start_date'), $request->query('end_date'));

            return response()->json([
                'status'    => true,
                'message'   => 'Get Statistic Transaksi Successfully',
                'data'      => $result
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Statistic Transaksi Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function chart(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->dashboardService->chart($request->query('outlet_id'));

            return response()->json([
                'status'    => true,
                'message'   => 'Get Chart Transaksi Successfully',
                'data'      => $result
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Chart Transaksi Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
