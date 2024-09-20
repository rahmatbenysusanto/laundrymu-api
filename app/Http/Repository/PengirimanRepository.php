<?php

namespace App\Http\Repository;

use App\Models\Pengiriman;

class PengirimanRepository
{
    public function create($data): void
    {
        Pengiriman::create($data);
    }
}
