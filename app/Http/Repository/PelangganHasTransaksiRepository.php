<?php

namespace App\Http\Repository;

use App\Models\PelangganHasTransaksi;

class PelangganHasTransaksiRepository
{
    public function create($data): void
    {
        PelangganHasTransaksi::create($data);
    }

    public function update($pelanggan_id, $data): void
    {
        PelangganHasTransaksi::where('pelanggan_id', $pelanggan_id)->update($data);
    }

    public function increment($pelanggan_id): void
    {
        PelangganHasTransaksi::where('pelanggan_id', $pelanggan_id)->incrementEach([
            'jumlah_transaksi'          => 1,
            'jumlah_transaksi_bulanan'  => 1
        ]);
    }

    public function incrementNominal($pelanggan_id, $nominal): void
    {
        PelangganHasTransaksi::where('pelanggan_id', $pelanggan_id)->incrementEach([
            'nominal_transaksi'          => $nominal,
            'nominal_transaksi_bulanan'  => $nominal
        ]);
    }
}
