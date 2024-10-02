<?php

namespace App\Http\Controllers;

use App\Http\Service\PengirimanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    public function __construct(
        protected PengirimanService $pengirimanService
    ) {}

    public function find(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->query('id') != null) {
                $pengiriman = $this->pengirimanService->findById($request->query('id'));
            } elseif ($request->query('outlet_id') != null) {
                $pengiriman = $this->pengirimanService->findByOutletId($request->query('outlet_id'));
            } else {
                abort(400, 'Parameter Tidak Sesuai');
            }

            return response()->json([
                'status'    => true,
                'message'   => 'Find Pengiriman Successfully',
                'data'      => $pengiriman
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Find Pengiriman Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Create Pengiriman Successfully',
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create Pengiriman Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
