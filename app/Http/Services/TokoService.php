<?php

namespace App\Http\Services;

use App\Http\Repository\TokoRepository;
use Illuminate\Database\Eloquent\Collection;

class TokoService
{
    public function __construct(
        protected TokoRepository $tokoRepository
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
        $data = [
            "user_id"   => $request->post("user_id"),
            "nama"      => $request->post("nama"),
            "no_hp"     => $request->post("no_hp"),
            "logo"      => $request->post("logo"),
            "status"    => "active",
            "expired"   => date('Y-m-d', strtotime('+1 month')),
            "alamat"    => $request->post("alamat"),
            "provinsi"  => $request->post("provinsi"),
            "kabupaten" => $request->post("kabupaten"),
            "kecamatan" => $request->post("kecamatan"),
            "kelurahan" => $request->post("kelurahan"),
            "kode_pos"  => $request->post("kode_pos"),
            "lat"       => $request->post("lat"),
            "long"      => $request->post("long")
        ];
        $this->tokoRepository->create($data);
    }
}