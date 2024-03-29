<?php

namespace App\Http\Services;

use App\Http\Repository\ParfumRepository;
use App\Http\Repository\TransaksiDetailRepository;
use App\Http\Repository\TransaksiRepository;

class ParfumService
{
    public function __construct(
        protected ParfumRepository $parfumRepository,
        protected TransaksiRepository $transaksiRepository
    ){}

    public function findByToko($toko_id)
    {
        return $this->parfumRepository->findByToko($toko_id);
    }

    public function findById($id)
    {
        return $this->parfumRepository->findById($id);
    }

    public function create($request): void
    {
        $data = [
            "toko_id"   => $request->post("toko_id"),
            "nama"      => $request->post("nama"),
            "harga"     => $request->post("harga"),
        ];
        $this->parfumRepository->create($data);
    }

    public function edit($id, $request): void
    {
        $data = [
            "toko_id"   => $request->post("toko_id"),
            "nama"      => $request->post("nama"),
            "harga"     => $request->post("harga"),
        ];
        $this->parfumRepository->edit($id, $data);
    }

    public function delete($parfum_id): void
    {
        $check = $this->transaksiRepository->countByDiskon($parfum_id);
        if ($check == 0) {
            $this->parfumRepository->delete($parfum_id);
        } else {
            abort(400, "Layanan sudah pernah digunakan dalam transaksi, layanan tidak bisa dihapus");
        }
    }
}
