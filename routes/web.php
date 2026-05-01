<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FolderController;
use App\Http\Middleware\EnsureFolderLimit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/config-user', function () {
    User::factory(1)->create();
    $user = User::latest('id')->first();
    Auth::login($user);
    return 'Usuário criado e logado com sucesso';
});

Route::resource('folders', FolderController::class)->middlewareFor('store', EnsureFolderLimit::class);
Route::resource('folders/{folder}/documents', DocumentController::class);
Route::post('folders/{folder}/documents/{document}/share', [DocumentController::class, 'share']);
