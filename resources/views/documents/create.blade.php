@extends('layouts.app', ['title' => 'Novo documento | ' . config('app.name', 'DocVault')])

@section('content')
    <div class="mb-6">
        <a href="{{ route('folders.show', $folder) }}" class="text-sm font-medium text-zinc-500 hover:text-zinc-900">Voltar para {{ $folder->name }}</a>
        <h1 class="mt-4 text-2xl font-semibold">Novo documento</h1>
        <p class="mt-1 text-sm text-zinc-500">Envie um arquivo para guardar nesta pasta.</p>
    </div>

    <section class="rounded-lg border border-zinc-200 bg-white p-6">
        <form action="{{ route('folders.documents.store', $folder) }}" method="post" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <x-document.form :folder="$folder" buttonText="Criar documento" />
        </form>
    </section>
@endsection
