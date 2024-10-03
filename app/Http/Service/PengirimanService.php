<?php

namespace App\Http\Service;

use App\Http\Repository\PengirimanRepository;

class PengirimanService
{
    public function __construct(
        protected PengirimanRepository $pengirimanRepository
    ) {}

    public function create($request): void
    {
        $this->pengirimanRepository->create([
            'outlet_id'     => $request->outlet_id,
            'nama'          => $request->nama,
            'harga'         => $request->harga,
            'created_at'    => now()->timestamp * 1000,
            'updated_at'    => now()->timestamp * 1000,
        ]);
    }

    public function findById($id)
    {
        return $this->pengirimanRepository->findById($id);
    }

    public function findByOutletId($outlet_id)
    {
        return $this->pengirimanRepository->findByOutletId($outlet_id);
    }

    public function update($id, $request): void
    {
        $this->pengirimanRepository->update($id, [
            'nama'          => $request->nama,
            'harga'         => $request->harga,
        ]);
    }

    public function delete($id): void
    {
        $this->pengirimanRepository->delete($id);
    }
}
