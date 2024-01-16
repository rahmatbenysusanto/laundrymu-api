<?php

namespace App\Http\Services;

use App\Http\Repository\HistoriStatusTransaksiRepository;
use App\Http\Repository\PelangganHasTransaksiRepository;
use App\Http\Repository\StatusTransaksiHasTokoRepository;
use App\Http\Repository\TransaksiDetailRepository;
use App\Http\Repository\TransaksiHasTokoRepository;
use App\Http\Repository\TransaksiRepository;

class TransaksiService
{
    public function __construct(
        protected TransaksiRepository $transaksiRepository,
        protected TransaksiDetailRepository $transaksiDetailRepository,
        protected NotificationService $notificationService,
        protected PelangganService $pelangganService,
        protected HistoriStatusTransaksiRepository $historiStatusTransaksiRepository,
        protected PelangganHasTransaksiRepository $pelangganHasTransaksiRepository,
        protected StatusTransaksiHasTokoRepository $statusTransaksiHasTokoRepository,
        protected TransaksiHasTokoRepository $transaksiHasTokoRepository
    ) {}

    public function list($toko_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->transaksiRepository->getByTokoId($toko_id);
    }

    public function getHistoryByTokoId($toko_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->transaksiRepository->getHistoryByTokoId($toko_id);
    }

    public function findByOrderNumber($order_number): array
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

        $this->historiStatusTransaksiRepository->create([
            'transaksi_id'  => $transaksi->id,
            'status'        => 'baru',
            'keterangan'    => 'Pelanggan datang & menyerahkan cucian ke petugas laundry'
        ]);

        $this->pelangganHasTransaksiRepository->increment($request->pelanggan_id);
        $this->pelangganHasTransaksiRepository->incrementNominal($request->pelanggan_id, $request->total_harga);

        $this->statusTransaksiHasTokoRepository->increment($request->toko_id, 'baru');

        $transaksiHasToko = $this->transaksiHasTokoRepository->findByTokoIdAndDate($request->toko_id, date('m', time()));
        if ($transaksiHasToko != null) {
            $this->transaksiHasTokoRepository->increment($transaksiHasToko->id, 'jumlah_transaksi', 1);
            $this->transaksiHasTokoRepository->increment($transaksiHasToko->id, 'nominal_transaksi', $request->total_harga);
        } else {
            $this->transaksiHasTokoRepository->create([
                'toko_id'           => $request->toko_id,
                'jumlah_transaksi'  => 1,
                'nominal_transaksi' => $request->total_harga
            ]);
        }

        $pelanggan = $this->pelangganService->findById($request->pelanggan_id);
        $this->notificationService->whatsAppNotification($pelanggan->no_hp, '');
    }

    public function prosesTransaksi($order_number, $status): void
    {
         $this->transaksiRepository->updateByOrderId($order_number, ['status' => $status]);
         $transaksi = $this->transaksiRepository->findByOrderNumber($order_number);

         $data = [];
         switch ($status) {
             case "diproses":
                 $data = [
                     'transaksi_id'     => $transaksi->id,
                     'status'           => 'diproses',
                     'keterangan'       => 'Laundry sudah dimasukkan ke mesin cuci'
                 ];
                 $this->statusTransaksiHasTokoRepository->decrement($transaksi->toko_id, 'baru');
                 $this->statusTransaksiHasTokoRepository->increment($transaksi->toko_id, 'diproses');
                 break;
             case "selesai":
                 $data = [
                     'transaksi_id'     => $transaksi->id,
                     'status'           => 'selesai',
                     'keterangan'       => 'Proses laundry sudah selesai, menunggu pelanggan mengambil laundry'
                 ];
                 $this->statusTransaksiHasTokoRepository->decrement($transaksi->toko_id, 'diproses');
                 $this->statusTransaksiHasTokoRepository->increment($transaksi->toko_id, 'selesai');
                 break;
             case "diambil":
                 $data = [
                     'transaksi_id'     => $transaksi->id,
                     'status'           => 'diambil',
                     'keterangan'       => 'Laundry sudah diambil oleh pelanggan & transaksi selesai'
                 ];
                 $this->statusTransaksiHasTokoRepository->decrement($transaksi->toko_id, 'selesai');
                 break;
         }

         $this->historiStatusTransaksiRepository->create($data);
    }
}
