<?php

namespace App\Http\Repository;

use App\Models\TransaksiHasOutlet;

class TransaksiHasOutletRepository
{
    public function create($data): void
    {
        TransaksiHasOutlet::create($data);
    }

    public function findByOutletId($outletId)
    {
        return TransaksiHasOutlet::where('outlet_id', $outletId)
            ->whereMonth('waktu', now()->month)
            ->whereYear('waktu', now()->year)
            ->first();
    }

    public function increment($id, $nominal): void
    {
        TransaksiHasOutlet::where('id', $id)
            ->increment('jumlah_transaksi');

        TransaksiHasOutlet::where('id', $id)
            ->increment('nominal_transaksi', $nominal);

        TransaksiHasOutlet::where('id', $id)
            ->update([
                'updated_at' => now()->timestamp * 1000
            ]);

    }

    public function decrement($id, $nominal): void
    {
        TransaksiHasOutlet::where('id', $id)
            ->decrement('jumlah_transaksi', 1);

        TransaksiHasOutlet::where('id', $id)
            ->decrement('nominal_transaksi', $nominal);

        TransaksiHasOutlet::where('id', $id)
            ->update([
                'updated_at' => now()->timestamp * 1000
            ]);

    }
}
