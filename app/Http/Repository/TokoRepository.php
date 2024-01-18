<?php

namespace App\Http\Repository;

use App\Models\Toko;
use Illuminate\Database\Eloquent\Collection;

class TokoRepository
{
    public function getAll(): Collection
    {
        return Toko::all();
    }

    public function findByUser($userId)
    {
        return Toko::where('user_id', $userId)->get();
    }

    public function findById($tokoId)
    {
        return Toko::where('id', $tokoId)->first();
    }

    public function create($data)
    {
        return Toko::create($data);
    }

    public function update($id, $data): void
    {
        Toko::where('id', $id)->update($data);
    }
}
