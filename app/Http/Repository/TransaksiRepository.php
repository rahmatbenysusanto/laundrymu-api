<?php

namespace App\Http\Repository;

use App\Models\Diskon;

class TransaksiRepository
{
    public function countByDiskon($diskon_id)
    {
        return Diskon::where('diskon_id', $diskon_id)->count();
    }
}
