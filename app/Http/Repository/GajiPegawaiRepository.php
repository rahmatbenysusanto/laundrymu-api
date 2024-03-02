<?php

namespace App\Http\Repository;

use App\Models\GajiPegawai;

class GajiPegawaiRepository
{
    public function create($data): void
    {
        GajiPegawai::create($data);
    }

    public function findByTokoId($toko_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return GajiPegawai::with("toko", "pegawai")
            ->where("toko_id", $toko_id)
            ->get();
    }

    public function findByPegawaiId($pegawaiId)
    {
        return GajiPegawai::where('pegawai_id', $pegawaiId)->get();
    }
}
