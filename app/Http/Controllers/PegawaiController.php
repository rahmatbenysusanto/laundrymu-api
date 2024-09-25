<?php

namespace App\Http\Controllers;

use App\Http\Service\PegawaiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    public function __construct(
        protected PegawaiService  $pegawaiService
    ) {}

    public function find(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->query('id') !== null) {
                $result = $this->pegawaiService->findById($request->query('id'));
            } elseif ($request->query('outlet_id') !== null) {
                $result = $this->pegawaiService->findByOutletId($request->query('outlet_id'));
            } else {
                abort(404, 'Request Failed, Params not found.');
            }

            return response()->json([
                'status'    => true,
                'message'   => 'Get Pegawai Successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Pegawai Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pegawaiService->create($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Create Pegawai Successfully',
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create Pegawai Failed',
                'errors'    => $err->getMessage(),
            ], 400);
        }
    }
}
