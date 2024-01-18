<?php

namespace App\Http\Services;

use App\Http\Repository\LisensiRepository;

class LisensiService
{
    public function __construct(
        protected LisensiRepository $lisensiRepository
    ) {}

    public function get(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->lisensiRepository->get();
    }
}
