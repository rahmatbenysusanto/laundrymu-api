<?php

namespace App\Http\Controllers;

use App\Http\Repository\PembayaranRepository;
use App\Http\Requests\Pembayaran\CreateRequest;
use App\Http\Requests\Pembayaran\DeleteRequest;
use App\Http\Requests\Pembayaran\FindRequest;
use App\Http\Requests\Pembayaran\UpdateRequest;
use App\Http\Service\PembayaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function __construct(
        protected PembayaranService  $pembayaranService
    ) {}

    public function create(CreateRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pembayaranService->create($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Create pembayaran successfully'
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create pembayaran failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function find(FindRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->query('id') !== null) {
                $pembayaran = $this->pembayaranService->findById($request->query('id'));
            } elseif ($request->query('outlet_id') !== null) {
                $pembayaran = $this->pembayaranService->findByOutletId($request->query('outlet_id'));
            } else {
                abort(404, 'Request Failed, Params not found.');
            }

            return response()->json([
                'status'    => true,
                'message'   => 'Get pembayaran successfully',
                'data'      => $pembayaran
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
            $this->pembayaranService->update($request->query('id'), $request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Update pembayaran successfully'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Update pembayaran failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function delete(DeleteRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->pembayaranService->delete($request->query('id'));
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Delete pembayaran successfully'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Delete pembayaran failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
