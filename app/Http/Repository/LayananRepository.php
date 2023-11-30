<?php

namespace App\Http\Repository;

use App\Models\Layanan;

class LayananRepository
{
    public function findByToko($toko_id)
    {
        return Layanan::where('toko_id', $toko_id)->get();
    }

    public function findById($id)
    {
        return Layanan::where('id', $id)->first();
    }
}
