<?php

namespace App\Http\Controllers;

use App\Http\Services\PegawaiService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PegawaiController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected PegawaiService $pegawaiService
    ){}

    public function getByTokoId($toko_id): \Illuminate\Http\JsonResponse
    {
        $pegawai = $this->pegawaiService->getByTokoId($toko_id);
        return $this->responseService->responseWithData(true, 'Get pegawai by toko successfully', $pegawai, 200);
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pegawaiService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Create pegawai successfully', 201);
        } catch (\Exception $err) {
            Log::channel('pegawai')->error($err->getMessage());
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Create pegawai failed', $err->getMessage(), 400);
        }
    }
}
