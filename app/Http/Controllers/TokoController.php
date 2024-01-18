<?php

namespace App\Http\Controllers;

use App\Http\Requests\Toko\CreateToko;
use App\Http\Services\ResponseService;
use App\Http\Services\TokoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TokoController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected TokoService $tokoService
    ){}

    public function getAll(): JsonResponse
    {
        $toko = $this->tokoService->getAll();

        return $this->responseService->responseWithData(true, "Get all toko success", $toko, 200);
    }

    public function findByUser($userId): JsonResponse
    {
        $toko = $this->tokoService->findByUser($userId);

        return $this->responseService->responseWithData(true, "Get toko success", $toko, 200);
    }

    public function getTokoPegawai($user_id): JsonResponse
    {
        $toko = $this->tokoService->getTokoPegawai($user_id);

        return $this->responseService->responseWithData(true, "Get toko success", $toko, 200);
    }

    public function findById($tokoId): JsonResponse
    {
        $toko = $this->tokoService->findById($tokoId);

        return $this->responseService->responseWithData(true, "Get toko success", $toko, 200);
    }

    public function create(CreateToko $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->tokoService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, "Create toko successfully", 201);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::channel('toko')->error($err->getMessage());
            return $this->responseService->responseErrors(false, 'Create Toko Error', $err->getMessage(), 400);
        }
    }

    public function historiPembayaranOutlet($user_id): JsonResponse
    {
        $pembayaranOutlet = $this->tokoService->historiPembayaranOutlet($user_id);

        return $this->responseService->responseWithData(true, "Get histori pembayaran outlet success", $pembayaranOutlet, 200);
    }

    public function detailPembayaran($nomor_pembayaran): JsonResponse
    {
        $pembayaranOutlet = $this->tokoService->getDetailPembayaran($nomor_pembayaran);

        return $this->responseService->responseWithData(true, "Get histori pembayaran outlet success", $pembayaranOutlet, 200);
    }

    public function uploadBuktiPembayaran(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->tokoService->uploadBuktiPembayaran($request->post('id'), $request->post('image'));
            DB::commit();
            return $this->responseService->responseNotData(true, 'Upload bukti pembayaran successfully', 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Upload bukti pembayaran failed', $err->getMessage(), 400);
        }
    }
}
