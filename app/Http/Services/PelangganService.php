<?php

namespace App\Http\Services;

use App\Http\Repository\PelangganHasTransaksiRepository;
use App\Http\Repository\PelangganRepository;
use App\Http\Repository\TransaksiRepository;

class PelangganService
{
    public function __construct(
        protected PelangganRepository $pelangganRepository,
        protected TransaksiRepository $transaksiRepository,
        protected PelangganHasTransaksiRepository $pelangganHasTransaksiRepository
    ){}

    public function findByToko($toko_id)
    {
        return $this->pelangganRepository->findByToko($toko_id);
    }

    public function findById($id)
    {
        return $this->pelangganRepository->findById($id);
    }

    public function create($request)
    {
        $data = [
            "toko_id"   => $request->post("toko_id"),
            "nama"      => $request->post("nama"),
            "no_hp"     => $request->post("no_hp"),
        ];
        $pelanggan =  $this->pelangganRepository->create($data);

        $this->pelangganHasTransaksiRepository->create([
            'pelanggan_id'              => $pelanggan->id,
            'jumlah_transaksi'          => 0,
            'jumlah_transaksi_bulanan'  => 0,
            'nominal_transaksi'         => 0,
            'nominal_transaksi_bulanan' => 0
        ]);

        return $pelanggan;
    }

    public function edit($id, $request): void
    {
        $data = [
            "toko_id"   => $request->post("toko_id"),
            "nama"      => $request->post("nama"),
            "no_hp"     => $request->post("no_hp"),
        ];
        $this->pelangganRepository->edit($id, $data);
    }

    public function delete($pelanggan_id): void
    {
        $check = $this->transaksiRepository->countByPelanggan($pelanggan_id);
        if ($check == 0) {
            $this->pelangganRepository->delete($pelanggan_id);
        } else {
            abort(400, "Pelanggan sudah pernah digunakan dalam transaksi, pelanggan tidak bisa dihapus");
        }
    }
}
