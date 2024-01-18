<?php

namespace App\Http\Controllers;

use App\Http\Services\MetodePembayaranService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;

class MetodePembayaranController extends Controller
{
    public function __construct(
        protected MetodePembayaranService $metodePembayaranService,
        protected ResponseService $responseService
    ) {}

    public function get(): \Illuminate\Http\JsonResponse
    {
        $result = $this->metodePembayaranService->get();
        return $this->responseService->responseWithData(true, 'Get Lisensi laundry successfully', $result, 200);
    }
}
