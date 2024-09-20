<?php

namespace App\Http\Service;

use App\Http\Repository\TransaksiDetailRepository;
use App\Http\Repository\TransaksiHasOutletRepository;
use App\Http\Repository\TransaksiHistoryRepository;
use App\Http\Repository\TransaksiRepository;
use App\Jobs\NotificationJob;
use Illuminate\Support\Facades\Log;

class TransaksiService
{
    public function __construct(
        protected TransaksiRepository $transaksiRepository,
        protected TransaksiDetailRepository $transaksiDetailRepository,
        protected TransaksiHistoryRepository $transaksiHistoryRepository,
        protected TransaksiHasOutletRepository  $transaksiHasOutletRepository
    ) {}

    public function create($request): void
    {
        $transaksi = $this->transaksiRepository->create([
            'outlet_id'         => $request->outlet_id,
            'pelanggan_id'      => $request->pelanggan_id,
            'diskon_id'         => $request->diskon_id,
            'pengiriman_id'     => $request->pengiriman_id,
            'pembayaran_id'     => $request->pembayaran_id,
            'order_number'      => 'ORD-'.now()->format('Ymd').mt_rand(1000, 9999),
            'status'            => $request->status,
            'status_pembayaran'  => $request->status_pembayaran,
            'harga'             => $request->harga,
            'harga_diskon'      => $request->harga_diskon,
            'biaya_pengiriman'  => $request->biaya_pengiriman,
            'total_harga'       => $request->total_harga,
            'catatan'           => $request->catatan,
            'created_at'        => now()->timestamp * 1000,
            'updated_at'        => now()->timestamp * 1000,
        ]);

        foreach (json_decode(json_encode($request->detail)) as $detail) {
            $this->transaksiDetailRepository->create([
                'transaksi_id'  => $transaksi->id,
                'layanan_id'    => $detail->layanan_id,
                'parfum_id'     => $detail->parfum_id,
                'jumlah'        => $detail->jumlah,
                'harga'         => $detail->harga,
                'total_harga'   => $detail->total_harga,
                'created_at'    => now()->timestamp * 1000,
                'updated_at'    => now()->timestamp * 1000,
            ]);
        }

        $this->transaksiHistoryRepository->create([
            'transaksi_id'  => $transaksi->id,
            'status'        => $request->status,
            'keterangan'    => 'Pelanggan datang & menyerahkan cucian ke petugas laundry',
            'created_at'    => now()->timestamp * 1000,
            'updated_at'    => now()->timestamp * 1000,
        ]);

        $transaksiHasOutlet = $this->transaksiHasOutletRepository->findByOutletId($request->outlet_id);
        if ($transaksiHasOutlet != null) {
            $this->transaksiHasOutletRepository->increment($transaksiHasOutlet->id, $request->total_harga);
        } else {
            $this->transaksiHasOutletRepository->create([
                'outlet_id'         => $request->outlet_id,
                'jumlah_transaksi'  => 1,
                'nominal_transaksi' => $request->total_harga,
                'waktu'             => date('Y-m-d H:i:s'),
                'created_at'        => now()->timestamp * 1000,
                'updated_at'        => now()->timestamp * 1000,
            ]);
        }

        NotificationJob::dispatch('transaksi baru', [
            'transaksi_id' => $transaksi->id,
        ]);
    }

    public function cancel($id): void
    {
        $transaksi = $this->transaksiRepository->findById($id);
        if ($transaksi == null) {
            abort(400, 'Transaksi tidak ditemukan');
        }

        $this->transaksiRepository->updateStatus($transaksi->id, 'batal');
        $transaksiHasOutlet = '';
        $this->transaksiHasOutletRepository->decrement($transaksi->id, $transaksi->total_harga);
        $this->transaksiHistoryRepository->create([
            'transaksi_id'  => $transaksi->id,
            'status'        => 'cancel',
            'keterangan'    => 'Transaksi telah dibatalkan',
            'created_at'    => now()->timestamp * 1000,
            'updated_at'    => now()->timestamp * 1000,
        ]);
    }

    public function updateStatus($request): void
    {
        switch ($request->status) {
            case 'baru':
                $this->transaksiRepository->updateStatus($request->id, 'diproses');
                break;
            case 'diproses':
                $this->transaksiRepository->updateStatus($request->id, 'selesai');
                NotificationJob::dispatch('transaksi selesai', [
                    'transaksi_id' => $request->id,
                ]);
                break;
            case 'diambil':
            case 'diantar':
            case 'selesai':
                $this->transaksiRepository->updateStatus($request->id, 'close');
                break;
            case 'pending':
                $this->transaksiRepository->updateStatus($request->id, 'pengambilan');
                NotificationJob::dispatch('transaksi dipickup', [
                    'transaksi_id' => $request->id,
                ]);
                break;
            case 'pengambilan':
                $this->transaksiRepository->updateStatus($request->id, 'baru');
                break;
        }
    }
}
