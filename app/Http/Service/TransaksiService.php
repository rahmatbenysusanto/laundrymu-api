<?php

namespace App\Http\Service;

use App\Http\Repository\ParfumRepository;
use App\Http\Repository\PelangganRepository;
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
        protected TransaksiHasOutletRepository  $transaksiHasOutletRepository,
        protected PelangganRepository $pelangganRepository,
        protected ParfumRepository $parfumRepository,
    ) {}

    public function create($request): void
    {
        $transaksi = $this->transaksiRepository->create([
            'outlet_id'         => $request->outlet_id,
            'pelanggan_id'      => $request->pelanggan_id,
            'diskon_id'         => $request->diskon_id,
            'pengiriman_id'     => $request->pengiriman_id,
            'pembayaran_id'     => $request->pembayaran_id,
            'order_number'      => 'INV-'.now()->format('Ymd').mt_rand(1000, 9999),
            'status'            => $request->status,
            'status_pembayaran'  => $request->status_pembayaran,
            'harga'             => $request->harga,
            'harga_diskon'      => $request->harga_diskon,
            'biaya_pengiriman'  => $request->biaya_pengiriman,
            'total_harga'       => ($request->harga + $request->biaya_pengiriman + $request->harga_parfum) - $request->harga_diskon,
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

        $pelanggan = $this->pelangganRepository->findById($request->pelanggan_id);

        NotificationJob::dispatch('transaksi baru', [
            'transaksi_id'  => $transaksi->id,
            'no_hp'         => $pelanggan->no_hp,
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
                $transaksi = $this->transaksiRepository->findById($request->id);
                $pelanggan = $this->pelangganRepository->findById($transaksi->pelanggan_id);
                NotificationJob::dispatch('transaksi selesai', [
                    'no_hp'         => $pelanggan->no_hp,
                    'nama'          => $pelanggan->nama,
                    'order_number'  => $transaksi->order_number,
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

    public function listTransaksi($request)
    {
        $status = $request->get('status');
        $outlet_id = $request->query('outlet_id');

        return $this->transaksiRepository->listTransaksi($outlet_id, $status);
    }
}
