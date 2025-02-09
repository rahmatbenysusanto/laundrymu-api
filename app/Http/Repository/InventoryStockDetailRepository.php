<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;

class InventoryStockDetailRepository
{
    public function create($data): void
    {
        DB::table('inv_stock_detail')->insert($data);
    }
}
