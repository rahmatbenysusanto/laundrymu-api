<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;

class PembelianBarangRepository
{
    public function create($data): int
    {
        return DB::table('inv_pembelian_barang')->insertGetId($data);
    }
}
