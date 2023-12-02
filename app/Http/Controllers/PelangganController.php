<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pelanggan\Create;
use App\Http\Requests\Pelanggan\Edit;
use App\Http\Services\PelangganService;
use App\Http\Services\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected PelangganService $pelangganService
    ){}

    public function findByToko($toko_id): JsonResponse
    {
        $result = $this->pelangganService->findByToko($toko_id);

        return $this->responseService->responseWithData(true, "Get pelanggan by toko successfully", $result, 200);
    }

    public function findById($id): JsonResponse
    {
        $result = $this->pelangganService->findById($id);

        return $this->responseService->responseWithData(true, "Get pelanggan by id successfully", $result, 200);
    }

    public function create(Create $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pelangganService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, "Create pelanggan successfully", 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Create pelanggan failed", $err->getMessage(), 400);
        }
    }

    public function edit($id, Edit $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pelangganService->edit($id, $request);
            DB::commit();
            return $this->responseService->responseNotData(true, "Edit pelanggan successfully", 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Edit pelanggan failed", $err->getMessage(), 400);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pelangganService->delete($id);
            DB::commit();
            return $this->responseService->responseNotData(true, "Hapus pelanggan successfully", 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Hapus pelanggan failed", $err->getMessage(), 400);
        }
    }
}
