<?php

namespace App\Http\Repository;

use App\Models\Pelanggan;

class PelangganRepository
{
    public function create($data)
    {
        return Pelanggan::create($data);
    }

    public function findById($id)
    {
        return Pelanggan::find('id', $id);
    }

    public function getByOutletId($outlet_id)
    {
        return Pelanggan::where('outlet_id', $outlet_id)->get();
    }

    public function update($id, $data): void
    {
        Pelanggan::where('id', $id)->update($data);
    }
}
