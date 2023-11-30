<?php

namespace App\Http\Controllers;

use App\Http\Requests\Layanan\Create;
use App\Http\Requests\Layanan\Edit;
use App\Http\Services\LayananService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class LayananController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected LayananService $layananService
    ){}

    public function findByToko($toko_id): JsonResponse
    {
        $result = $this->layananService->findByToko($toko_id);

        return $this->responseService->responseWithData(true, "Get layanan by toko successfully", $result, 200);
    }

    public function findById($id): JsonResponse
    {
        $result = $this->layananService->findById($id);

        return $this->responseService->responseWithData(true, "Get layanan by id successfully", $result, 200);
    }

    public function create(Create $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->layananService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, "Create layanan successfully", 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Create layanan failed", $err->getMessage(), 400);
        }
    }

    public function edit($id, Edit $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->layananService->edit($id, $request);
            DB::commit();
            return $this->responseService->responseNotData(true, "Edit layanan successfully", 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Edit layanan failed", $err->getMessage(), 400);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->layananService->delete($id);
            DB::commit();
            return $this->responseService->responseNotData(true, "Hapus layanan successfully", 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Hapus layanan failed", $err->getMessage(), 400);
        }
    }
}
