<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;

class SatuanRepository
{
    public function all(): \Illuminate\Support\Collection
    {
        return DB::table('inv_satuan')->get();
    }
}
