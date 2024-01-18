<?php

namespace App\Http\Services;

use App\Http\Repository\DiskonRepository;
use App\Http\Repository\LisensiRepository;
use App\Http\Repository\ParfumRepository;
use App\Http\Repository\PembayaranOutletRepository;
use App\Http\Repository\PembayaranRepository;
use App\Http\Repository\PengirimanRepository;
use App\Http\Repository\StatusTransaksiHasTokoRepository;
use App\Http\Repository\TokoRepository;
use App\Http\Repository\TransaksiHasTokoRepository;
use App\Http\Repository\UserHasTokoRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class TokoService
{
    public function __construct(
        protected TokoRepository $tokoRepository,
        protected ParfumRepository $parfumRepository,
        protected PembayaranRepository $pembayaranRepository,
        protected DiskonRepository $diskonRepository,
        protected PengirimanRepository $pengirimanRepository,
        protected UserHasTokoRepository $userHasTokoRepository,
        protected StatusTransaksiHasTokoRepository $statusTransaksiHasTokoRepository,
        protected TransaksiHasTokoRepository $transaksiHasTokoRepository,
        protected PembayaranOutletRepository $pembayaranOutletRepository,
        protected LisensiRepository $lisensiRepository
    ){}

    public function getAll(): Collection
    {
        return $this->tokoRepository->getAll();
    }

    public function findByUser($userId): Collection
    {
        return $this->tokoRepository->findByUser($userId);
    }

    public function findById($tokoId)
    {
        return $this->tokoRepository->findById($tokoId);
    }

    public function create($request): void
    {
        $lisensi = $this->lisensiRepository->findById($request->post('lisensi_id'));

        $data = [
            "user_id"   => $request->post("user_id"),
            "nama"      => $request->post("nama"),
            "no_hp"     => $request->post("no_hp"),
            "logo"      => 'default.png',
            "status"    => "inactive",
            "expired"   => date('Y-m-d H:i:s', time()),
            "alamat"    => $request->post("alamat"),
            "provinsi"  => $request->post("provinsi"),
            "kabupaten" => $request->post("kabupaten"),
            "kecamatan" => $request->post("kecamatan"),
            "kelurahan" => $request->post("kelurahan"),
            "kode_pos"  => $request->post("kode_pos"),
            "lat"       => $request->post("lat"),
            "long"      => $request->post("long")
        ];
        $create = $this->tokoRepository->create($data);

        // Create Default Value
        $this->diskonRepository->create([
            'toko_id'   => $create->id,
            'nama'      => 'tidak ada diskon',
            'type'      => 'nominal',
            'nominal'   => 0
        ]);

        $this->parfumRepository->create([
            'toko_id'   => $create->id,
            'nama'      => 'standar',
            'harga'     => 0
        ]);

        $this->pembayaranRepository->create([
            'toko_id'   => $create->id,
            'nama'      => 'tunai',
        ]);

        $this->pengirimanRepository->create([
            'toko_id'   => $create->id,
            'nama'      => 'Ambil antar sendiri',
            'harga'     => 0
        ]);

        $this->statusTransaksiHasTokoRepository->create([
            'toko_id'   => $create->id,
            'baru'      => 0,
            'diproses'  => 0,
            'selesai'   => 0
        ]);

        $this->transaksiHasTokoRepository->create([
            'toko_id'           => $create->id,
            'jumlah_transaksi'  => 0,
            'nominal_transaksi' => 0,
            'waktu'             => date('Y-m-d H:i:s', time())
        ]);

        $this->pembayaranOutletRepository->create([
            'toko_id'               => $create->id,
            'user_id'               => $request->post("user_id"),
            'nomor_pembayaran'      => date('Ymds', time()).rand(100, 999),
            'lisensi_id'            => $request->post('lisensi_id'),
            'metode_pembayaran_id'  => $request->post('metode_pembayaran_id'),
            'status'                => 'no transfer',
            'keterangan'            => 'Pembuatan Outlet Baru',
            'before'                => date('Y-m-d H:i:s', time()),
            'after'                 => date('Y-m-d', strtotime('+'.$lisensi->durasi.' month'))
        ]);
    }

    public function getTokoPegawai($user_id)
    {
        return $this->userHasTokoRepository->findByUserId($user_id);
    }

    public function historiPembayaranOutlet($user_id)
    {
        return $this->pembayaranOutletRepository->findByUserId($user_id);
    }

    public function getDetailPembayaran($nomor_pembayaran)
    {
        return $this->pembayaranOutletRepository->findByNomorPembayaran($nomor_pembayaran);
    }

    public function uploadBuktiPembayaran($id, $bukti_transfer): void
    {
        Log::info($id);
        Log::info($bukti_transfer);
        $this->pembayaranOutletRepository->update($id, [
            'bukti_transfer'    => $bukti_transfer,
            'status'            => 'menunggu pengecekan'
        ]);
    }
}
