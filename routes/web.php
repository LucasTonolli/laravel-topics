<?php

use App\Http\Controllers\AuthController;
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
Route::resource('folders.documents', DocumentController::class);
Route::post('folders/{folder}/documents/{document}/share', [DocumentController::class, 'share'])
    ->middleware('can:share,document');
Route::get('folders/{folder}/documents/{document}/download', [DocumentController::class, 'download'])
    ->middleware('can:download,document');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('auth');
Route::get('/register', [AuthController::class, 'showRegister'])->name('show-register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
