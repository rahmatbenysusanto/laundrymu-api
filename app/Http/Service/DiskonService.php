<?php

namespace App\Http\Service;

use App\Http\Repository\DiskonRepository;

class DiskonService
{
    public function __construct(
        protected DiskonRepository $diskonRepository
    ) {}

    public function findById($id)
    {
        return $this->diskonRepository->find($id);
    }

    public function getByOutletId($outlet_id)
    {
        return $this->diskonRepository->getByOutletId($outlet_id);
    }

    public function create($request): void
    {
        $this->diskonRepository->create([
            'outlet_id' => $request->outlet_id,
            'nama'      => $request->nama,
            'type'      => $request->type,
            'nominal'   => $request->nominal,
            'delete'    => 0,
            'created_at'=> now()->timestamp * 10000,
            'updated_at'=> now()->timestamp * 10000
        ]);
    }

    public function update($id, $request): void
    {
        $this->diskonRepository->update($id, [
            'nama'      => $request->nama,
            'type'      => $request->type,
            'nominal'   => $request->nominal,
            'updated_at'=> now()->timestamp * 10000
        ]);
    }

    public function delete($id): void
    {
        $this->diskonRepository->update($id, [
            'delete'    => 1,
        ]);
    }
}
