<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaksi\Create;
use App\Http\Services\ResponseService;
use App\Http\Services\TransaksiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function __construct(
        protected TransaksiService $transaksiService,
        protected ResponseService $responseService
    ){}

    public function list($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->transaksiService->list($toko_id);
        return $this->responseService->responseWithData(true, 'Get list transaksi successfully', $result, 200);
    }

    public function getHistoryByTokoId($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->transaksiService->getHistoryByTokoId($toko_id);
        return $this->responseService->responseWithData(true, 'Get list transaksi successfully', $result, 200);
    }

    public function findByOrderNumber($order_number): \Illuminate\Http\JsonResponse
    {
        $result = $this->transaksiService->findByOrderNumber($order_number);
        return $this->responseService->responseWithData(true, 'Get transaksi by order number successfully', $result, 200);
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->transaksiService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Create transaksi successfully', 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Create transaksi failed', $err->getMessage(), 400);
        }
    }

    public function prosesTransaksi($order_number, $status): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->transaksiService->prosesTransaksi($order_number, $status);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Proses transaksi successfully', 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Proses transaksi failed', $err->getMessage(), 400);
        }
    }
}
