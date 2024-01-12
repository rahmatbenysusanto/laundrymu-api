<?php

namespace App\Http\Repository;

use App\Models\Pelanggan;

class PelangganRepository
{
    public function findByToko($toko_id)
    {
        return Pelanggan::where('toko_id', $toko_id)->get();
    }

    public function findById($id)
    {
        return Pelanggan::where('id', $id)->first();
    }

    public function create($data)
    {
        return Pelanggan::create($data);
    }

    public function edit($id, $data): void
    {
        Pelanggan::where('id', $id)->update($data);
    }

    public function delete($id): void
    {
        Pelanggan::where('id', $id)->delete();
    }
}
