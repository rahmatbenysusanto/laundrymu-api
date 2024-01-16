<?php

namespace App\Http\Repository;

use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;

class PelangganRepository
{
    public function findByToko($toko_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return Pelanggan::with('pelangganHasTransaksi')->where('toko_id', $toko_id)->get();
    }

    public function findById($id)
    {
        return Pelanggan::with('pelangganHasTransaksi')->where('id', $id)->first();
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

    public function getTopPelangganBulanan($toko_id): \Illuminate\Support\Collection
    {
        return DB::table('pelanggan')
            ->select([
                'pelanggan.nama',
                'pelanggan.no_hp',
                'pelanggan_has_transaksi.jumlah_transaksi',
                'pelanggan_has_transaksi.jumlah_transaksi_bulanan',
                'pelanggan_has_transaksi.nominal_transaksi',
                'pelanggan_has_transaksi.nominal_transaksi_bulanan'
            ])
            ->leftJoin('pelanggan_has_transaksi', 'pelanggan_has_transaksi.pelanggan_id', '=', 'pelanggan.id')
            ->where('pelanggan.toko_id', $toko_id)
            ->orderBy('pelanggan_has_transaksi.jumlah_transaksi_bulanan', 'DESC')
            ->limit(10)
            ->get();
    }
}
