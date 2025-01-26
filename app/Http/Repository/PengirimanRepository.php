<?php

namespace App\Http\Repository;

use App\Models\Pengiriman;

class PengirimanRepository
{
    public function create($data): void
    {
        Pengiriman::create($data);
    }

    public function findByOutletId($outlet_id)
    {
        return Pengiriman::where('outlet_id', $outlet_id)->where('delete', 0)->get();
    }

    public function findById($id)
    {
        return Pengiriman::where('id', $id)->where('delete', 0)->first();
    }

    public function delete($id): void
    {
        Pengiriman::where('id', $id)->update([
            'delete'    => 1
        ]);
    }

    public function update($id, $data): void
    {
        Pengiriman::where('id', $id)->update($data);
    }
}
