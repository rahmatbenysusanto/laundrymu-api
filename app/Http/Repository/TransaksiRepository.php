<?php

namespace App\Http\Repository;

use App\Models\Diskon;
use App\Models\Transaksi;

class TransaksiRepository
{
    public function countByDiskon($diskon_id)
    {
        return Transaksi::where('diskon_id', $diskon_id)->count();
    }

    public function countByPengiriman($pengiriman_id)
    {
        return Transaksi::where('pengiriman_id', $pengiriman_id)->count();
    }
}
