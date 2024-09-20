<?php

namespace App\Http\Service;

use App\Http\Repository\PembayaranRepository;

class PembayaranService
{
    public function __construct(
        protected PembayaranRepository $pembayaranRepository
    ) {}

    public function create($request): void
    {
        $this->pembayaranRepository->create([
            'outlet_id' => $request->outlet_id,
            'nama'      => $request->nama,
        ]);
    }

    public function findById($id)
    {
        return $this->pembayaranRepository->findById($id);
    }

    public function findByOutletId($outlet_id)
    {
        return $this->pembayaranRepository->findByOutletId($outlet_id);
    }

    public function update($id, $request): void
    {
        $this->pembayaranRepository->update($id, [
            'nama'  => $request->nama,
        ]);
    }

    public function delete($id): void
    {
        $this->pembayaranRepository->delete($id);
    }
}
