<?php

namespace App\Http\Service;

use App\Http\Repository\FlipRepository;
use App\Http\Repository\LisensiRepository;
use App\Http\Repository\OutletPembayaranRepository;
use App\Http\Repository\OutletRepository;
use App\Http\Repository\ParfumRepository;
use App\Http\Repository\PembayaranRepository;
use App\Http\Repository\PengirimanRepository;
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
        protected ParfumRepository $parfumRepository,
        protected PembayaranRepository $pembayaranRepository,
        protected PengirimanRepository $pengirimanRepository,
    ) {}

    public function perpanjangLisensi($request): void
    {
        $lisensi = $this->lisensiRepository->find($request->post('lisensi_id'));
        $outlet = $this->outletRepository->findById($request->post('outlet_id'), $request->post('user_id'));

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

    public function create($request): void
    {
        $outlet = $this->outletRepository->create([
            'user_id'   => $request->user_id,
            'nama'      => $request->nama,
            'no_hp'     => $request->no_hp,
            'logo'      => 'default.png',
            'status'    => 'inactive',
            'expired'   => date('Y-m-d'),
            'alamat'    => $request->alamat,
            'provinsi'  => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'kode_pos'  => $request->kode_pos,
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);

        $this->userHasOutletRepository->create([
            'outlet_id'     => $outlet->id,
            'user_id'       => $request->user_id,
            'created_at'    => now()->timestamp * 1000,
            'updated_at'    => now()->timestamp * 1000,
        ]);

        $this->parfumRepository->create([
            'outlet_id' => $outlet->id,
            'nama'      => '-',
            'harga'     => 0,
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);

        $this->pembayaranRepository->create([
            'outlet_id' => $outlet->id,
            'nama'      => 'Tunai',
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);

        $this->pengirimanRepository->create([
            'outlet_id' => $outlet->id,
            'nama'      => 'Ambil antar sendiri',
            'harga'     => 0,
            'created_at'=> now()->timestamp * 1000,
            'updated_at'=> now()->timestamp * 1000,
        ]);

        $lisensi = $this->lisensiRepository->find($request->lisensi_id);
        $outlet = $this->outletRepository->findById($outlet->id);

        $title = 'Pembayaran '.$outlet->nama;
        $no = date('Ymd').rand(100000, 999999);
        $flip = $this->flipRepository->createBill($title, $lisensi->harga);

        $this->outletPembayaranRepository->create([
            'outlet_id'         => $outlet->id,
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

    public function findById($id, $userId)
    {
        return $this->outletRepository->findById($id, $userId);
    }

    public function historyPembayaran($outlet_id): \Illuminate\Database\Eloquent\Collection
    {
        return $this->outletPembayaranRepository->getByOutletId($outlet_id);
    }

    public function findByNomorPembayaran($nomor_pembayaran)
    {
        return $this->outletPembayaranRepository->findByNomorPembayaran($nomor_pembayaran);
    }
}
