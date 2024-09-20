<?php

namespace App\Http\Service;

use App\Http\Repository\ChatRepository;
use App\Models\Chat;

class ChatService
{
    public function __construct(
        protected ChatRepository $chatRepository
    ) {}

    public function create($request): void
    {
        $this->chatRepository->create([
            'outlet_id' => $request->outlet_id,
            'chat'      => $request->chat,
            'role'      => $request->role,
        ]);
    }

    public function getByOutletId($outletId)
    {
        return $this->chatRepository->getByOutletId($outletId);
    }
}
