<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;

class BarangRepository
{
    public function create($data): int
    {
        return DB::table('inv_barang')->insertGetId($data);
    }
}
