<?php

namespace App\Http\Repository;

use App\Models\Pembayaran;

class PembayaranRepository
{
    public function findByToko($toko_id)
    {
        return Pembayaran::where('toko_id', $toko_id)->get();
    }

    public function findById($id)
    {
        return Pembayaran::where('id', $id)->first();
    }

    public function create($data): void
    {
        Pembayaran::create($data);
    }

    public function edit($id, $data): void
    {
        Pembayaran::where('id', $id)->update($data);
    }

    public function delete($id): void
    {
        Pembayaran::where('id', $id)->delete();
    }
}
