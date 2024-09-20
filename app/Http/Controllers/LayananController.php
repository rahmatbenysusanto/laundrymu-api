<?php

namespace App\Http\Controllers;

use App\Http\Requests\Layanan\CreateRequest;
use App\Http\Requests\Layanan\DeleteRequest;
use App\Http\Requests\Layanan\FindRequest;
use App\Http\Requests\Layanan\UpdateRequest;
use App\Http\Service\LayananService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LayananController extends Controller
{
    public function __construct(
        protected LayananService $layananService
    ) {}

    public function find(FindRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            if ($request->query('outlet_id') != null) {
                $layanan = $this->layananService->getByOutletId($request->query('outlet_id'));
            } else if ($request->query('id') != null) {
                $layanan = $this->layananService->findById($request->query('id'));
            } else {
                abort(400, 'Request Parameter Failed');
            }

            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Get Layanan Successfully',
                'data'      => $layanan
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Get Layanan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function create(CreateRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->layananService->create($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Create Layanan Successfully',
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create Layanan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function update(UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->layananService->update($request->query('id'), $request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Update Layanan Successfully',
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Update Layanan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function delete(DeleteRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->layananService->delete($request->query('id'));
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Delete Layanan Successfully',
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Delete Layanan Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
