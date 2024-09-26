<?php

namespace App\Http\Service;

use App\Http\Repository\ParfumRepository;
use App\Models\Parfum;

class ParfumService
{
    public function __construct(
        protected ParfumRepository $parfumRepository
    ) {}

    public function create($request): void
    {
        $this->parfumRepository->create([
            'nama'      => $request->nama,
            'harga'     => $request->harga,
            'outlet_id' => $request->outlet_id,
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);
    }

    public function findById($id)
    {
        return $this->parfumRepository->findById($id);
    }

    public function findByOutletId($outlet_id)
    {
        return $this->parfumRepository->findByOutletId($outlet_id);
    }

    public function update($id, $request): void
    {
        $this->parfumRepository->update($id, [
            'nama'      => $request->nama,
            'harga'     => $request->harga,
            'updated_at'=> now()->timestamp * 1000
        ]);
    }

    public function delete($id): void
    {
        $this->parfumRepository->update($id, [
            'delete'    => 1
        ]);
    }
}
