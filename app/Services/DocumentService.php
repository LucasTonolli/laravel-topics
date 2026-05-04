<?php

namespace App\Services;

use App\Contracts\DocumentServiceInterface;
use App\Models\Document;
use App\Models\Folder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentService implements DocumentServiceInterface
{
    public function __construct(
        private readonly string $disk,
    ) {}

    public function upload(Folder $folder, UploadedFile $file): bool
    {
        $path = $folder->slug . '/' . $file->getClientOriginalName();

        if (!$path) {
            return false;
        }

        $document = $folder->documents()->create([
            'user_id' => $folder->user_id,
            'type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'name' => $file->getClientOriginalName(),
            'path' => $path,
        ]);

        return $document->exists();
    }

    public function delete(Document $document): bool
    {
        return $document->delete();
    }

    public function download(Document $document): StreamedResponse
    {
        return Storage::disk($this->disk)->download($document->path);
    }
}
