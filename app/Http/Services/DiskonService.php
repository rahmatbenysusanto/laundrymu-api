<?php

namespace App\Http\Services;

use App\Http\Repository\DiskonRepository;
use App\Http\Repository\ParfumRepository;
use App\Http\Repository\TransaksiDetailRepository;
use App\Http\Repository\TransaksiRepository;

class DiskonService
{
    public function __construct(
        protected DiskonRepository $diskonRepository,
        protected TransaksiRepository $transaksiRepository
    ){}

    public function findByToko($toko_id)
    {
        return $this->diskonRepository->findByToko($toko_id);
    }

    public function findById($id)
    {
        return $this->diskonRepository->findById($id);
    }

    public function create($request): void
    {
        $data = [
            "toko_id"   => $request->post("toko_id"),
            "nama"      => $request->post("nama"),
            "type"      => $request->post("type"),
            "nominal"   => $request->post("nominal"),
        ];
        $this->diskonRepository->create($data);
    }

    public function edit($id, $request): void
    {
        $data = [
            "toko_id"   => $request->post("toko_id"),
            "nama"      => $request->post("nama"),
            "type"      => $request->post("type"),
            "nominal"   => $request->post("nominal"),
        ];
        $this->diskonRepository->edit($id, $data);
    }

    public function delete($diskon_id): void
    {
        $check = $this->transaksiRepository->countByDiskon($diskon_id);
        if ($check == 0) {
            $this->diskonRepository->delete($diskon_id);
        } else {
            abort(400, "Diskon sudah pernah digunakan dalam transaksi, layanan tidak bisa dihapus");
        }
    }
}
