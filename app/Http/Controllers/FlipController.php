<?php

namespace App\Http\Controllers;

use App\Http\Service\FlipService;
use App\Jobs\CallbackPaymentJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlipController extends Controller
{
    public function __construct(
        protected FlipService $flipService
    ) {}

    public function getBalance(): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->flipService->getBalance();

            return response()->json([
                'status'    => true,
                'message'   => 'Get Balance successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Balance Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function getAllPayment(): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->flipService->getAllPayment();

            return response()->json([
                'status'    => true,
                'message'   => 'Get all Payment successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => $err->getMessage(),
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function callbackAcceptPayment(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            CallbackPaymentJob::dispatch($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Callback accept payment successfully',
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => true,
                'message'   => 'Callback accept payment failed',
            ], 400);
        }
    }
}
