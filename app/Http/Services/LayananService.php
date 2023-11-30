<?php

namespace App\Http\Services;

use App\Http\Repository\LayananRepository;

class LayananService
{
    public function __construct(
        protected LayananRepository $layananRepository
    ){}

    public function findByToko($toko_id)
    {
        return $this->layananRepository->findByToko($toko_id);
    }

    public function findById($id)
    {
        return $this->layananRepository->findById($id);
    }
}
