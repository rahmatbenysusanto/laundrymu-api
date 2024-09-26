<?php

namespace App\Http\Repository;

use App\Models\Layanan;

class LayananRepository
{
    public function create($data): void
    {
        Layanan::create($data);
    }

    public function findById($id)
    {
        return Layanan::where('id', $id)->first();
    }

    public function getByOutletId($outlet_id)
    {
        return Layanan::where('outlet_id', $outlet_id)
            ->where('delete', 0)
            ->get();
    }

    public function update($id, $data): void
    {
        Layanan::where('id', $id)->update($data);
    }

    public function delete($id): void
    {
        Layanan::where('id', $id)->update([
            'delete' => 1
        ]);
    }
}
