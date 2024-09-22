<?php

namespace App\Http\Service;

use Illuminate\Support\Facades\Log;

class LogService
{
    public function log($channel, $type, $message): void
    {
        switch ($type) {
            case 'emergency':
                Log::channel($channel)->emergency($message);
                break;
            case 'alert':
                Log::channel($channel)->alert($message);
                break;
            case 'critical':
                Log::channel($channel)->critical($message);
                break;
            case 'error':
                Log::channel($channel)->error($message);
                break;
            case 'warning':
                Log::channel($channel)->warning($message);
                break;
            case 'notice':
                Log::channel($channel)->notice($message);
                break;
            case 'info':
                Log::channel($channel)->info($message);
                break;
            case 'debug':
                Log::channel($channel)->debug($message);
                break;
        }
    }
}
