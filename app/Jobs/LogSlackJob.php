<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LogSlackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $error;
    protected $errorMessage;

    public function __construct($error, $errorMessage)
    {
        $this->error = $error;
        $this->errorMessage = $errorMessage;
    }

    public function handle(): void
    {
        Log::channel('slackLog')->error($this->error.' Error Message : '.$this->errorMessage);
    }
}
