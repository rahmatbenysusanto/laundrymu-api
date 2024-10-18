<?php

namespace App\Http\Repository;

use App\Models\TransaksiDetail;

class TransaksiDetailRepository
{
    public function create($data): void
    {
        TransaksiDetail::create($data);
    }

    public function findByTransaksiId($transaksi_id): \Illuminate\Database\Eloquent\Collection
    {
        return TransaksiDetail::with('layanan')->where('transaksi_id', $transaksi_id)->get();
    }

    public function countLayananByOutletId($outlet_id, $layanan_id, $start_date, $end_date)
    {
        return TransaksiDetail::leftJoin('transaksi', 'transaksi.id', '=', 'transaksi_detail.transaksi_id')
            ->where('transaksi.outlet_id', $outlet_id)
            ->where('transaksi_detail.layanan_id', $layanan_id)
            ->where('transaksi_detail.created_at', '>=', strtotime($start_date.' 00:00:00') * 1000)
            ->where('transaksi_detail.created_at', '<=', strtotime($end_date.' 23:59:59') * 1000)
            ->where('transaksi.status', '!=', 'batal')
            ->count();
    }

    public function countParfumByOutletId($outlet_id, $parfum_id, $start_date, $end_date)
    {
        return TransaksiDetail::leftJoin('transaksi', 'transaksi.id', '=', 'transaksi_detail.transaksi_id')
            ->where('transaksi.outlet_id', $outlet_id)
            ->where('transaksi_detail.parfum_id', $parfum_id)
            ->where('transaksi_detail.created_at', '>=', strtotime($start_date.' 00:00:00') * 1000)
            ->where('transaksi_detail.created_at', '<=', strtotime($end_date.' 23:59:59') * 1000)
            ->where('transaksi.status', '!=', 'batal')
            ->count();
    }
}
