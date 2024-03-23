<?php

namespace App\Http\Services;

use App\Http\Repository\AbsenPegawaiRepository;
use App\Http\Repository\UserHasTokoRepository;
use Illuminate\Support\Carbon;

class AbsenPegawaiService
{
    public function __construct(
        protected AbsenPegawaiRepository $absenPegawaiRepository,
        protected UserHasTokoRepository $userHasTokoRepository,
    ) {}

    public function create($toko_id, $pegawai_id, $status, $tanggal, $keterangan): void
    {
        $absen = $this->absenPegawaiRepository->findByPegawaiIdAndTanggal($pegawai_id, $tanggal);
        if ($absen == null) {
            $this->absenPegawaiRepository->create([
                'toko_id'       => $toko_id,
                'pegawai_id'    => $pegawai_id,
                'status'        => $status,
                'tanggal'       => $tanggal,
                'keterangan'    => $keterangan
            ]);
        } else {
            abort(400, 'Absen ditanggal tersebut sudah ada');
        }
    }

    public function findAbsensiPegawai($toko_id): array
    {
        $pegawai = $this->userHasTokoRepository->findByTokoId($toko_id);
        $result = [];
        foreach ($pegawai as $peg) {
            $absen = $this->absenPegawaiRepository->pegawaiMasukBulanan($peg->user->id);
            $result[] = [
                $peg,
                $absen
            ];
        }

        return $result;
    }

    public function findByPegawaiId($pegawai_id): array
    {
        $pegawai = $this->userHasTokoRepository->findByUserId($pegawai_id);

        return [
            $pegawai,
            $this->absenPegawaiRepository->pegawaiMasukBulanan($pegawai->user->id),
            $this->absenPegawaiRepository->findByPegawaiIdMonthYear($pegawai_id)
        ];
    }

    public function findByPegawaiIdCustomDate($pegawai_id, $mulai, $selesai): array
    {
        $pegawai = $this->userHasTokoRepository->findByUserId($pegawai_id);

        return [
            $pegawai,
            $this->absenPegawaiRepository->pegawaiMasukBulananCustomDate($pegawai->user->id, $mulai, $selesai),
            $this->absenPegawaiRepository->findByPegawaiIdCustomDate($pegawai_id, $mulai, $selesai)
        ];
    }
}
