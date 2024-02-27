<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $noHp;
    protected $message;

    public function __construct($noHp, $message)
    {
        $this->noHp = $noHp;
        $this->message = $message;
    }

    public function handle(): void
    {
        app('App\Http\Services\NotificationService')->whatsAppNotification($this->noHp, $this->message);
    }
}
