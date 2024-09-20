<?php

namespace App\Http\Service;

use App\Http\Repository\FlipRepository;

class FlipService
{
    public function __construct(
       protected FlipRepository $flipRepository
    ) {}

    public function getAllPayment()
    {
        return $this->flipRepository->getAllPayment();
    }

    public function getBalance()
    {
        return $this->flipRepository->getBalance();
    }
}
