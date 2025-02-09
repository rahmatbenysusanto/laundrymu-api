<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;

class InventoryStockRepository
{
    public function create($data): int
    {
        return DB::table('inv_stock')->insertGetId($data);
    }

    public function findByOutletId($outletId): \Illuminate\Support\Collection
    {
        return DB::table('inv_stock')
            ->where('inv_stock.outlet_id', $outletId)
            ->leftJoin('inv_barang', 'inv_barang.id', '=', 'inv_stock.barang_id')
            ->leftJoin('inv_satuan', 'inv_satuan.id', '=', 'inv_barang.satuan_id')
            ->select([
                'inv_barang.id AS barang_id',
                'inv_barang.nama AS nama_barang',
                'inv_barang.stock_minimum',
                'inv_stock.stock',
                'inv_satuan.nama AS nama_satuan',
            ])
            ->get();
    }

    public function increment($outletId, $barangId, $qty): void
    {
        DB::table('inv_stock')
            ->where('outlet_id', $outletId)
            ->where('barang_id', $barangId)
            ->increment('stock', $qty);
    }

    public function decrement($outletId, $barangId, $qty): void
    {
        DB::table('inv_stock')
            ->where('outlet_id', $outletId)
            ->where('barang_id', $barangId)
            ->decrement('stock', $qty);
    }
}
