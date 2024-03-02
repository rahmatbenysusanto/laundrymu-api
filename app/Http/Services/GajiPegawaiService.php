<?php

namespace App\Http\Services;

use App\Http\Repository\GajiPegawaiRepository;

class GajiPegawaiService
{
    public function __construct(
        protected GajiPegawaiRepository $gajiPegawaiRepository
    ) {}

    public function create($data): void
    {
        $this->gajiPegawaiRepository->create([
            "toko_id"       => $data->toko_id,
            "pegawai_id"    => $data->pegawai_id,
            "gaji"          => $data->gaji,
            "tanggal"       => $data->tanggal,
        ]);
    }

    public function findByPegawaiId($pegawaiId)
    {
        return $this->gajiPegawaiRepository->findByPegawaiId($pegawaiId);
    }
}
