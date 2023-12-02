<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pembayaran\Create;
use App\Http\Requests\Pembayaran\Edit;
use App\Http\Services\PembayaranService;
use App\Http\Services\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected PembayaranService $pembayaranService
    ){}

    public function findByToko($toko_id): JsonResponse
    {
        $result = $this->pembayaranService->findByToko($toko_id);

        return $this->responseService->responseWithData(true, "Get pembayaran by toko successfully", $result, 200);
    }

    public function findById($id): JsonResponse
    {
        $result = $this->pembayaranService->findById($id);

        return $this->responseService->responseWithData(true, "Get pembayaran by id successfully", $result, 200);
    }

    public function create(Create $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pembayaranService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, "Create pembayaran successfully", 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Create pembayaran failed", $err->getMessage(), 400);
        }
    }

    public function edit($id, Edit $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pembayaranService->edit($id, $request);
            DB::commit();
            return $this->responseService->responseNotData(true, "Edit pembayaran successfully", 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Edit pembayaran failed", $err->getMessage(), 400);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pembayaranService->delete($id);
            DB::commit();
            return $this->responseService->responseNotData(true, "Hapus pembayaran successfully", 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Hapus pembayaran failed", $err->getMessage(), 400);
        }
    }
}
