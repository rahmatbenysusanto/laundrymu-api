<?php

namespace App\Http\Controllers;

use App\Http\Requests\Outlet\CreateRequest;
use App\Http\Requests\Outlet\FindRequest;
use App\Http\Requests\Outlet\PerpanjangLisensiRequest;
use App\Http\Requests\Outlet\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    public function create(CreateRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            DB::commit();
            return response()->json([
                'success'   => true,
                'message'   => 'Create Outlet Successfully'
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'message'   => 'Create Outlet Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function perpanjangLisensi(PerpanjangLisensiRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            DB::commit();
            return response()->json([
                'success'   => true,
                'message'   => 'Perpanjang Lisensi Outlet Successfully'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'message'   => 'Create Outlet Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function findById(FindRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            DB::commit();
            return response()->json([
                'success'   => true,
                'message'   => 'Find Outlet Successfully'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'message'   => 'Find Outlet Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function findByUserId(FindRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            DB::commit();
            return response()->json([
                'success'   => true,
                'message'   => 'Find Outlet Successfully'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
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
                'success'   => true,
                'message'   => 'Update Outlet Successfully'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'message'   => 'Update Outlet Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
