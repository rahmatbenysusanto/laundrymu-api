<?php

namespace App\Http\Services;

use App\Http\Repository\MetodePembayaranRepository;

class MetodePembayaranService
{
    public function __construct(
        protected MetodePembayaranRepository $metodePembayaranRepository
    ) {}

    public function get(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->metodePembayaranRepository->get();
    }
}
