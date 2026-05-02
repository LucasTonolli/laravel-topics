@extends('layouts.app', ['title' => 'Editar pasta | ' . config('app.name', 'DocVault')])

@section('content')
    <div class="mb-6">
        <a href="{{ route('folders.show', $folder) }}" class="text-sm font-medium text-zinc-500 hover:text-zinc-900">Voltar para pasta</a>
        <h1 class="mt-4 text-2xl font-semibold">Editar pasta</h1>
        <p class="mt-1 text-sm text-zinc-500">Atualize o nome usado para identificar esta pasta.</p>
    </div>

    <section class="rounded-lg border border-zinc-200 bg-white p-6">
        <form action="{{ route('folders.update', $folder) }}" method="post" class="space-y-6">
            @method('PUT')
            <x-folder.form :folder="$folder" buttonText="Salvar alterações" />
        </form>
    </section>
@endsection
