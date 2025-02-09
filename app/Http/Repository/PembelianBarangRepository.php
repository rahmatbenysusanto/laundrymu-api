<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;

class PembelianBarangRepository
{
    public function create($data): int
    {
        return DB::table('inv_pembelian_barang')->insertGetId($data);
    }

    public function findByOutletId($outletId): \Illuminate\Support\Collection
    {
        return DB::table('inv_pembelian_barang')
            ->where('inv_pembelian_barang.outlet_id', $outletId)
            ->leftJoin('inv_pembelian_barang_detail', 'inv_pembelian_barang_detail.pembelian_id', '=', 'inv_pembelian_barang.id')
            ->leftJoin('inv_barang', 'inv_barang.id', '=', 'inv_pembelian_barang_detail.barang_id')
            ->leftJoin('inv_supplier', 'inv_supplier.id', '=', 'inv_pembelian_barang.supplier_id')
            ->select([
                'inv_barang.nama AS nama_barang',
                'inv_pembelian_barang_detail.qty',
                'inv_pembelian_barang_detail.harga',
                'inv_pembelian_barang.tanggal_pembelian',
                'inv_pembelian_barang.total_harga',
                'inv_pembelian_barang.status_pembayaran',
                'inv_supplier.nama AS nama_supplier',
            ])
            ->latest('inv_pembelian_barang.tanggal_pembelian')
            ->get();
    }
}
