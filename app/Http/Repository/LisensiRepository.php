<?php

namespace App\Http\Repository;

use App\Models\Lisensi;

class LisensiRepository
{
    public function find($id)
    {
        return Lisensi::find($id);
    }

    public function get(): \Illuminate\Database\Eloquent\Collection
    {
        return Lisensi::all();
    }
}
