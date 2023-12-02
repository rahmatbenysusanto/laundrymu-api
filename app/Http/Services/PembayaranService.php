<?php

namespace App\Http\Services;

use App\Http\Repository\PembayaranRepository;
use App\Http\Repository\TransaksiRepository;

class PembayaranService
{
    public function __construct(
        protected PembayaranRepository $pembayaranRepository,
        protected TransaksiRepository $transaksiRepository
    ){}

    public function findByToko($toko_id)
    {
        return $this->pembayaranRepository->findByToko($toko_id);
    }

    public function findById($id)
    {
        return $this->pembayaranRepository->findById($id);
    }

    public function create($request): void
    {
        $data = [
            "toko_id"   => $request->post("toko_id"),
            "nama"      => $request->post("nama"),
        ];
        $this->pembayaranRepository->create($data);
    }

    public function edit($id, $request): void
    {
        $data = [
            "toko_id"   => $request->post("toko_id"),
            "nama"      => $request->post("nama"),
        ];
        $this->pembayaranRepository->edit($id, $data);
    }

    public function delete($pembayaran_id): void
    {
        $check = $this->transaksiRepository->countByPembayaran($pembayaran_id);
        if ($check == 0) {
            $this->pembayaranRepository->delete($pembayaran_id);
        } else {
            abort(400, "Pembayaran sudah pernah digunakan dalam transaksi, pembayaran tidak bisa dihapus");
        }
    }
}
