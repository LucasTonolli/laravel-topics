@extends('layouts.app', ['title' => 'Editar documento | ' . config('app.name', 'DocVault')])

@section('content')
    <div class="mb-6">
        <a href="{{ route('folders.documents.show', [$folder, $document]) }}" class="text-sm font-medium text-zinc-500 hover:text-zinc-900">Voltar para documento</a>
        <h1 class="mt-4 text-2xl font-semibold">Editar documento</h1>
        <p class="mt-1 text-sm text-zinc-500">Atualize o nome usado para identificar este arquivo.</p>
    </div>

    <section class="rounded-lg border border-zinc-200 bg-white p-6">
        <form action="{{ route('folders.documents.update', [$folder, $document]) }}" method="post" class="space-y-6">
            @csrf
            @method('PUT')
            <x-document.form :folder="$folder" :document="$document" :editing="true" buttonText="Salvar alteracoes" />
        </form>
    </section>
@endsection
