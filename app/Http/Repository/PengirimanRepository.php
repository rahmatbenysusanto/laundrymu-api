<?php

namespace App\Http\Repository;

use App\Models\Pengiriman;

class PengirimanRepository
{
    public function findByToko($toko_id)
    {
        return Pengiriman::where('toko_id', $toko_id)->get();
    }

    public function findById($id)
    {
        return Pengiriman::where('id', $id)->first();
    }

    public function create($data): void
    {
        Pengiriman::create($data);
    }

    public function edit($id, $data): void
    {
        Pengiriman::where('id', $id)->update($data);
    }

    public function delete($id): void
    {
        Pengiriman::where('id', $id)->delete();
    }
}
