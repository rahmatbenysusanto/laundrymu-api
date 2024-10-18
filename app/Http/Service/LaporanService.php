<?php

namespace App\Http\Service;

use App\Http\Repository\DiskonRepository;
use App\Http\Repository\LayananRepository;
use App\Http\Repository\ParfumRepository;
use App\Http\Repository\PembayaranRepository;
use App\Http\Repository\TransaksiDetailRepository;
use App\Http\Repository\TransaksiRepository;
use Illuminate\Support\Facades\Log;

class LaporanService
{
    public function __construct(
        protected TransaksiRepository $transaksiRepository,
        protected LayananRepository $layananRepository,
        protected TransaksiDetailRepository $transaksiDetailRepository,
        protected ParfumRepository $parfumRepository,
        protected DiskonRepository $diskonRepository,
        protected PembayaranRepository $pembayaranRepository,
    ) {}

    public function getTransaksi($outlet_id, $start, $end): array
    {
        return [
            'selesai'   => $this->transaksiRepository->jumlahTransaksiByStatus($outlet_id, ['selesai','close','diambil','close'], $start, $end),
            'batal'     => $this->transaksiRepository->jumlahTransaksiByStatus($outlet_id, ['batal'], $start, $end),
        ];
    }

    public function getLayanan($outlet_id, $start, $end): array
    {
        $result = [];
        $layanan = $this->layananRepository->getByOutletId($outlet_id);

        foreach ($layanan as $lay) {
            $result[] = [
                'layanan'   => $lay->nama,
                'jumlah'    => $this->transaksiDetailRepository->countLayananByOutletId($outlet_id, $lay->id, $start, $end)
            ];
        }

        return $result;
    }

    public function getParfum($outlet_id, $start, $end): array
    {
        $result = [];
        $parfum = $this->parfumRepository->findByOutletId($outlet_id);

        foreach ($parfum as $par) {
            $result[] = [
                'parfum'    => $par->nama,
                'jumlah'    => $this->transaksiDetailRepository->countParfumByOutletId($outlet_id, $par->id, $start, $end)
            ];
        }

        return $result;
    }

    public function getDiskon($outlet_id, $start, $end): array
    {
        $result = [];
        $diskon = $this->diskonRepository->getByOutletId($outlet_id);

        foreach ($diskon as $dis) {
            $result[] = [
                'diskon'    => $dis->nama,
                'jumlah'    => $this->transaksiRepository->countDiskonByOutletId($outlet_id, $dis->id, $start, $end)
            ];
        }

        return $result;
    }

    public function getPembayaran($outlet_id, $start, $end): array
    {
        $result = [];
        $pembayaran = $this->pembayaranRepository->findByOutletId($outlet_id);

        foreach ($pembayaran as $dis) {
            $result[] = [
                'pembayaran'    => $dis->nama,
                'jumlah'        => $this->transaksiRepository->countPembayaranByOutletId($outlet_id, $dis->id, $start, $end)
            ];
        }

        return $result;
    }
}
