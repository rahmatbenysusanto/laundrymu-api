<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pengiriman\Create;
use App\Http\Requests\Pengiriman\Edit;
use App\Http\Services\PengirimanService;
use App\Http\Services\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected PengirimanService $pengirimanService
    ){}

    public function findByToko($toko_id): JsonResponse
    {
        $result = $this->pengirimanService->findByToko($toko_id);

        return $this->responseService->responseWithData(true, "Get pengiriman by toko successfully", $result, 200);
    }

    public function findById($id): JsonResponse
    {
        $result = $this->pengirimanService->findById($id);

        return $this->responseService->responseWithData(true, "Get pengiriman by id successfully", $result, 200);
    }

    public function create(Create $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pengirimanService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, "Create pengiriman successfully", 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Create pengiriman failed", $err->getMessage(), 400);
        }
    }

    public function edit($id, Edit $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pengirimanService->edit($id, $request);
            DB::commit();
            return $this->responseService->responseNotData(true, "Edit pengiriman successfully", 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Edit pengiriman failed", $err->getMessage(), 400);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pengirimanService->delete($id);
            DB::commit();
            return $this->responseService->responseNotData(true, "Hapus pengiriman successfully", 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Hapus pengiriman failed", $err->getMessage(), 400);
        }
    }
}
