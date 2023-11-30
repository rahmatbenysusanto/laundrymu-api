<?php

namespace App\Http\Services;

use App\Http\Repository\LayananRepository;
use App\Http\Repository\TransaksiDetailRepository;

class LayananService
{
    public function __construct(
        protected LayananRepository $layananRepository,
        protected TransaksiDetailRepository $transaksiDetailRepository
    ){}

    public function findByToko($toko_id)
    {
        return $this->layananRepository->findByToko($toko_id);
    }

    public function findById($id)
    {
        return $this->layananRepository->findById($id);
    }

    public function create($request): void
    {
        $data = [
            "toko_id"   => $request->post("toko_id"),
            "nama"      => $request->post("nama"),
            "type"      => $request->post("type"),
            "harga"     => $request->post("harga"),
        ];
        $this->layananRepository->create($data);
    }

    public function edit($id, $request): void
    {
        $data = [
            "toko_id"   => $request->post("toko_id"),
            "nama"      => $request->post("nama"),
            "type"      => $request->post("type"),
            "harga"     => $request->post("harga"),
        ];
        $this->layananRepository->edit($id, $data);
    }

    public function delete($layanan_id): void
    {
        $check = $this->transaksiDetailRepository->countByLayanan($layanan_id);
        if ($check == 0) {
            $this->layananRepository->delete($layanan_id);
        } else {
            abort(400, "Layanan sudah pernah digunakan dalam transaksi, layanan tidak bisa dihapus");
        }
    }
}
