<?php

namespace App\Http\Service;

use App\Http\Repository\StatusTransaksiOutletRepository;
use App\Http\Repository\TransaksiRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardService
{
    public function __construct(
        protected StatusTransaksiOutletRepository $statusTransaksiOutletRepository,
        protected TransaksiRepository $transaksiRepository,
    ) {}

    public function getStatusTransaksi($outlet_id)
    {
        return $this->statusTransaksiOutletRepository->findByOutletId($outlet_id);
    }

    public function statisticTransaksi($outlet_id, $start_date, $end_date): array
    {
        $startDate = Carbon::createFromFormat('Y-m-d H:i', $start_date.' 00:00');
        $endDate = Carbon::createFromFormat('Y-m-d H:i', $end_date. ' 23:59');

        return [
            'jumlah'    => $this->transaksiRepository->jumlahTransaksi($outlet_id, $startDate->timestamp * 1000, $endDate->timestamp * 1000),
            'nominal'   => (int)$this->transaksiRepository->nominalTransaksi($outlet_id, $startDate->timestamp * 1000, $endDate->timestamp * 1000),
        ];
    }

    public function chart($outlet_id): array
    {
        $dates = [
            date('Y-m-d', strtotime('-7 day')),
            date('Y-m-d', strtotime('-6 day')),
            date('Y-m-d', strtotime('-5 day')),
            date('Y-m-d', strtotime('-4 day')),
            date('Y-m-d', strtotime('-3 day')),
            date('Y-m-d', strtotime('-2 day')),
            date('Y-m-d', strtotime('-1 day')),
        ];

        $data = [];
        $nominal = [];
        foreach ($dates as $date) {
            $startDate = Carbon::createFromFormat('Y-m-d H:i', $date.' 00:00');
            $endDate = Carbon::createFromFormat('Y-m-d H:i', $date. ' 23:59');
            $data[] = $this->transaksiRepository->jumlahTransaksi($outlet_id, $startDate->timestamp * 1000, $endDate->timestamp * 1000);
            $nominal[] = $this->transaksiRepository->nominalTransaksi($outlet_id, $startDate->timestamp * 1000, $endDate->timestamp * 1000);
        }

        return [
            $data,
            $nominal
        ];
    }
}
