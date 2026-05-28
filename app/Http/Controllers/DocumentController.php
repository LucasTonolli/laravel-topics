<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequests\ShareDocumentRequest;
use App\Http\Requests\DocumentRequests\StoreDocumentRequest;
use App\Models\Document;
use App\Models\Folder;
use App\Services\DocumentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DocumentController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->authorizeResource(Document::class, 'document');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Folder $folder): View
    {
        return view('documents.create', compact('folder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request, Folder $folder, DocumentService $documentService)
    {
        $validated = $request->validated();

        $documentService->upload($folder, $validated['document']);

        return redirect()->route('folders.show', ['folder' => $folder]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder, Document $document): View
    {
        $document->loadMissing(['folder', 'user', 'sharedUsers']);

        return view('documents.show', compact('folder', 'document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Folder $folder, Document $document): View
    {
        return view('documents.edit', compact('folder', 'document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Folder $folder, Document $document)
    {
        Log::info("Updating document with id: {$document}");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Folder $folder, Document $document, DocumentService $documentService)
    {
        $documentService->delete($document);

        return redirect()->route('folders.show', ['folder' => $folder]);
    }

    public function share(ShareDocumentRequest $request, Folder $folder, Document $document)
    {
        $validated = $request->validated();

        match ($validated['permission']) {
            'view' => $document->viewers()->attach($validated['user_id']),
            'edit' => $document->editors()->attach($validated['user_id'], ['permission' => $validated['permission']]),
        };

        return redirect()->route('folders.documents.show', ['folder' => $folder, 'document' => $document]);
    }
    public function download(Folder $folder, Document $document, DocumentService $documentService)
    {
        $documentService->download($document);
        return back(200);
    }
}
