<?php

namespace App\Http\Repository;

use App\Models\Pembayaran;

class PembayaranRepository
{
    public function findById($id)
    {
        return Pembayaran::find($id);
    }

    public function findByOutletId($outlet_id)
    {
        return Pembayaran::where('outlet_id', $outlet_id)->get();
    }

    public function create($data)
    {
        return Pembayaran::create($data);
    }

    public function update($id, $data): void
    {
        Pembayaran::where('id', $id)->update($data);
    }

    public function delete($id): void
    {
        Pembayaran::where('id', $id)->update([
            'delete'    => 1
        ]);
    }
}
