<?php

namespace App\Http\Repository;

use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class BarangRepository
{
    public function findByTokoId($tokoId)
    {
        return Barang::where('toko_id', $tokoId)->get();
    }

    public function create($data)
    {
        return Barang::create($data);
    }

    public function findById($id)
    {
        return Barang::where('id', $id)->first();
    }

    public function getStokByTokoId($tokoId): \Illuminate\Support\Collection
    {
        return DB::table('barang')
            ->leftJoin('inventory', 'inventory.barang_id', '=', 'barang.id')
            ->where('barang.toko_id', $tokoId)
            ->select([
                "barang.*",
                "inventory.stok"
            ])
            ->get();
    }
}
