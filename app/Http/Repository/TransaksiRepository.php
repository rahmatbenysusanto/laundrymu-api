<?php

namespace App\Http\Repository;

use App\Models\Diskon;
use App\Models\Transaksi;
use Carbon\Carbon;

class TransaksiRepository
{
    public function countByDiskon($diskon_id)
    {
        return Transaksi::where('diskon_id', $diskon_id)->count();
    }

    public function countByPengiriman($pengiriman_id)
    {
        return Transaksi::where('pengiriman_id', $pengiriman_id)->count();
    }

    public function countByPelanggan($pelanggan_id)
    {
        return Transaksi::where('pelanggan_id', $pelanggan_id)->count();
    }

    public function countByPembayaran($pembayaran_id)
    {
        return Transaksi::where('pembayaran_id', $pembayaran_id)->count();
    }

    public function getByTokoId($toko_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return Transaksi::with(['pelanggan' => function ($pelanggan) {
                $pelanggan->select([
                    'id',
                    'nama',
                    'no_hp'
                ]);
                }, 'pembayaran' => function ($pembayaran) {
                    $pembayaran->select([
                        'id',
                        'nama'
                    ]);
                }, 'pengiriman' => function ($pengiriman) {
                    $pengiriman->select([
                        'id',
                        'nama',
                        'harga'
                    ]);
                }, 'transaksiDetail' => function ($transaksiDetail) {
                    $transaksiDetail->select([
                        'id',
                        'transaksi_id',
                        'layanan_id'
                    ]);
                }, 'transaksiDetail.layanan' => function ($layanan) {
                    $layanan->select([
                       'id',
                       'nama'
                    ]);
                }
            ])
            ->where('toko_id', $toko_id)
            ->whereIn('status', ['baru', 'diproses', 'selesai'])
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function getTransaksiByStatus($toko_id, $status): \Illuminate\Database\Eloquent\Collection|array
    {
        return Transaksi::with(['pelanggan' => function ($pelanggan) {
            $pelanggan->select([
                'id',
                'nama',
                'no_hp'
            ]);
        }, 'pembayaran' => function ($pembayaran) {
            $pembayaran->select([
                'id',
                'nama'
            ]);
        }, 'pengiriman' => function ($pengiriman) {
            $pengiriman->select([
                'id',
                'nama',
                'harga'
            ]);
        }, 'transaksiDetail' => function ($transaksiDetail) {
            $transaksiDetail->select([
                'id',
                'transaksi_id',
                'layanan_id'
            ]);
        }, 'transaksiDetail.layanan' => function ($layanan) {
            $layanan->select([
                'id',
                'nama'
            ]);
        }
        ])
            ->where('created_at', '>', date('Y-m-d H:i:s', strtotime("-7 days")))
            ->where('toko_id', $toko_id)
            ->where('status', $status)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function getHistoryByTokoId($toko_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return Transaksi::with(['pelanggan' => function ($pelanggan) {
            $pelanggan->select([
                'id',
                'nama',
                'no_hp'
            ]);
        }, 'pembayaran' => function ($pembayaran) {
            $pembayaran->select([
                'id',
                'nama'
            ]);
        }, 'pengiriman' => function ($pengiriman) {
            $pengiriman->select([
                'id',
                'nama',
                'harga'
            ]);
        },
        ])
            ->where('toko_id', $toko_id)
            ->where('created_at', '>=', Carbon::today()->subDays(30))
            ->whereIn('status', ['diambil'])
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function findByOrderNumber($order_number)
    {
        return Transaksi::with(['pelanggan' => function ($pelanggan) {
            $pelanggan->select([
                'id',
                'nama',
                'no_hp'
            ]);
        }, 'pembayaran' => function ($pembayaran) {
            $pembayaran->select([
                'id',
                'nama'
            ]);
        }, 'pengiriman' => function ($pengiriman) {
            $pengiriman->select([
                'id',
                'nama',
                'harga'
            ]);
        },
            'historiStatusTransaksi'
        ])
            ->where('order_number', $order_number)->first();
    }

    public function create($data)
    {
        return Transaksi::create($data);
    }

    public function updateByOrderId($order_id, $data): void
    {
        Transaksi::where('order_number', $order_id)->update($data);
    }

    public function jumlahTransaksiHarian($toko_id)
    {
        return Transaksi::where('toko_id', $toko_id)
            ->whereDay('created_at', date('d', time()))
            ->whereMonth('created_at', date('m', time()))
            ->whereYear('created_at', date('Y', time()))
            ->count();
    }

    public function jumlahNominalHarian($toko_id)
    {
        return Transaksi::where('toko_id', $toko_id)
            ->whereDay('created_at', date('d', time()))
            ->whereMonth('created_at', date('m', time()))
            ->whereYear('created_at', date('Y', time()))
            ->sum('total_harga');
    }

    public function countTransaksiByStatusHariIni($toko_id, $status)
    {
        return Transaksi::where('status', $status)
            ->where('toko_id', $toko_id)
            ->whereDate('created_at', date('Y-m-d', time()))
            ->count();
    }

    public function countTransaksiByStatusByDate($toko_id, $status, $start, $finish)
    {
        return Transaksi::where('status', $status)
            ->where('toko_id', $toko_id)
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $finish)
            ->count();
    }

    public function countDiskon($toko_id, $diskon_id)
    {
        return Transaksi::where('toko_id', $toko_id)
            ->where('diskon_id', $diskon_id)
            ->whereDate('created_at', date('Y-m-d', time()))
            ->count();
    }

    public function countPembayaran($toko_id, $pembayaran_id)
    {
        return Transaksi::where('toko_id', $toko_id)
            ->where('pembayaran_id', $pembayaran_id)
            ->whereDate('created_at', date('Y-m-d', time()))
            ->count();
    }
}
