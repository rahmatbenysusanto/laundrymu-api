<?php

namespace App\Http\Controllers;

use App\Http\Service\AlamatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlamatController extends Controller
{
    public function __construct(
        protected AlamatService  $alamatService
    ) {}

    public function getProvinsi(): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->alamatService->getProvinsi();
            return response()->json([
                'status'    => true,
                'message'   => 'Get Provinsi Successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Provinsi Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function getKota(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->alamatService->getKota($request->get('nama_provinsi'));
            return response()->json([
                'status'    => true,
                'message'   => 'Get Kota Successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Kota Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function getKecamatan(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->alamatService->getKecamatan($request);
            return response()->json([
                'status'    => true,
                'message'   => 'Get Kecamatan Successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Kecamatan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function getKelurahan(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->alamatService->getKelurahan($request);
            return response()->json([
                'status'    => true,
                'message'   => 'Get Kelurahan Successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Kelurahan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function getKodePos(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->alamatService->getKodePos($request);
            return response()->json([
                'status'    => true,
                'message'   => 'Get Kode Pos Successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Kode Pos Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
