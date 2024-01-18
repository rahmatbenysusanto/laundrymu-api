<?php

namespace App\Http\Repository;

use App\Models\Lisensi;

class LisensiRepository
{
    public function get(): \Illuminate\Database\Eloquent\Collection
    {
        return Lisensi::all();
    }

    public function findById($id)
    {
        return Lisensi::where('id', $id)->first();
    }
}
