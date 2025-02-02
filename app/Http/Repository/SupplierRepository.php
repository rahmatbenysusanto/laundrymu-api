<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;

class SupplierRepository
{
    public function create($data): void
    {
        DB::table('inv_suppliers')->insert($data);
    }

    public function findByOutletId($outlet_id): \Illuminate\Support\Collection
    {
        return DB::table('inv_supplier')->where('outlet_id', $outlet_id)->get();
    }
}
