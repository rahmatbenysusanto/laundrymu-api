<?php

namespace App\Http\Controllers;

use App\Http\Services\PaymentService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
        protected ResponseService $responseService
    ) {}
    public function getPaymentMethod(): \Illuminate\Http\JsonResponse
    {
        $paymentMethod = $this->paymentService->getPaymentMethod();
        return $this->responseService->responseWithData(true, 'Get Payment Method Successfully', $paymentMethod, 200);
    }
}
