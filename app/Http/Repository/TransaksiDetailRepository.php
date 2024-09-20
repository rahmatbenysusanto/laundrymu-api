<?php

namespace App\Http\Repository;

use App\Models\TransaksiDetail;

class TransaksiDetailRepository
{
    public function create($data): void
    {
        TransaksiDetail::create($data);
    }

    public function findByTransaksiId($transaksi_id): \Illuminate\Database\Eloquent\Collection
    {
        return TransaksiDetail::with('layanan')->where('transaksi_id', $transaksi_id)->get();
    }
}
