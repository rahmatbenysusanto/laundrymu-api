<?php

namespace App\Http\Services;

use App\Http\Repository\ParfumRepository;
use App\Http\Repository\PengirimanRepository;
use App\Http\Repository\TransaksiDetailRepository;

class PengirimanService
{
    public function __construct(
        protected PengirimanRepository $pengirimanRepository,
        protected TransaksiDetailRepository $transaksiDetailRepository
    ){}

    public function findByToko($toko_id)
    {
        return $this->pengirimanRepository->findByToko($toko_id);
    }

    public function findById($id)
    {
        return $this->pengirimanRepository->findById($id);
    }

    public function create($request): void
    {
        $data = [
            "toko_id"   => $request->post("toko_id"),
            "nama"      => $request->post("nama"),
            "harga"     => $request->post("harga"),
        ];
        $this->pengirimanRepository->create($data);
    }

    public function edit($id, $request): void
    {
        $data = [
            "toko_id"   => $request->post("toko_id"),
            "nama"      => $request->post("nama"),
            "harga"     => $request->post("harga"),
        ];
        $this->pengirimanRepository->edit($id, $data);
    }

    public function delete($pengiriman_id): void
    {
        $check = $this->transaksiDetailRepository->countByPengiriman($pengiriman_id);
        if ($check == 0) {
            $this->pengirimanRepository->delete($pengiriman_id);
        } else {
            abort(400, "Pengiriman sudah pernah digunakan dalam transaksi, layanan tidak bisa dihapus");
        }
    }
}
