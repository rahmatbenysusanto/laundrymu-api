<?php

namespace App\Http\Repository;

use App\Models\HistoriStatusTransaksi;

class HistoriStatusTransaksiRepository
{
    public function create($data): void
    {
        HistoriStatusTransaksi::create($data);
    }

    public function findByTransaksiId($transaksi_id)
    {
        return HistoriStatusTransaksi::where('transaksi_id', $transaksi_id)->get();
    }
}
