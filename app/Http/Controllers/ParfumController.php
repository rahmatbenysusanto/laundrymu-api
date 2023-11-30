<?php

namespace App\Http\Controllers;

use App\Http\Requests\Parfum\Create;
use App\Http\Requests\Parfum\Edit;
use App\Http\Services\ParfumService;
use App\Http\Services\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParfumController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected ParfumService $parfumService
    ){}

    public function findByToko($toko_id): JsonResponse
    {
        $result = $this->parfumService->findByToko($toko_id);

        return $this->responseService->responseWithData(true, "Get parfum by toko successfully", $result, 200);
    }

    public function findById($id): JsonResponse
    {
        $result = $this->parfumService->findById($id);

        return $this->responseService->responseWithData(true, "Get parfum by id successfully", $result, 200);
    }

    public function create(Create $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->parfumService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, "Create parfum successfully", 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Create parfum failed", $err->getMessage(), 400);
        }
    }

    public function edit($id, Edit $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->parfumService->edit($id, $request);
            DB::commit();
            return $this->responseService->responseNotData(true, "Edit parfum successfully", 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Edit parfum failed", $err->getMessage(), 400);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->parfumService->delete($id);
            DB::commit();
            return $this->responseService->responseNotData(true, "Hapus parfum successfully", 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, "Hapus parfum failed", $err->getMessage(), 400);
        }
    }
}
