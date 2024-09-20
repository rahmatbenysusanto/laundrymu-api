<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationJob implements ShouldQueue
{
    use Queueable;
    protected $type;
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        app('App\Http\Service\NotificationService')->notification($this->type, $this->data);
    }
}
