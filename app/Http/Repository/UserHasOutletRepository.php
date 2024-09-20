<?php

namespace App\Http\Repository;

use App\Models\UserHasOutlet;

class UserHasOutletRepository
{
    public function create($data): void
    {
        UserHasOutlet::create($data);
    }
}
