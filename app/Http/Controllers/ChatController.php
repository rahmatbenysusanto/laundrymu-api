<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\Create;
use App\Http\Services\ChatService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function __construct(
        protected ResponseService $responseService,
        protected ChatService $chatService
    ) {}

    public function create(Create $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->chatService->create($request);
            DB::commit();
            return $this->responseService->responseNotData(true, 'Create chat successfully', 201);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::channel('chat')->error($err->getMessage());
            return $this->responseService->responseErrors(false, 'Create chat failed', $err->getMessage(), 400);
        }
    }

    public function getChat($tokoId): \Illuminate\Http\JsonResponse
    {
        $result = $this->chatService->findByTokoId($tokoId);
        return $this->responseService->responseWithData(true, 'Get chat successfully', $result, 200);
    }
}
