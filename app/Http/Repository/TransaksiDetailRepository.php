<?php

namespace App\Http\Repository;

use App\Models\TransaksiDetail;

class TransaksiDetailRepository
{
    public function countByLayanan($layanan_id)
    {
        return TransaksiDetail::where('layanan_id', $layanan_id)->count();
    }

    public function create($data)
    {
        return TransaksiDetail::create($data);
    }

    public function findByTransaksiId($transaksi_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return TransaksiDetail::with('layanan', 'parfum')->where('transaksi_id', $transaksi_id)->get();
    }
}
