<?php

namespace App\Http\Services;

use App\Http\Repository\PaymentMethodRepository;

class PaymentService
{
    public function __construct(
        protected PaymentMethodRepository $paymentMethodRepository
    ) {}

    public function getPaymentMethod(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->paymentMethodRepository->get();
    }
}
