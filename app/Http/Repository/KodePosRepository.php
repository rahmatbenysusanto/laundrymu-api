<?php

namespace App\Http\Repository;

use App\Models\KodePos;

class KodePosRepository
{
    public function getProvinsi()
    {
        return KodePos::select([
            'nama_provinsi'
        ])->groupBy('nama_provinsi')
            ->get();
    }

    public function getKota($provinsi)
    {
        return KodePos::select([
            'nama_provinsi',
            'nama_kota'
        ])
            ->where('nama_provinsi', $provinsi)
            ->groupBy('nama_kota')
            ->get();
    }

    public function getKecamatan($kota, $provinsi)
    {
        return KodePos::select([
            'nama_provinsi',
            'nama_kota',
            'nama_kecamatan'
        ])
            ->where('nama_provinsi', $provinsi)
            ->where('nama_kota', $kota)
            ->groupBy('nama_kecamatan')
            ->get();
    }

    public function getKelurahan($kecamatan, $kota, $provinsi)
    {
        return KodePos::select([
            'nama_provinsi',
            'nama_kota',
            'nama_kecamatan',
            'nama_kelurahan'
        ])
            ->where('nama_provinsi', $provinsi)
            ->where('nama_kota', $kota)
            ->where('nama_kecamatan', $kecamatan)
            ->groupBy('nama_kelurahan')
            ->get();
    }

    public function getKodePos($kelurahan, $kecamatan, $kota, $provinsi)
    {
        return KodePos::select([
            'nama_provinsi',
            'nama_kota',
            'nama_kecamatan',
            'nama_kelurahan',
            'nama_kode_pos'
        ])
            ->where('nama_provinsi', $provinsi)
            ->where('nama_kota', $kota)
            ->where('nama_kecamatan', $kecamatan)
            ->where('nama_kelurahan', $kelurahan)
            ->get();
    }
}
