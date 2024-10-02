<?php

namespace App\Http\Service;

use App\Http\Repository\PengirimanRepository;

class PengirimanService
{
    public function __construct(
        protected PengirimanRepository $pengirimanRepository
    ) {}

    public function create($request)
    {

    }

    public function findById($id)
    {

    }

    public function findByOutletId($outlet_id)
    {
        return $this->pengirimanRepository->findByOutletId($outlet_id);
    }
}
