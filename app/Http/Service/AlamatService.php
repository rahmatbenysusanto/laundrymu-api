<?php

namespace App\Http\Service;

use App\Http\Repository\KodePosRepository;

class AlamatService
{
    public function __construct(
        protected KodePosRepository $kodePosRepository
    ) {}

    public function getProvinsi()
    {
        return $this->kodePosRepository->getProvinsi();
    }

    public function getKota($nama_provinsi)
    {
        return $this->kodePosRepository->getKota($nama_provinsi);
    }

    public function getKecamatan($request)
    {
        return $this->kodePosRepository->getKecamatan($request->nama_provinsi, $request->nama_kota);
    }

    public function getKelurahan($request)
    {
        return $this->kodePosRepository->getKelurahan($request->nama_provinsi, $request->nama_kota, $request->nama_kecamatan);
    }

    public function getKodePos($request)
    {
        return $this->kodePosRepository->getKodePos($request->nama_provinsi, $request->nama_kota, $request->nama_kecamatan, $request->nama_kelurahan);
    }
}
