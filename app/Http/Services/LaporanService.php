<?php

namespace App\Http\Services;

use App\Http\Repository\LaporanRepository;

class LaporanService
{
    public function __construct(
        protected LaporanRepository $laporanRepository
    ) {}

    public function findById($userId)
    {
        return $this->laporanRepository->findByUserId($userId);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->laporanRepository->getAll();
    }

    public function updateStatus($id, $data): void
    {
        $this->laporanRepository->update($id, [
            'status'    => $data->status
        ]);
    }

    public function create($data): void
    {
        $this->laporanRepository->create([
            'user_id'   => $data->user_id,
            'kategori'  => $data->kategori,
            'laporan'   => $data->laporan,
            'status'    => 'new'
        ]);
    }
}
