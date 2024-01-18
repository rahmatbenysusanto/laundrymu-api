<?php

namespace App\Http\Controllers;

use App\Http\Services\KodePosService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;

class KodePosController extends Controller
{
    public function __construct(
        protected KodePosService $kodePosService,
        protected ResponseService $responseService
    ) {}

    public function getProvinsi(): \Illuminate\Http\JsonResponse
    {
        $result = $this->kodePosService->getProvinsi();
        return $this->responseService->responseWithData(true, 'Get Provinsi Successfully', $result, 200);
    }

    public function getKota(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->kodePosService->getKota($request->provinsi);
        return $this->responseService->responseWithData(true, 'Get Kota Successfully', $result, 200);
    }

    public function getKecamatan(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->kodePosService->getKecamatan($request->kota, $request->provinsi);
        return $this->responseService->responseWithData(true, 'Get Kecamatan Successfully', $result, 200);
    }

    public function getKelurahan(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->kodePosService->getKelurahan($request->kecamatan, $request->kota, $request->provinsi);
        return $this->responseService->responseWithData(true, 'Get Kelurahan Successfully', $result, 200);
    }

    public function getKodePos(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->kodePosService->getKodePos($request->kelurahan, $request->kecamatan, $request->kota, $request->provinsi);
        return $this->responseService->responseWithData(true, 'Get Kode Pos Successfully', $result, 200);
    }
}
