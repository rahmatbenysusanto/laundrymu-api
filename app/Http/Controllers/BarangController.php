<?php

namespace App\Http\Controllers;

use App\Http\Requests\Barang\Create;
use App\Http\Requests\Barang\KurangiStok;
use App\Http\Requests\Barang\TambahStok;
use App\Http\Services\BarangService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected BarangService $barangService
    ) {}

    public function create(Create $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->barangService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Create barang successfully', 201);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::channel('barang')->error($err->getMessage());
            return $this->responseService->responseErrors(false, 'Create barang failed', $err->getMessage(), 400);
        }
    }

    public function tambahStok(TambahStok $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->barangService->tambahStok($request);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Tambah stok barang successfully', 200);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::channel('barang')->error($err->getMessage());
            return $this->responseService->responseErrors(false, 'Tambah stok barang failed', $err->getMessage(), 400);
        }
    }

    public function kurangiStok(KurangiStok $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->barangService->kurangiStok($request);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Kurangi stok barang successfully', 200);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::channel('barang')->error($err->getMessage());
            return $this->responseService->responseErrors(false, 'Kurangi stok barang failed', $err->getMessage(), 400);
        }
    }

    public function historiPembelian($tokoId): \Illuminate\Http\JsonResponse
    {
        $result = $this->barangService->historiPembelian($tokoId);
        return $this->responseService->responseWithData(true, 'Get histori pembelian barang successfully', $result, 200);
    }

    public function historiPenggunaan($tokoId): \Illuminate\Http\JsonResponse
    {
        $result = $this->barangService->historiPenggunaan($tokoId);
        return $this->responseService->responseWithData(true, 'Get histori penggunaan barang successfully', $result, 200);
    }

    public function listStokBarang($tokoId): \Illuminate\Http\JsonResponse
    {
        $result = $this->barangService->listStokBarang($tokoId);
        return $this->responseService->responseWithData(true, 'Get stok barang successfully', $result, 200);
    }
}
