<?php

namespace App\Http\Controllers;

use App\Http\Requests\FolderRequests\StoreFolderRequest;
use App\Http\Requests\FolderRequests\UpdateFolderRequest;
use App\Models\Folder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class FolderController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->authorizeResource(Folder::class, 'folder');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

        return view('folders.index', [
            'folders' => $request->user()->folders()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('folders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFolderRequest $request)
    {
        $validated = $request->validated();

        Folder::create([
            'name' => $validated['name'],
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('folders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder)
    {
        return view('folders.show', ['folder' => $folder]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Folder $folder)
    {
        return view('folders.edit', ['folder' => $folder]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFolderRequest $request, Folder $folder)
    {
        $validated = $request->validated();

        $folder->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('folders.show', ['folder' => $folder]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Folder $folder)
    {
        //
    }
}
