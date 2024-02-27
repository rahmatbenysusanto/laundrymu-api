<?php

namespace App\Http\Controllers;

use App\Http\Services\ArtikelService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtikelController extends Controller
{
    public function __construct(
        protected ArtikelService $artikelService,
        protected ResponseService $responseService
    ) {}

    public function getArtikel(): \Illuminate\Http\JsonResponse
    {
        $result = $this->artikelService->getArtikel();

        return $this->responseService->responseWithData(true, 'Get artikel successfully', $result, 200);
    }

    public function getArtikelActive(): \Illuminate\Http\JsonResponse
    {
        $result = $this->artikelService->getArtikelActive();

        return $this->responseService->responseWithData(true, 'Get artikel active successfully', $result, 200);
    }

    public function getArtikelLimit($limit): \Illuminate\Http\JsonResponse
    {
        $result = $this->artikelService->getArtikelLimit($limit);

        return $this->responseService->responseWithData(true, 'Get artikel active successfully', $result, 200);
    }

    public function buatArtikel(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->artikelService->buatArtikel($request);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Create artikel successfully', 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Create artikel failed', $err->getMessage(), 400);
        }
    }
}
