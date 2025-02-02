<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;

class PembelianBarangDetailRepository
{
    public function create($data): void
    {
        DB::table('inv_pembelian_barang_detail')->insert($data);
    }
}
