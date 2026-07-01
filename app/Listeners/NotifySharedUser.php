<?php

namespace App\Listeners;

use App\Events\DocumentShared;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifySharedUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DocumentShared $event): void
    {
        Log::info('Document shared: ' . $event->document->name . ' by user: ' . $event->user->email . ' with user: ' . $event->sharedWith->email);
    }
}
