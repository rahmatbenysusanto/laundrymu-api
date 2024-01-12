<?php

namespace App\Http\Services;

use App\Http\Repository\TransaksiDetailRepository;
use App\Http\Repository\TransaksiRepository;
use Illuminate\Database\Eloquent\Collection;

class TransaksiService
{
    public function __construct(
        protected TransaksiRepository $transaksiRepository,
        protected TransaksiDetailRepository $transaksiDetailRepository,
        protected NotificationService $notificationService,
        protected PelangganService $pelangganService
    ) {}

    public function list($toko_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->transaksiRepository->getByTokoId($toko_id);
    }

    public function getHistoryByTokoId($toko_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->transaksiRepository->getHistoryByTokoId($toko_id);
    }

    public function findByOrderNumber($order_number)
    {
        $transaksi = $this->transaksiRepository->findByOrderNumber($order_number);
        return [
            'transaksi' => $this->transaksiRepository->findByOrderNumber($order_number),
            'detail'    => $this->transaksiDetailRepository->findByTransaksiId($transaksi->id)
        ];
    }

    public function create($request): void
    {
        $transaksi = $this->transaksiRepository->create([
            "toko_id"           => $request->toko_id,
            "pelanggan_id"      => $request->pelanggan_id,
            "diskon_id"         => $request->diskon_id,
            "pengiriman_id"     => $request->pengiriman_id,
            "pembayaran_id"     => $request->pembayaran_id,
            "order_number"      => date('Ymdis').rand(100, 999),
            "status"            => "baru",
            "status_pembayaran" => $request->status_pembayaran,
            "harga"             => $request->harga,
            "harga_diskon"      => $request->harga_diskon,
            "total_harga"       => $request->total_harga
        ]);

        foreach ($request->layanan as $layanan) {
            $this->transaksiDetailRepository->create([
                'transaksi_id'  => $transaksi->id,
                'layanan_id'    => $layanan['id'],
                'parfum_id'     => $request->parfum_id,
                'jumlah'        => $layanan['jumlah'],
                'harga'         => $layanan['harga']
            ]);
        }

        $pelanggan = $this->pelangganService->findById($request->pelanggan_id);
        $this->notificationService->whatsAppNotification($pelanggan->no_hp, '');
    }
}
