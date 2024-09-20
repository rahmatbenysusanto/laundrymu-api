<?php

namespace App\Http\Service;

use App\Http\Repository\PelangganRepository;

class PelangganService
{
    public function __construct(
        protected PelangganRepository $pelangganRepository
    ) {}

    public function create($request)
    {
        return $this->pelangganRepository->create([
            'outlet_id' => $request->outlet_id,
            'nama'      => $request->nama,
            'no_hp'     => $request->no_hp
        ]);
    }

    public function findById($id)
    {
        return $this->pelangganRepository->findById($id);
    }

    public function getByOutletId($outlet_id)
    {
        return $this->pelangganRepository->getByOutletId($outlet_id);
    }

    public function update($id, $request): void
    {
        $this->pelangganRepository->update($id, [
            'nama'      => $request->nama,
            'no_hp'     => $request->no_hp
        ]);
    }
}
