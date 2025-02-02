<?php

namespace App\Http\Controllers;

use App\Http\Requests\Outlet\CreateRequest;
use App\Http\Requests\Outlet\FindRequest;
use App\Http\Requests\Outlet\PerpanjangLisensiRequest;
use App\Http\Requests\Outlet\UpdateRequest;
use App\Http\Service\OutletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OutletController extends Controller
{
    public function __construct(
        protected OutletService $outletService
    ) {}

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->outletService->create($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Create Outlet Successfully'
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create Outlet Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function perpanjangLisensi(PerpanjangLisensiRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->outletService->perpanjangLisensi($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Perpanjang Lisensi Outlet Successfully'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create Outlet Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function findById(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $outlet = $this->outletService->findById($request->query('id'), $request->attributes->get('user_id'));
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Find Outlet Successfully',
                'data'      => $outlet
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Find Outlet Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function findByUserId(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $result = $this->outletService->findByUserId($request->attributes->get('user_id'));
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Find Outlet Successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Find Outlet Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function update(UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Update Outlet Successfully'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Update Outlet Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function historyPembayaran(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $history = $this->outletService->historyPembayaran($request->query('outlet_id'));

            return response()->json([
                'status'    => true,
                'message'   => 'History Pembayaran Outlet Successfully',
                'data'      => $history
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get History Pembayaran Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function findByNomorPembayaran(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $history = $this->outletService->findByNomorPembayaran($request->query('nomor_pembayaran'));

            return response()->json([
                'status'    => true,
                'message'   => 'History Pembayaran Outlet Successfully',
                'data'      => $history
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get History Pembayaran Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function uploadProfile(Request $request)
    {
        $url = Storage::disk('s3')->url('public-file.txt');
        return $url;
    }
}
