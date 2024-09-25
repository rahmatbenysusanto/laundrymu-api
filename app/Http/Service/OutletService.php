<?php

namespace App\Http\Service;

use App\Http\Repository\FlipRepository;
use App\Http\Repository\LisensiRepository;
use App\Http\Repository\NotificationRepository;
use App\Http\Repository\OutletPembayaranRepository;
use App\Http\Repository\OutletRepository;
use App\Http\Repository\UserHasOutletRepository;
use App\Jobs\NotificationJob;
use Illuminate\Support\Facades\Log;

class OutletService
{
    public function __construct(
        protected FlipRepository $flipRepository,
        protected LisensiRepository $lisensiRepository,
        protected OutletPembayaranRepository $outletPembayaranRepository,
        protected OutletRepository $outletRepository,
        protected UserHasOutletRepository $userHasOutletRepository,
    ) {}

    public function perpanjangLisensi($request): void
    {
        $lisensi = $this->lisensiRepository->find($request->lisensi_id);
        $outlet = $this->outletRepository->findById($request->outlet_id);

        $title = 'Pembayaran '.$outlet->nama;
        $no = date('Ymd').rand(100000, 999999);
        $flip = $this->flipRepository->createBill($title, $lisensi->harga);

        $this->outletPembayaranRepository->create([
            'outlet_id'         => $request->outlet_id,
            'user_id'           => $request->user_id,
            'lisensi_id'        => $request->lisensi_id,
            'nomor_pembayaran'  => $no,
            'status'            => 'pending',
            'url_payment'       => $flip,
            'created_at'        => now()->timestamp * 1000,
            'updated_at'        => now()->timestamp * 1000,
        ]);

        NotificationJob::dispatch('pembayaran flip', [
            'nama'      => $outlet->nama,
            'link'      => $flip,
            'no'        => $no,
            'no_hp'     => $outlet->no_hp,
            'tanggal'   => date('d-M-Y H:i', strtotime('+1 day')),
        ]);
    }

    public function findByUserId($user_id): \Illuminate\Database\Eloquent\Collection
    {
        return $this->userHasOutletRepository->getByUserId($user_id);
    }
}
