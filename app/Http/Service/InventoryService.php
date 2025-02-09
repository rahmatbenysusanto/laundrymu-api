<?php

namespace App\Http\Service;

use App\Http\Repository\BarangRepository;
use App\Http\Repository\InventoryStockDetailRepository;
use App\Http\Repository\InventoryStockRepository;
use App\Http\Repository\PembelianBarangDetailRepository;
use App\Http\Repository\PembelianBarangRepository;
use App\Http\Repository\SatuanRepository;
use App\Http\Repository\SupplierRepository;
use Illuminate\Support\Collection;

class InventoryService
{
    public function __construct(
        protected SatuanRepository $satuanRepository,
        protected BarangRepository $barangRepository,
        protected InventoryStockRepository $inventoryStockRepository,
        protected InventoryStockDetailRepository $inventoryStockDetailRepository,
        protected SupplierRepository $supplierRepository,
        protected PembelianBarangRepository $pembelianBarangRepository,
        protected PembelianBarangDetailRepository $pembelianBarangDetailRepository,
    ) {}

    public function satuan(): Collection
    {
        return $this->satuanRepository->all();
    }

    public function getInventory($outlet_id): Collection
    {
        return $this->inventoryStockRepository->findByOutletId($outlet_id);
    }

    public function getSupplierByOutletId($outlet_id): Collection
    {
        return $this->supplierRepository->findByOutletId($outlet_id);
    }

    public function createSupplier($request): void
    {
        $this->supplierRepository->create([
            'nama'          => $request->nama,
            'created_at'    => now()->timestamp * 1000,
            'updated_at'    => now()->timestamp * 1000,
        ]);
    }

    public function createBarang($request): void
    {
        $barang_id = $this->barangRepository->create([
            'outlet_id'     => $request->outlet_id,
            'nama'          => $request->nama,
            'satuan_id'     => $request->satuan_id,
            'stock_minimum' => $request->stock_minimum,
            'created_at'    => now()->timestamp * 1000,
            'updated_at'    => now()->timestamp * 1000,
        ]);

        $this->inventoryStockRepository->create([
            'barang_id'     => $barang_id,
            'outlet_id'     => $request->outlet_id,
            'stock'         => 0,
            'created_at'    => now()->timestamp * 1000,
            'updated_at'    => now()->timestamp * 1000,
        ]);
    }

    public function createPembelian($request): void
    {
        $pembelian_id = $this->pembelianBarangRepository->create([
            'outlet_id'         => $request->outlet_id,
            'inbound_number'    => 'PO-'.date('ymd').rand(0000,999),
            'jumlah'            => $request->qty,
            'total_harga'       => $request->qty * $request->harga,
            'status_pembayaran' => $request->status_pembayaran,
            'supplier_id'       => $request->supplier_id,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'note'              => $request->note,
            'created_at'        => now()->timestamp * 1000,
            'updated_at'        => now()->timestamp * 1000,
        ]);

        $pembelian_detail = $this->pembelianBarangDetailRepository->create([
            'outlet_id'     => $request->outlet_id,
            'barang_id'     => $request->barang_id,
            'pembelian_id'  => $pembelian_id,
            'qty'           => $request->qty,
            'harga'         => $request->harga,
            'total_harga'   => $request->qty * $request->harga,
            'created_at'    => now()->timestamp * 1000,
            'updated_at'    => now()->timestamp * 1000,
        ]);

        $this->inventoryStockRepository->increment($request->outlet_id, $request->barang_id, $request->qty);
        $this->inventoryStockDetailRepository->create([
            'outlet_id'         => $request->outlet_id,
            'barang_id'         => $request->barang_id,
            'pembelian_detail'  => $pembelian_detail,
            'qty'               => $request->qty,
            'harga'             => $request->harga,
            'created_at'        => now()->timestamp * 1000,
            'updated_at'        => now()->timestamp * 1000,
        ]);
    }

    public function getPembelian($outlet_id): Collection
    {
        return $this->pembelianBarangRepository->findByOutletId($outlet_id);
    }
}
