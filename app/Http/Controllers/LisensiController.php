<?php

namespace App\Http\Controllers;

use App\Http\Services\LisensiService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;

class LisensiController extends Controller
{
    public function __construct(
        protected LisensiService $lisensiService,
        protected ResponseService $responseService
    ) {}

    public function get(): \Illuminate\Http\JsonResponse
    {
        $result = $this->lisensiService->get();
        return $this->responseService->responseWithData(true, 'Get Lisensi laundry successfully', $result, 200);
    }
}
