<?php

namespace App\Http\Repository;

use App\Models\Transaksi;

class TransaksiRepository
{
    public function create($data)
    {
        return Transaksi::create($data);
    }

    public function findById($id)
    {
        return Transaksi::with('pelanggan')->where('id', $id)->first();
    }

    public function updateStatus($id, $status): void
    {
        Transaksi::where('id', $id)->update(['status' => $status]);
    }
}
