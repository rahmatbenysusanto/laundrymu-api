<?php

namespace App\Http\Services;

use App\Http\Repository\BarangRepository;
use App\Http\Repository\InventoryRepository;
use App\Http\Repository\PembelianRepository;
use App\Http\Repository\PenggunaanRepository;

class BarangService
{
    public function __construct(
        protected BarangRepository $barangRepository,
        protected InventoryRepository $inventoryRepository,
        protected PembelianRepository $pembelianRepository,
        protected PenggunaanRepository $penggunaanRepository
    ) {}

    public function create($data): void
    {
        $barang = $this->barangRepository->create([
            "user_id"   => $data->user_id,
            "toko_id"   => $data->toko_id,
            "nama"      => $data->nama,
            "tipe"      => $data->tipe,
        ]);

        $this->inventoryRepository->create([
            "barang_id" => $barang->id,
            "stok"      => $data->stok
        ]);

        if ($data->stok != 0) {
            $this->pembelianRepository->create([
                "user_id"   => $data->user_id,
                "toko_id"   => $data->toko_id,
                "barang_id" => $barang->id,
                "jumlah"    => $data->stok,
                "harga"     => $data->harga,
                "tanggal"   => $data->tanggal,
            ]);
        }
    }

    public function tambahStok($data): void
    {
        $this->inventoryRepository->incrementStok($data->barang_id, $data->stok);

        $this->pembelianRepository->create([
            "user_id"   => $data->user_id,
            "toko_id"   => $data->toko_id,
            "barang_id" => $data->barang_id,
            "jumlah"    => $data->stok,
            "harga"     => $data->harga,
            "tanggal"   => $data->tanggal,
        ]);
    }

    public function kurangiStok($data): void
    {
        $this->inventoryRepository->decrementStok($data->barang_id, $data->stok);

        $this->penggunaanRepository->create([
            "user_id"   => $data->user_id,
            "toko_id"   => $data->toko_id,
            "barang_id" => $data->barang_id,
            "jumlah"    => $data->stok,
            "tanggal"   => $data->tanggal,
        ]);
    }

    public function historiPembelian($tokoId): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->pembelianRepository->findByTokoId($tokoId);
    }

    public function historiPenggunaan($tokoId): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->penggunaanRepository->findByTokoId($tokoId);
    }

    public function listStokBarang($tokoId): \Illuminate\Support\Collection
    {
        return $this->barangRepository->getStokByTokoId($tokoId);
    }
}
