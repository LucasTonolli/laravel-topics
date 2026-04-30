<?php

namespace App\Contracts;

use App\Models\Document;
use App\Models\Folder;
use Illuminate\Http\UploadedFile;

interface DocumentServiceInterface
{
    public function upload(Folder $folder, UploadedFile $file): bool;

    public function delete(Document $document): bool;

    public function download(Document $document): mixed;
}
