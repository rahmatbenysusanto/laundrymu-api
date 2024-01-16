<?php

namespace App\Http\Repository;

use App\Models\TransaksiHasToko;

class TransaksiHasTokoRepository
{
    public function create($data): void
    {
        TransaksiHasToko::create($data);
    }

    public function findByTokoIdAndDate($toko_id, $month)
    {
        return TransaksiHasToko::where('toko_id', $toko_id)
            ->whereMonth('waktu', $month)
            ->whereYear('waktu', date('Y', time()))
            ->first();
    }

    public function increment($id, $column, $value): void
    {
        TransaksiHasToko::where('id', $id)->increment($column, $value);
    }

    public function findByTokoIdAndMonth($toko_id)
    {
        return TransaksiHasToko::where('toko_id', $toko_id)
            ->whereMonth('waktu', date('m', time()))
            ->first();
    }
}
