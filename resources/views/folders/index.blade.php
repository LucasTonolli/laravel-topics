@extends('layouts.app', ['title' => 'Pastas | ' . config('app.name', 'DocVault')])

@section('content')
    @php
        $folders = $folders ?? collect();
    @endphp

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold">Pastas</h1>
            <p class="mt-1 text-sm text-zinc-500">Organize seus documentos por assunto, cliente ou projeto.</p>
        </div>

        <a href="{{ route('folders.create') }}" class="inline-flex items-center justify-center rounded-md bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2">
            Nova pasta
        </a>
    </div>

    <section class="overflow-hidden rounded-lg border border-zinc-200 bg-white">
        @forelse ($folders as $folder)
            <div class="flex flex-col gap-4 border-b border-zinc-200 px-5 py-4 last:border-b-0 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <a href="{{ route('folders.show', $folder) }}" class="font-semibold text-zinc-900 hover:underline">
                        {{ $folder->name }}
                    </a>
                    <p class="mt-1 text-sm text-zinc-500">
                        {{ $folder->documents_count ?? $folder->documents->count() }} documento(s)
                    </p>
                </div>

                <div class="flex items-center gap-2">
                     <a href="{{ route('folders.show', $folder) }}" class="rounded-md border border-zinc-300 px-3 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100">
                        Ver documentos
                    </a>
                    <a href="{{ route('folders.edit', $folder) }}" class="rounded-md border border-zinc-300 px-3 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100">
                        Editar
                    </a>

                    <form action="{{ route('folders.destroy', $folder) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-md border border-red-200 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="px-5 py-12 text-center">
                <h2 class="text-base font-semibold">Nenhuma pasta criada</h2>
                <p class="mt-2 text-sm text-zinc-500">Crie a primeira pasta para comecar a guardar documentos.</p>
                <a href="{{ route('folders.create') }}" class="mt-5 inline-flex items-center justify-center rounded-md bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-700">
                    Criar pasta
                </a>
            </div>
        @endforelse
    </section>
@endsection
