<?php

namespace App\Http\Controllers;

use App\Http\Repository\GajiPegawaiRepository;
use App\Http\Requests\Gaji\Create;
use App\Http\Services\AbsenPegawaiService;
use App\Http\Services\GajiPegawaiService;
use App\Http\Services\PegawaiService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PegawaiController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected PegawaiService $pegawaiService,
        protected AbsenPegawaiService $absenPegawaiService,
        protected GajiPegawaiService $gajiPegawaiService
    ){}

    public function getByTokoId($toko_id): \Illuminate\Http\JsonResponse
    {
        $pegawai = $this->pegawaiService->getByTokoId($toko_id);
        return $this->responseService->responseWithData(true, 'Get pegawai by toko successfully', $pegawai, 200);
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pegawaiService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Create pegawai successfully', 201);
        } catch (\Exception $err) {
            Log::channel('pegawai')->error($err->getMessage());
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Create pegawai failed', $err->getMessage(), 400);
        }
    }

    public function createAbsen(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->absenPegawaiService->create(
                $request->post('toko_id'),
                $request->post('pegawai_id'),
                $request->post('status'),
                $request->post('tanggal'),
                $request->post('keterangan')
            );
            DB::commit();
            return $this->responseService->responseNotData(true, 'Create absensi success', 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseNotData(false, 'Create absensi failed', 400);
        }
    }

    public function findAbsensiPegawai($toko_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->absenPegawaiService->findAbsensiPegawai($toko_id);
        return $this->responseService->responseWithData(true, 'Get pegawai by toko successfully', $result, 200);
    }

    public function findByPegawaiId($pegawai_id): \Illuminate\Http\JsonResponse
    {
        $result = $this->absenPegawaiService->findByPegawaiId($pegawai_id);
        return $this->responseService->responseWithData(true, 'Get pegawai by id successfully', $result, 200);
    }

    public function findByPegawaiIdCustomDate($pegawai_id, $mulai, $selesai): \Illuminate\Http\JsonResponse
    {
        $result = $this->absenPegawaiService->findByPegawaiIdCustomDate($pegawai_id, $mulai, $selesai);
        return $this->responseService->responseWithData(true, 'Get pegawai by id successfully', $result, 200);
    }

    public function createGajiPegawai(Create $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->gajiPegawaiService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Create gaji successfully', 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return $this->responseService->responseErrors(false, 'Create gaji failed', $err->getMessage(), 400);
        }
    }
}
