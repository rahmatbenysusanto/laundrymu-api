<?php

namespace App\Http\Service;

use App\Http\Repository\LayananRepository;

class LayananService
{
    public function __construct(
        protected LayananRepository $layananRepository
    ) {}

    public function findById($id)
    {
        return $this->layananRepository->findById($id);
    }

    public function getByOutletId($outlet_id)
    {
        return $this->layananRepository->getByOutletId($outlet_id);
    }

    public function create($request): void
    {
        $this->layananRepository->create([
            'outlet_id'     => $request->outlet_id,
            'nama'          => $request->nama,
            'type'          => $request->type,
            'harga'         => $request->harga,
            'delete'        => 0,
            'created_at'    => now()->timestamp * 1000,
            'updated_at'    => now()->timestamp * 1000,
        ]);
    }

    public function update($id, $request): void
    {
        $this->layananRepository->update($id, [
            'nama'          => $request->nama,
            'type'          => $request->type,
            'harga'         => $request->harga,
            'updated_at'    => now()->timestamp * 1000,
        ]);
    }

    public function delete($id): void
    {
        $this->layananRepository->delete($id);
    }
}
