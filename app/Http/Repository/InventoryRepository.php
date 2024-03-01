<?php

namespace App\Http\Repository;

use App\Models\Inventory;

class InventoryRepository
{
    public function findByBarangId()
    {

    }

    public function create($data): void
    {
        Inventory::create($data);
    }

    public function incrementStok($barangId, $stok): void
    {
        Inventory::where('barang_id', $barangId)->increment('stok', $stok);
    }

    public function decrementStok($barangId, $stok): void
    {
        Inventory::where('barang_id', $barangId)->decrement('stok', $stok);
    }
}
