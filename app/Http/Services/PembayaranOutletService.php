<?php

namespace App\Http\Services;

use App\Http\Repository\PembayaranOutletRepository;

class PembayaranOutletService
{
    public function __construct(
        protected PembayaranOutletRepository $pembayaranOutletRepository
    ) {}

    public function findByUserId($user_id)
    {
        return $this->pembayaranOutletRepository->findByUserId($user_id);
    }
}
