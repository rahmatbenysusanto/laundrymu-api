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
        return Pengiriman::where('outlet_id', $outlet_id)->get();
    }
}
