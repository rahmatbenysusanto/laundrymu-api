<?php

namespace App\Http\Services;

use App\Http\Repository\KodePosRepository;

class KodePosService
{
    public function __construct(
        protected KodePosRepository $kodePosRepository
    ) {}

    public function getProvinsi()
    {
        return $this->kodePosRepository->getProvinsi();
    }

    public function getKota($provinsi)
    {
        return $this->kodePosRepository->getKota($provinsi);
    }

    public function getKecamatan($kota, $provinsi)
    {
        return $this->kodePosRepository->getKecamatan($kota, $provinsi);
    }

    public function getKelurahan($kecamatan, $kota, $provinsi)
    {
        return $this->kodePosRepository->getKelurahan($kecamatan, $kota, $provinsi);
    }

    public function getKodePos($kelurahan, $kecamatan, $kota, $provinsi)
    {
        return $this->kodePosRepository->getKodePos($kelurahan, $kecamatan, $kota, $provinsi);
    }
}
