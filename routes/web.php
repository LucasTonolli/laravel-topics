<?php

use App\Http\Middleware\EnsureFolderLimit;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/config-user', function () {
    User::factory(1)->create();
    $user = User::latest('id')->first();
    Auth::login($user);
    return 'Usuário criado e logado com sucesso';
});


Route::get('/folders', function () {
    return 'Listagem de pastas';
});

Route::get('/folders/{folder:slug}', function ($id) {
    return 'Detalhes da pasta ' . $id;
});

Route::post('/folders', function () {
    Folder::create([
        'user_id' => auth()->user()->id,
        'name' => Str::random(10),
    ]);
    return 'Criado uma nova pasta. Usuário tem ' . auth()->user()->folders()->count() . ' pastas';
})->middleware(EnsureFolderLimit::class);

Route::put('/folders/{folder:slug}', function ($id) {
    return 'Atualizou a pasta ' . $id;
});

Route::delete('/folders/{folder:slug}', function ($id) {
    return 'Deletou a pasta ' . $id;
});
