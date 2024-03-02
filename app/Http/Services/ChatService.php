<?php

namespace App\Http\Services;

use App\Http\Repository\ChatRepository;

class ChatService
{
    public function __construct(
        protected ChatRepository $chatRepository
    ) {}

    public function create($data): void
    {
        $this->chatRepository->create([
            "toko_id"   => $data->toko_id,
            "role"      => $data->role,
            "chat"      => $data->chat
        ]);
    }

    public function findByTokoId($tokoId)
    {
        return $this->chatRepository->findByTokoId($tokoId);
    }
}
