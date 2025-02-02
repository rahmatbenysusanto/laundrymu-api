<?php

namespace App\Http\Service;

use App\Http\Repository\BarangRepository;
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

    public function createPembelian($request)
    {
        $pembelian_id = $this->pembelianBarangRepository->create([
            'outlet_id'         => $request->outlet_id,
            'inbound_number'    => '',
            'jumlah'            => '',
            'total_harga'       => '',
            'status_pembayaran' => '',
            'supplier_id'       => '',
            'tanggal_pembelian' => '',
            'note'              => '',
            'created_at'        => now()->timestamp * 1000,
            'updated_at'        => now()->timestamp * 1000,
        ]);

        $this->pembelianBarangDetailRepository->create([
            'outlet_id'     => $request->outlet_id,
            'barang_id'     => '',
            'qty'           => '',
            'harga'         => '',
            'total_harga'   => '',
            'created_at'    => now()->timestamp * 1000,
            'updated_at'    => now()->timestamp * 1000,
        ]);
    }
}
