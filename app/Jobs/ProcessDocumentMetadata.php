<?php

namespace App\Jobs;

use App\Models\Document;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class ProcessDocumentMetadata implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Document $document) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->document->type = Storage::disk(config('docvault.upload_disk'))->mimeType($this->document->path);
        $this->document->size = Storage::disk(config('docvault.upload_disk'))->size($this->document->path);
        $this->document->name = basename($this->document->path);
        $this->document->save();
    }
}
