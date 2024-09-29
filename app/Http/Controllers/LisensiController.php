<?php

namespace App\Http\Controllers;

use App\Http\Service\LisensiService;
use Illuminate\Http\Request;

class LisensiController extends Controller
{
    public function __construct(
        protected LisensiService  $lisensiService
    ) {}

    public function getLisensi(): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->lisensiService->get();
            return response()->json([
                'status'    => true,
                'message'   => 'Get Lisensi Successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Lisensi Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
