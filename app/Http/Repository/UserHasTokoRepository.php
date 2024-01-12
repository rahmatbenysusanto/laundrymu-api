<?php

namespace App\Http\Repository;

use App\Models\UserHasToko;

class UserHasTokoRepository
{
    public function create($data): void
    {
        UserHasToko::create($data);
    }

    public function findByTokoId($tokoId): \Illuminate\Database\Eloquent\Collection|array
    {
        return UserHasToko::with(['user' => function ($user) {
            $user->select([
                'id',
                'nama',
                'no_hp'
            ]);
        }])->where('toko_id', $tokoId)->get();
    }
}
