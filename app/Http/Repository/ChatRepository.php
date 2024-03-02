<?php

namespace App\Http\Repository;

use App\Models\Chat;

class ChatRepository
{
    public function create($data): void
    {
        Chat::create($data);
    }

    public function findByTokoId($tokoId)
    {
        return Chat::where('toko_id', $tokoId)->get();
    }
}
