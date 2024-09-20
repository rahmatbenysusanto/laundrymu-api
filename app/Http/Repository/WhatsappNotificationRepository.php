<?php

namespace App\Http\Repository;

use App\Models\WhatsappNotification;

class WhatsappNotificationRepository
{
    public function create($data)
    {
        return WhatsappNotification::create($data);
    }

    public function update($id, $data): void
    {
        WhatsappNotification::where('id', $id)->update($data);
    }
}
