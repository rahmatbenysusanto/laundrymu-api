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

    public function create($data): void
    {
        Layanan::create($data);
    }

    public function edit($id, $data): void
    {
        Layanan::where('id', $id)->update($data);
    }

    public function delete($id): void
    {
        Layanan::where('id', $id)->delete();
    }
}
