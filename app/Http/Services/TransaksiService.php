<?php

namespace App\Http\Services;

use App\Http\Repository\HistoriStatusTransaksiRepository;
use App\Http\Repository\LayananRepository;
use App\Http\Repository\ParfumRepository;
use App\Http\Repository\PelangganHasTransaksiRepository;
use App\Http\Repository\StatusTransaksiHasTokoRepository;
use App\Http\Repository\TokoRepository;
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
        protected TransaksiHasTokoRepository $transaksiHasTokoRepository,
        protected TokoRepository $tokoRepository,
        protected LayananRepository $layananRepository,
        protected ParfumRepository $parfumRepository
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
        $order_number = date('mdis').rand(100, 999);
        $transaksi = $this->transaksiRepository->create([
            "toko_id"           => $request->toko_id,
            "pelanggan_id"      => $request->pelanggan_id,
            "diskon_id"         => $request->diskon_id,
            "pengiriman_id"     => $request->pengiriman_id,
            "pembayaran_id"     => $request->pembayaran_id,
            "order_number"      => $order_number,
            "status"            => "baru",
            "status_pembayaran" => $request->status_pembayaran,
            "harga"             => $request->harga,
            "harga_diskon"      => $request->harga_diskon,
            "total_harga"       => $request->total_harga,
            "catatan"           => $request->catatan
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

        // WhatsApp Notifikasi
        $toko = $this->tokoRepository->findById($request->toko_id);
        $pelanggan = $this->pelangganService->findById($request->pelanggan_id);
        $parfum = $this->parfumRepository->findById($request->parfum_id);

$message = "*[".strtoupper($toko->nama)." - NOTA]*

*No Transaksi:* ".$order_number."
*Nama:* ".$pelanggan->nama."
*No HP:* ".$pelanggan->no_hp."
*Tanggal:* ".tanggal_jam_indo(date('Y-m-d H:i:s'), time())."
*Parfum:* ".$parfum->nama.' | Rp. '.number_format($parfum->harga,0,',','.')."
*Note:* $request->catatan

*Layanan* :

";
$dataLayanan = $request->layanan;
$no = 1;
for ($i = 0; $i < count($request->layanan); $i++) {
    $layanan = $this->layananRepository->findById($dataLayanan[$i]['id']);
    if ($layanan->type == "berat") {
$message = $message.$no++.")".$layanan->nama." : ".$dataLayanan[$i]['jumlah']." Kg x Rp.".number_format($layanan->harga,0,',','.')." = Rp.".number_format($dataLayanan[$i]['harga'] * $dataLayanan[$i]['jumlah'])."
";
    } else {
$message = $message.$no++.")".$layanan->nama." : ".$dataLayanan[$i]['jumlah']." Pcs x Rp.".number_format($layanan->harga,0,',','.')." = Rp.".number_format($dataLayanan[$i]['harga'] * $dataLayanan[$i]['jumlah'])."
";
    }
}

$message = $message ."
*Harga:* Rp. ".number_format($request->harga,0,',','.')."
*Diskon:* Rp. ".number_format($request->harga_diskon,0,',','.')."
*Total Harga:* Rp. ".number_format($request->total_harga,0,',','.')."

*Pembayaran:* ".$request->status_pembayaran."
*Diterima Oleh:* Admin

Terima kasih,
*".$toko->nama."*"
;

        $pelanggan = $this->pelangganService->findById($request->pelanggan_id);
        $this->notificationService->whatsAppNotification($pelanggan->no_hp, $message);
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

$message = "
Selamat ".$this->notificationService->ucapanSelamat()." ".$transaksi->pelanggan->nama.", laundry anda dengan nomor transaksi ".$transaksi->order_number." sudah selesai.
Silahkan ambil laundry anda ke outlet kami,

Terimakasih.
";
                 $this->notificationService->whatsAppNotification($transaksi->pelanggan->no_hp, trim($message));
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
