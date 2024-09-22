<?php

namespace App\Http\Repository;

use App\Models\Lisensi;

class LisensiRepository
{
    public function find($id)
    {
        return Lisensi::find($id);
    }
}
