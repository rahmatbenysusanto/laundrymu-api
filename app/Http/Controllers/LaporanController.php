<?php

namespace App\Http\Controllers;

use App\Http\Service\LaporanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LaporanController extends Controller
{
    public function __construct(
        protected LaporanService $laporanService
    ) {}

    // Laporan Operasional

    public function getTransaksi(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->laporanService->getTransaksi($request->query('outlet_id'), $request->query('start'), $request->query('end'));

            return response()->json([
                'status'    => true,
                'message'   => 'Get Data Laporan Success',
                'data'      => $result
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Data Laporan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function getLayanan(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->laporanService->getLayanan($request->query('outlet_id'), $request->query('start'), $request->query('end'));
            return response()->json([
                'status'    => true,
                'message'   => 'Get Data Laporan Success',
                'data'      => $result
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Data Laporan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function getParfum(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->laporanService->getParfum($request->query('outlet_id'), $request->query('start'), $request->query('end'));
            return response()->json([
                'status'    => true,
                'message'   => 'Get Data Laporan Success',
                'data'      => $result
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Data Laporan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function getDiskon(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->laporanService->getDiskon($request->query('outlet_id'), $request->query('start'), $request->query('end'));
            return response()->json([
                'status'    => true,
                'message'   => 'Get Data Laporan Success',
                'data'      => $result
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Data Laporan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function getPembayaran(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->laporanService->getPembayaran($request->query('outlet_id'), $request->query('start'), $request->query('end'));
            return response()->json([
                'status'    => true,
                'message'   => 'Get Data Laporan Success',
                'data'      => $result
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Data Laporan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
