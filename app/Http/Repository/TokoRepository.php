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
        return Toko::where('toko_id', $tokoId)->first();
    }

    public function create($data): void
    {
        Toko::create($data);
    }
}
