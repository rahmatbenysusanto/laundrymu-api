<?php

namespace App\Http\Services;

use App\Http\Repository\PelangganRepository;
use App\Http\Repository\StatusTransaksiHasTokoRepository;
use App\Http\Repository\TransaksiHasTokoRepository;
use App\Http\Repository\TransaksiRepository;
use Illuminate\Support\Facades\Log;

class DashboardService
{
    public function __construct(
        protected PelangganRepository $pelangganRepository,
        protected StatusTransaksiHasTokoRepository $statusTransaksiHasTokoRepository,
        protected TransaksiHasTokoRepository $transaksiHasTokoRepository,
        protected TransaksiRepository $transaksiRepository
    ) {}

    public function getTopPelanggan($toko_id): \Illuminate\Support\Collection
    {
        return $this->pelangganRepository->getTopPelangganBulanan($toko_id);
    }

    public function getStatusTransaksi($toko_id)
    {
        return [
            'status'    => $this->statusTransaksiHasTokoRepository->findByTokoId($toko_id),
            'diambil'   => $this->transaksiRepository->countTransaksiByStatusByDate($toko_id, 'diambil', date('Y-m-d', time()), date('Y-m-d', time()))
        ];
    }

    public function nominalTransaksiBulan($toko_id)
    {
        $result =  $this->transaksiHasTokoRepository->findByTokoIdAndMonth($toko_id);
        if ($result == null) {
            $this->transaksiHasTokoRepository->create([
                'toko_id'   =>  $toko_id,
                'jumlah'    => 0,
                'nominal'   => 0,
                'waktu'     => date('Y-m-d H:i:s', time())
            ]);

            return $this->transaksiHasTokoRepository->findByTokoIdAndMonth($toko_id);
        }

        return $result;
    }

    public function transaksiHarian($toko_id): array
    {
        return [
            'jumlah'    => $this->transaksiRepository->jumlahTransaksiHarian($toko_id),
            'nominal'   => $this->transaksiRepository->jumlahNominalHarian($toko_id),
        ];
    }

    public function chartDashboard($toko_id): array
    {
        $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

        $dataTransaksi = [];
        $dataJumlah = [];
        $jumlahTransaksi = 0;
        $nominalTransaksi = 0;
        for ($i = 0; $i < 12; $i++) {
            $transaksi = $this->transaksiHasTokoRepository->findByTokoIdAndDate($toko_id, $months[$i]);

            $dataTransaksi[] = $transaksi->jumlah_transaksi ?? 0;
            $dataJumlah[] = $transaksi->nominal_transaksi ?? 0;
            $jumlahTransaksi += $transaksi->jumlah_transaksi ?? 0;
            $nominalTransaksi += $transaksi->nominal_transaksi ?? 0;
        }

        return [
            $dataTransaksi,
            $dataJumlah,
            $jumlahTransaksi,
            $nominalTransaksi
        ];
    }

    public function chartDashboardMobile($toko_id): array
    {
        return [
            $this->transaksiRepository->jumlahTransaksiByDate($toko_id, date('Y-m-d', strtotime('-7 day'))),
            $this->transaksiRepository->jumlahTransaksiByDate($toko_id, date('Y-m-d', strtotime('-6 day'))),
            $this->transaksiRepository->jumlahTransaksiByDate($toko_id, date('Y-m-d', strtotime('-5 day'))),
            $this->transaksiRepository->jumlahTransaksiByDate($toko_id, date('Y-m-d', strtotime('-4 day'))),
            $this->transaksiRepository->jumlahTransaksiByDate($toko_id, date('Y-m-d', strtotime('-3 day'))),
            $this->transaksiRepository->jumlahTransaksiByDate($toko_id, date('Y-m-d', strtotime('-2 day'))),
            $this->transaksiRepository->jumlahTransaksiByDate($toko_id, date('Y-m-d', strtotime('-1 day'))),
        ];
    }
}
