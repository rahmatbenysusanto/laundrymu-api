<?php

namespace App\Http\Controllers;

use App\Http\Service\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function findByUserId(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->notificationService->findByUserId($request->attributes->get('user_id'));
            return response()->json([
                'status'    => true,
                'message'   => 'Get Notification Successfully',
                'data'      => $result
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => $err->getMessage(),
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function countNotification(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->notificationService->count($request->attributes->get('user_id'));
            return response()->json([
                'status'    => true,
                'message'   => 'Get Notification Successfully',
                'data'      => $result
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => $err->getMessage(),
                'errors'    => $err->getMessage()
            ], 400);
        }
    }
}
