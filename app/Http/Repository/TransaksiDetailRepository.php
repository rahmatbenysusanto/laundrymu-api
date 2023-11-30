<?php

namespace App\Http\Repository;

use App\Models\TransaksiDetail;

class TransaksiDetailRepository
{
    public function countByLayanan($layanan_id)
    {
        return TransaksiDetail::where('layanan_id', $layanan_id)->count();
    }
}
