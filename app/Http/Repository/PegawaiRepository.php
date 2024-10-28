<?php

namespace App\Http\Repository;

use App\Models\Pegawai;

class PegawaiRepository
{
    public function get($outlet_id)
    {

    }

    public function create($data): void
    {
        Pegawai::create($data);
    }
}
