<?php

namespace App\Http\Repository;

use App\Models\UserHasOutlet;

class UserHasOutletRepository
{
    public function create($data): void
    {
        UserHasOutlet::create($data);
    }

    public function getByUserId($userId): \Illuminate\Database\Eloquent\Collection
    {
        return UserHasOutlet::with(['outlet' => function ($outlet) {
            return $outlet->select([
                'id',
                'nama',
                'expired',
                'status'
            ]);
        }])->where('user_id', $userId)->get();
    }
}
