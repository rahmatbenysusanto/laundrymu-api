<?php

namespace App\Http\Controllers;

use App\Http\Service\DiskonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiskonController extends Controller
{
    public function __construct(
        protected DiskonService  $diskonService
    ) {}

    public function find(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->query('id') != null) {
                $diskon = $this->diskonService->findById($request->query('id'));
            } elseif ($request->query('outlet_id') != null) {
                $diskon = $this->diskonService->getByOutletId($request->query('outlet_id'));
            } else {
                abort(400, 'Parameter Salah');
            }

            return response()->json([
                'status'    => true,
                'message'   => 'Find Diskon Successfully',
                'data'      => $diskon
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Find Diskon Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->diskonService->create($request);
            DB::commit();

            return response()->json([
                'status'    => true,
                'message'   => 'Create Diskon Successfully'
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create Diskon Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->diskonService->update($request->query('id'), $request);
            DB::commit();

            return response()->json([
                'status'    => true,
                'message'   => 'Update Diskon Successfully'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Update Diskon Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->diskonService->delete($request->query('id'));
            DB::commit();

            return response()->json([
                'status'    => true,
                'message'   => 'Delete Diskon Successfully'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Delete Diskon Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
