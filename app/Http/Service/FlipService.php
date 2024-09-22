<?php

namespace App\Http\Service;

use App\Http\Repository\FlipRepository;
use App\Http\Repository\LisensiRepository;
use App\Http\Repository\OutletPembayaranRepository;
use App\Http\Repository\OutletRepository;
use App\Jobs\NotificationJob;
use Illuminate\Support\Facades\DB;

class FlipService
{
    public function __construct(
        protected FlipRepository $flipRepository,
        protected OutletPembayaranRepository $outletPembayaranRepository,
        protected OutletRepository $outletRepository,
        protected LisensiRepository $lisensiRepository,
    ) {}

    public function getAllPayment()
    {
        return $this->flipRepository->getAllPayment();
    }

    public function getBalance()
    {
        return $this->flipRepository->getBalance();
    }

    public function callbackAcceptPaymentFlip($data): void
    {
        try {
            DB::beginTransaction();
            $outlet_pembayaran = $this->outletPembayaranRepository->findByLinkUrl($data['bill_link']);

            if ($outlet_pembayaran->status == 'success') {
                abort(400, 'Pembayaran Telah Lunas');
            }

            $this->outletPembayaranRepository->update($data['bill_link'], [
                'callback'  => json_encode($data)
            ]);

            if ($data['status'] == "SUCCESSFUL") {
                $this->outletPembayaranRepository->update($data['bill_link'], [
                    'status'    => 'success'
                ]);

                $lisensi = $this->lisensiRepository->find($outlet_pembayaran->lisensi_id);
                $outlet = $this->outletRepository->findById($outlet_pembayaran->outlet_id);

                $this->outletRepository->update($outlet_pembayaran->outlet_id, [
                    'status'    => 'active',
                    'expired'   => DB::raw('DATE_ADD(expired, INTERVAL '.$lisensi->bulan.' MONTH)')
                ]);

                NotificationJob::dispatch('pembayaran outlet berhasil', [
                    'no_hp'             => $outlet->no_hp,
                    'nama'              => $outlet->nama,
                    'tanggal'           => date('d M Y H:i'),
                    'nominal'           => 'Rp '.number_format($lisensi->harga),
                ]);
            }
            DB::commit();
        } catch (\Exception $err) {
            DB::rollBack();
        }
    }
}
