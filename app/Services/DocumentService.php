<?php

namespace App\Services;

use App\Contracts\DocumentServiceInterface;
use App\Events\DocumentUploaded;
use App\Jobs\ProcessDocumentMetadata;
use App\Models\Document;
use App\Models\Folder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentService implements DocumentServiceInterface
{
    public function __construct(
        private readonly string $disk,
    ) {}

    public function upload(Folder $folder, UploadedFile $file): bool
    {
        return DB::transaction(function () use ($folder, $file) {
            $uploaded = Storage::disk($this->disk)->putFileAs($folder->slug, $file, $file->getClientOriginalName());

            $document = $folder->documents()->create([
                'user_id' => $folder->user_id,
                'type' => '',
                'size' => 0,
                'name' => '',
                'path' => $uploaded,
            ]);

            if (!$document->exists()) {
                Storage::disk($this->disk)->delete($uploaded);
                return false;
            }

            DocumentUploaded::dispatch($document, $folder->user);
            ProcessDocumentMetadata::dispatch($document);
            return true;
        });
    }

    public function delete(Document $document): bool
    {
        Storage::disk($this->disk)->delete($document->path);
        return $document->delete();
    }

    public function download(Document $document): StreamedResponse
    {
        return Storage::disk($this->disk)->download($document->path);
    }
}
