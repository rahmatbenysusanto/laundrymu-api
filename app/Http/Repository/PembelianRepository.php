<?php

namespace App\Http\Repository;

use App\Models\Pembelian;

class PembelianRepository
{
    public function create($data): void
    {
        Pembelian::create($data);
    }

    public function findByTokoId($tokoId): \Illuminate\Database\Eloquent\Collection|array
    {
        return Pembelian::with(['barang' => function ($barang) {
            $barang->select([
                'id',
                'nama'
            ]);
        }])
            ->where('toko_id', $tokoId)
            ->get();
    }
}
