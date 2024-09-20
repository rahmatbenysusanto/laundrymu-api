<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pelanggan\CreateRequest;
use App\Http\Requests\Pelanggan\FindRequest;
use App\Http\Requests\Pelanggan\UpdateRequest;
use App\Http\Service\PelangganService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function __construct(
        protected PelangganService $pelangganService
    ) {}

    public function create(CreateRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $result = $this->pelangganService->create($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Create Pelanggan Successfully',
                'data'      => $result
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create Pelanggan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function find(FindRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            if ($request->query('id') !== null) {
                $result = $this->pelangganService->findById($request->query('id'));
            } elseif ($request->query('outlet_id') !== null) {
                $result = $this->pelangganService->findByOutletId($request->query('outlet_id'));
            } else {
                abort(404, 'Request Failed, Params not found.');
            }

            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Find Pelanggan Successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Find Pelanggan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function update(UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pelangganService->update($request->query('id'), $request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Update Pelanggan Successfully',
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Update Pelanggan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
