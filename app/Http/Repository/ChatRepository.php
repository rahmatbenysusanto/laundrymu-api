<?php

namespace App\Http\Repository;

use App\Models\Chat;

class ChatRepository
{
    public function create($data): void
    {
        Chat::create($data);
    }

    public function getByOutletId($outletId)
    {
        return Chat::where('outlet_id', $outletId)->get();
    }
}
