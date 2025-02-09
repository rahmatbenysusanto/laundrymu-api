<?php

namespace App\Http\Controllers;

use App\Http\Service\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class InventoryController extends Controller
{
    public function __construct(
        protected InventoryService $inventoryService
    ) {}

    public function satuan(): JsonResponse
    {
        $satuan = $this->inventoryService->satuan();

        return response()->json([
            'status'    => true,
            'message'   => 'Get Satuan Inventory Success',
            'data'      => $satuan
        ]);
    }

    public function getSupplierByOutletId(Request $request): JsonResponse
    {
        $supplier = $this->inventoryService->getSupplierByOutletId($request->query('outlet_id'));

        return response()->json([
            'status'    => true,
            'message'   => 'Get Supplier Inventory Success',
            'data'      => $supplier
        ]);
    }

    public function createSupplier(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->inventoryService->createSupplier($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Create Supplier Inventory Success',
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create Supplier Inventory Failed',
                'error'     => $err->getMessage(),
            ], 400);
        }
    }

    public function getInventory(Request $request): JsonResponse
    {
        $inventory = $this->inventoryService->getInventory($request->query('outlet_id'));

        return response()->json([
            'status'    => true,
            'message'   => 'Get Inventory Success',
            'data'      => $inventory
        ]);
    }

    public function createBarang(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->inventoryService->createBarang($request);
            DB::commit();

            return response()->json([
                'status'    => true,
                'message'   => 'Create Barang Inventory Success',
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create Barang Inventory Failed',
                'error'     => $err->getMessage(),
            ], 400);
        }
    }

    public function getPembelian(Request $request): JsonResponse
    {
        $pembelian = $this->inventoryService->getPembelian($request->query('outlet_id'));

        return response()->json([
            'status'    => true,
            'message'   => 'Get Pembelian Inventory Success',
            'data'      => $pembelian
        ]);
    }

    public function createPembelian(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->inventoryService->createPembelian($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Create Pembelian Inventory Success',
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create Pembelian Inventory Failed',
                'error'     => $err->getMessage(),
            ], 400);
        }
    }
}
