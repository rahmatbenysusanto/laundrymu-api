<?php

namespace App\Http\Repository;

use App\Models\KodePos;
use Illuminate\Support\Facades\Log;

class KodePosRepository
{
    public function getProvinsi()
    {
        return KodePos::select('nama_provinsi')->distinct()->get();
    }

    public function getKota($provinsi)
    {
        return KodePos::select([
            'nama_provinsi',
            'nama_kota',
        ])->where('nama_provinsi', $provinsi)
            ->groupBy('nama_provinsi', 'nama_kota', 'tipe_kota')
            ->get();
    }

    public function getKecamatan($provinsi, $kota)
    {
        return KodePos::select([
            'nama_provinsi',
            'nama_kota',
            'nama_kecamatan'
          ])->where('nama_provinsi', $provinsi)
            ->where('nama_kota', $kota)
            ->groupBy('nama_provinsi', 'nama_kota', 'tipe_kota', 'nama_kecamatan')
            ->get();
    }

    public function getKelurahan($provinsi, $kota, $kecamatan)
    {
        return KodePos::select([
            'nama_provinsi',
            'nama_kota',
            'nama_kecamatan',
            'nama_kelurahan'
        ])->where('nama_provinsi', $provinsi)
            ->where('nama_kota', $kota)
            ->where('nama_kecamatan', $kecamatan)
            ->get();
    }

    public function getKodePos($provinsi, $kota, $kecamatan, $kelurahan)
    {
        Log::info($kelurahan);
        return KodePos::select([
            'nama_kode_pos'
        ])->where('nama_provinsi', $provinsi)
            ->where('nama_kota', $kota)
            ->where('nama_kecamatan', $kecamatan)
            ->where('nama_kelurahan', $kelurahan)
            ->get();
    }
}
