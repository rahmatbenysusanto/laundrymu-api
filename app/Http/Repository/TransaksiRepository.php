<?php

namespace App\Http\Repository;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        Transaksi::where('id', $id)->update([
            'status'        => $status,
            'updated_at'    => now()->timestamp * 1000
        ]);
    }

    public function jumlahTransaksi($outlet_id, $start_date, $end_date)
    {
        return Transaksi::where('outlet_id', $outlet_id)
            ->where('created_at', '>=', $start_date)
            ->where('created_at', '<=', $end_date)
            ->where('status', '!=', 'batal')
            ->count();
    }

    public function nominalTransaksi($outlet_id, $start_date, $end_date)
    {
        return Transaksi::where('outlet_id', $outlet_id)
            ->where('created_at', '>=', $start_date)
            ->where('created_at', '<=', $end_date)
            ->where('status', '!=', 'batal')
            ->sum('total_harga');
    }

    public function listTransaksi($outlet_id, $status): \Illuminate\Database\Eloquent\Collection
    {
        return Transaksi::with('pelanggan', 'pembayaran', 'transaksiDetail', 'transaksiDetail.layanan')
            ->where('outlet_id', $outlet_id)
            ->whereIn('status', $status)
            ->orderBy('created_at', 'DESC')->get();
    }

    public function findTransaksi($orderNumber)
    {
        return Transaksi::with('pelanggan', 'pembayaran', 'transaksiDetail', 'transaksiDetail.layanan', 'transaksiDetail.parfum', 'pengiriman')
            ->where('order_number', $orderNumber)
            ->first();
    }

    public function transaksiHistory($orderNumber)
    {
        return Transaksi::with('transaksiHistory')
            ->where('order_number', $orderNumber)
            ->first();
    }

    public function jumlahTransaksiByStatus($outlet_id, $status, $start_date, $end_date)
    {
        return Transaksi::where('outlet_id', $outlet_id)
            ->where('updated_at', '>=', strtotime($start_date.' 00:00:00') * 1000)
            ->where('updated_at', '<=', strtotime($end_date.' 23:59:59') * 1000)
            ->whereIn('status', (array)$status)
            ->count();
    }

    public function countDiskonByOutletId($outlet_id, $diskon_id, $start_date, $end_date)
    {
        return Transaksi::where('outlet_id', $outlet_id)
            ->where('diskon_id', $diskon_id)
            ->where('created_at', '>=', strtotime($start_date.' 00:00:00') * 1000)
            ->where('created_at', '<=', strtotime($end_date.' 23:59:59') * 1000)
            ->where('status', '!=', 'batal')
            ->count();
    }

    public function countPembayaranByOutletId($outlet_id, $pembayaran_id, $start_date, $end_date)
    {
        return Transaksi::where('outlet_id', $outlet_id)
            ->where('pembayaran_id', $pembayaran_id)
            ->where('created_at', '>=', strtotime($start_date.' 00:00:00') * 1000)
            ->where('created_at', '<=', strtotime($end_date.' 23:59:59') * 1000)
            ->where('status', '!=', 'batal')
            ->count();
    }
}
