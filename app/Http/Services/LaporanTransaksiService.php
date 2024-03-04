<?php

namespace App\Http\Services;

use App\Http\Repository\DiskonRepository;
use App\Http\Repository\LayananRepository;
use App\Http\Repository\ParfumRepository;
use App\Http\Repository\PembayaranRepository;
use App\Http\Repository\TransaksiDetailRepository;
use App\Http\Repository\TransaksiRepository;

class LaporanTransaksiService
{
    public function __construct(
        protected TransaksiRepository $transaksiRepository,
        protected ParfumRepository $parfumRepository,
        protected TransaksiDetailRepository $transaksiDetailRepository,
        protected DiskonRepository $diskonRepository,
        protected PembayaranRepository $pembayaranRepository,
        protected LayananRepository $layananRepository
    ) {}

    public function ops_transaksi($toko_id): array
    {
        return [
            'selesai'   => $this->transaksiRepository->countTransaksiByStatusHariIni($toko_id, "selesai"),
            'dibatalkan'=> $this->transaksiRepository->countTransaksiByStatusHariIni($toko_id, "batal")
        ];
    }

    public function ops_transaksiByDate($toko_id, $start, $finish): array
    {
        return [
            'selesai'   => $this->transaksiRepository->countTransaksiByStatusByDate($toko_id, "selesai", $start, $finish),
            'dibatalkan'=> $this->transaksiRepository->countTransaksiByStatusByDate($toko_id, "batal", $start, $finish)
        ];
    }

    public function ops_layanan($toko_id): array
    {
        $layanan = $this->layananRepository->findByToko($toko_id);
        $result = [];

        foreach ($layanan as $lay) {
            $result[] = [
                "nama"      => $lay->nama,
                "jumlah"    => $this->transaksiDetailRepository->countLayanan($toko_id, $lay->id)
            ];
        }

        return $result;
    }

    public function ops_parfum($toko_id): array
    {
        $parfum = $this->parfumRepository->findByToko($toko_id);

        $result = [];
        foreach ($parfum as $par) {
            $result[] = [
                'nama'      => $par->nama,
                'jumlah'    => $this->transaksiDetailRepository->countParfum($toko_id, $par->id)
            ];
        }

        return $result;
    }

    public function ops_diskon($toko_id): array
    {
        $diskon = $this->diskonRepository->findByToko($toko_id);
        $result = [];
        foreach ($diskon as $dis) {
            $result[] = [
                'nama'      => $dis->nama,
                'jumlah'    => $this->transaksiRepository->countDiskon($toko_id, $dis->id)
            ];
        }

        return $result;
    }

    public function ops_pembayaran($toko_id): array
    {
        $pembayaran = $this->pembayaranRepository->findByToko($toko_id);
        $result = [];
        foreach ($pembayaran as $pem) {
            $result[] = [
                'nama'      => $pem->nama,
                'jumlah'    => $this->transaksiRepository->countPembayaran($toko_id, $pem->id)
            ];
        }

        return $result;
    }
}
