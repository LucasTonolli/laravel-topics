@extends('layouts.app', ['title' => 'Nova pasta | ' . config('app.name', 'DocVault')])

@section('content')
    <div class="mb-6">
        <a href="{{ route('folders.index') }}" class="text-sm font-medium text-zinc-500 hover:text-zinc-900">Voltar para pastas</a>
        <h1 class="mt-4 text-2xl font-semibold">Nova pasta</h1>
        <p class="mt-1 text-sm text-zinc-500">Escolha um nome claro para encontrar seus documentos depois.</p>
    </div>

    <section class="rounded-lg border border-zinc-200 bg-white p-6">
        <form action="{{ route('folders.store') }}" method="post" class="space-y-6">
           <x-folder.form buttonText="Criar pasta" />
        </form>
    </section>
@endsection
