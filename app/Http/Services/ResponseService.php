<?php

namespace App\Http\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ResponseService
{
    public function responseWithData($status, $message, $data, $httpStatus): JsonResponse
    {
        return response()->json([
            "status"    => $status,
            "message"   => $message,
            "data"      => $data
        ], $httpStatus);
    }

    public function responseNotData($status, $message, $httpStatus): JsonResponse
    {
        return response()->json([
            "status"    => $status,
            "message"   => $message,
        ], $httpStatus);
    }

    public function responseErrors($status, $message, $errors, $httpStatus): JsonResponse
    {
        // Record Log With Slack
        Log::channel('slackLog')->error($errors);

        return response()->json([
            "status"    => $status,
            "message"   => $message,
            "errors"    => $errors
        ], $httpStatus);
    }
}
