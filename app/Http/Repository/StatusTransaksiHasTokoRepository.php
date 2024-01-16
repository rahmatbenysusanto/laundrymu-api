<?php

namespace App\Http\Repository;

use App\Models\StatusTransaksiHasToko;

class StatusTransaksiHasTokoRepository
{
    public function create($data): void
    {
        StatusTransaksiHasToko::create($data);
    }

    public function findByTokoId($toko_id)
    {
        return StatusTransaksiHasToko::where('toko_id', $toko_id)->first();
    }

    public function increment($toko_id, $column): void
    {
        StatusTransaksiHasToko::where('toko_id', $toko_id)->increment($column);
    }

    public function decrement($toko_id, $column): void
    {
        StatusTransaksiHasToko::where('toko_id', $toko_id)->decrement($column);
    }
}
