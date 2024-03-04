<?php

namespace App\Http\Repository;

use App\Models\Penggunaan;

class PenggunaanRepository
{
    public function create($data): void
    {
        Penggunaan::create($data);
    }

    public function findByTokoId($tokoId): \Illuminate\Database\Eloquent\Collection|array
    {
        return Penggunaan::with(['barang' => function ($barang) {
            $barang->select([
                'id',
                'nama'
            ]);
        }])
            ->where('toko_id', $tokoId)
            ->orderBy('id', 'DESC')
            ->get();
    }
}
