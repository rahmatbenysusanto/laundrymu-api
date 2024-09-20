<?php

namespace App\Http\Controllers;

use App\Http\Requests\Parfum\CreateRequest;
use App\Http\Requests\Parfum\DeleteRequest;
use App\Http\Requests\Parfum\FindRequest;
use App\Http\Requests\Parfum\UpdateRequest;
use App\Http\Service\ParfumService;
use Illuminate\Support\Facades\DB;

class ParfumController extends Controller
{
    public function __construct(
       protected ParfumService $parfumService
    ) {}

    public function create(CreateRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->parfumService->create($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Create parfum successfully'
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create parfum failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function find(FindRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->query('id') !== null) {
                $parfum = $this->parfumService->findById($request->query('id'));
            } elseif ($request->query('outlet_id') !== null) {
                $parfum = $this->parfumService->findByOutletId($request->query('outlet_id'));
            } else {
                abort(404, 'Request Failed, Params not found.');
            }

            return response()->json([
                'status'    => true,
                'message'   => 'Get parfum successfully',
                'data'      => $parfum
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => $err->getMessage()
            ], 400);
        }
    }

    public function update(UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->parfumService->update($request->query('id'), $request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Update parfum successfully'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Update parfum failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function delete(DeleteRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->parfumService->delete($request->query('id'));
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Delete parfum successfully'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Delete parfum failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
