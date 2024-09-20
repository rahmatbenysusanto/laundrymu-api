<?php

namespace App\Http\Controllers;

use App\Http\Service\TransaksiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function __construct(
        protected TransaksiService $transaksiService
    ) {}

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->transaksiService->create($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Create transaksi success',
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create transaksi failed: ' . $err->getMessage(),
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function cancel($id): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->transaksiService->cancel($id);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Cancel transaksi success',
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Cancel transaksi failed: ' . $err->getMessage(),
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function updateStatus(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->transaksiService->updateStatus($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Update status success',
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Update status failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
