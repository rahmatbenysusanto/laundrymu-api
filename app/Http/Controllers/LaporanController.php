<?php

namespace App\Http\Controllers;

use App\Http\Services\LaporanService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Laporan\Create;
use App\Http\Requests\Laporan\Update;

class LaporanController extends Controller
{
    public function __construct(
        protected LaporanService $laporanService,
        protected ResponseService $responseService
    ) {}

    public function findById($userId): \Illuminate\Http\JsonResponse
    {
        $result = $this->laporanService->findById($userId);
        return $this->responseService->responseWithData(true, 'Get laporan successfully', $result, 200);
    }

    public function getAll(): \Illuminate\Http\JsonResponse
    {
        $result = $this->laporanService->getAll();
        return $this->responseService->responseWithData(true, 'Get laporan successfully', $result, 200);
    }

    public function create(Create $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->laporanService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Create laporan successfully', 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Create laporan failed', $err->getMessage(), 400);
        }
    }

    public function update(Update $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            DB::commit();
            return $this->responseService->responseNotData(true, 'Create laporan successfully', 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Create laporan failed', $err->getMessage(), 400);
        }
    }
}
