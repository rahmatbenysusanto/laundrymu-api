<?php

namespace App\Http\Repository;

use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\DB;

class TransaksiDetailRepository
{
    public function countByLayanan($layanan_id)
    {
        return TransaksiDetail::where('layanan_id', $layanan_id)->count();
    }

    public function create($data)
    {
        return TransaksiDetail::create($data);
    }

    public function findByTransaksiId($transaksi_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return TransaksiDetail::with('layanan', 'parfum')->where('transaksi_id', $transaksi_id)->get();
    }

    public function countParfum($toko_id, $id): int
    {
        return DB::table('transaksi_detail')
            ->whereDate('transaksi_detail.created_at', date('Y-m-d', time()))
            ->leftJoin('transaksi', 'transaksi.id', '=', 'transaksi_detail.transaksi_id')
            ->where('transaksi.toko_id', $toko_id)
            ->groupBy('transaksi.id')
            ->where('transaksi_detail.parfum_id', $id)
            ->count();
    }

    public function countLayanan($toko_id, $layanan_id): int
    {
        return DB::table('transaksi_detail')
            ->whereDate('transaksi_detail.created_at', date('Y-m-d', time()))
            ->leftJoin('transaksi', 'transaksi.id', '=', 'transaksi_detail.transaksi_id')
            ->where('transaksi.toko_id', $toko_id)
            ->where('transaksi_detail.layanan_id', $layanan_id)
            ->count();
    }
}
