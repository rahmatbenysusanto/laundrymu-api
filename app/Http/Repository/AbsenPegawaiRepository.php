<?php

namespace App\Http\Repository;

use App\Models\AbsenPegawai;
use Illuminate\Support\Carbon;

class AbsenPegawaiRepository
{
    public function create($data): void
    {
        AbsenPegawai::create($data);
    }

    public function findByPegawaiIdMonthYear($pegawai_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return AbsenPegawai::with("toko", "pegawai")
            ->where("pegawai_id", $pegawai_id)
            ->where('tanggal', '>', date('Y-m-d', strtotime('-1 months')))
            ->where('tanggal', '<', date('Y-m-d', time()))
            ->get();
    }

    public function findByPegawaiIdDayMonthYear($pegawai_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return AbsenPegawai::with("toko", "pegawai")
            ->where("pegawai_id", $pegawai_id)
            ->whereDay('tanggal', date('d', time()))
            ->whereMonth('tanggal', date('m', time()))
            ->whereYear('tanggal', date('Y', time()))
            ->get();
    }

    public function findByPegawaiIdCustomDate($pegawai_id, $start, $finish): \Illuminate\Database\Eloquent\Collection|array
    {
        return AbsenPegawai::with("toko", "pegawai")
            ->where("pegawai_id", $pegawai_id)
            ->where('tanggal', '>', $start)
            ->where('tanggal', '<', $finish)
            ->get();
    }

    public function pegawaiMasukBulanan($pegawai_id): int
    {
        return AbsenPegawai::with("toko", "pegawai")
            ->where("pegawai_id", $pegawai_id)
            ->where('status', 'masuk')
            ->where('tanggal', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))
            ->where('tanggal', '<=', Carbon::now()->endOfMonth()->format('Y-m-d'))
            ->count();
    }

    public function pegawaiMasukBulananCustomDate($pegawai_id, $start, $finish): int
    {
        return AbsenPegawai::with("toko", "pegawai")
            ->where("pegawai_id", $pegawai_id)
            ->where('status', 'masuk')
            ->where('tanggal', '>', $start)
            ->where('tanggal', '<', $finish)
            ->count();
    }

    public function findByPegawaiIdAndTanggal($pegawai_id, $tanggal)
    {
        return AbsenPegawai::where('pegawai_id', $pegawai_id)->where('tanggal', $tanggal)->first();
    }
}
