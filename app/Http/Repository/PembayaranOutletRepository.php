<?php

namespace App\Http\Repository;

use App\Models\PembayaranOutlet;

class PembayaranOutletRepository
{
    public function findByUserId($user_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return PembayaranOutlet::with(['toko' => function ($toko) {
            $toko->select([
                'id',
                'nama',
                'no_hp'
            ]);
        }, 'user' => function ($user) {
            $user->select([
                'id',
                'nama',
                'no_hp'
            ]);
        }, 'lisensi' => function ($lisensi) {
            $lisensi->select([
                'id',
                'nama',
                'durasi',
                'harga'
            ]);
        }, 'pembayaran' => function ($pembayaran) {
            $pembayaran->select([
                'id',
                'metode_pembayaran',
                'nama',
                'nomor',
                'logo'
            ]);
        }])->where('user_id', $user_id)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function findAll(): \Illuminate\Database\Eloquent\Collection|array
    {
        return PembayaranOutlet::with(['toko' => function ($toko) {
            $toko->select([
                'id',
                'nama',
                'no_hp'
            ]);
        }, 'user' => function ($user) {
            $user->select([
                'id',
                'nama',
                'no_hp'
            ]);
        }, 'lisensi' => function ($lisensi) {
            $lisensi->select([
                'id',
                'nama',
                'durasi',
                'harga'
            ]);
        }, 'pembayaran' => function ($pembayaran) {
            $pembayaran->select([
                'id',
                'metode_pembayaran',
                'nama',
                'nomor',
                'logo'
            ]);
        }])
            ->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 months')))
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function update($id, $data): void
    {
        PembayaranOutlet::where('id', $id)->update($data);
    }

    public function create($data)
    {
        return PembayaranOutlet::create($data);
    }

    public function findByNomorPembayaran($nomor_pembayaran)
    {
        return PembayaranOutlet::with(['toko' => function ($toko) {
            $toko->select([
                'id',
                'nama',
                'no_hp',
                'expired',
                'alamat'
            ]);
        }, 'user' => function ($user) {
            $user->select([
                'id',
                'nama',
                'no_hp'
            ]);
        }, 'lisensi' => function ($lisensi) {
            $lisensi->select([
                'id',
                'nama',
                'durasi',
                'harga'
            ]);
        }, 'pembayaran' => function ($pembayaran) {
            $pembayaran->select([
                'id',
                'metode_pembayaran',
                'nama',
                'nomor',
                'logo'
            ]);
        }])->where('nomor_pembayaran', $nomor_pembayaran)->first();
    }

    public function findById($id)
    {
        return PembayaranOutlet::where('id', $id)->first();
    }
}
