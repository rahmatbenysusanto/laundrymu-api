<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\CreateRequest;
use App\Http\Requests\Chat\FindRequest;
use App\Http\Service\ChatService;
use App\Http\Service\LogService;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function __construct(
        protected ChatService $chatService,
        protected LogService $logService
    ) {}

    public function create(CreateRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->chatService->create($request);
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Send Chat Successfully'
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            $this->logService->log('', '', $err->getMessage());
            return response()->json([
                'status'    => false,
                'message'   => 'Send Chat Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function getByOutletId(FindRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $result = $this->chatService->getByOutletId($request->query('outlet_id'));
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Get Chat Successfully',
                'data'      => $result
            ], 201);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Get Chat Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
