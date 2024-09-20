<?php

namespace App\Http\Repository;

use App\Models\TransaksiHistory;

class TransaksiHistoryRepository
{
    public function create($data): void
    {
        TransaksiHistory::create($data);
    }
}
