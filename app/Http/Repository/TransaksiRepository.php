<?php

namespace App\Http\Repository;

use App\Models\Transaksi;
use Carbon\Carbon;

class TransaksiRepository
{
    public function create($data)
    {
        return Transaksi::create($data);
    }

    public function findById($id)
    {
        return Transaksi::with('pelanggan')->where('id', $id)->first();
    }

    public function updateStatus($id, $status): void
    {
        Transaksi::where('id', $id)->update(['status' => $status]);
    }

    public function jumlahTransaksi($outlet_id, $start_date, $end_date)
    {
        return Transaksi::where('outlet_id', $outlet_id)
            ->where('created_at', '>=', $start_date)
            ->where('created_at', '<=', $end_date)
            ->count();
    }

    public function nominalTransaksi($outlet_id, $start_date, $end_date)
    {
        return Transaksi::where('outlet_id', $outlet_id)
            ->where('created_at', '>=', $start_date)
            ->where('created_at', '<=', $end_date)
            ->sum('total_harga');
    }

    public function listTransaksi($outlet_id, $status): \Illuminate\Database\Eloquent\Collection
    {
        return Transaksi::with('pelanggan', 'pembayaran', 'transaksiDetail', 'transaksiDetail.layanan')
            ->where('outlet_id', $outlet_id)
            ->whereIn('status', $status)
            ->orderBy('created_at', 'DESC')->get();
    }
}
