@extends('layouts.app', ['title' => $folder->name . ' | ' . config('app.name', 'DocVault')])

@section('content')
    @php
        $documents = $folder->documents ?? collect();
    @endphp

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <a href="{{ route('folders.index') }}" class="text-sm font-medium text-zinc-500 hover:text-zinc-900">Voltar para pastas</a>
            <h1 class="mt-4 text-2xl font-semibold">{{ $folder->name }}</h1>
            <p class="mt-1 text-sm text-zinc-500">Criada em {{ $folder->created_at?->format('d/m/Y') }}</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('folders.edit', $folder) }}" class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100">
                Editar
            </a>
            <a href="{{ route('folders.documents.create', $folder) }}" class="rounded-md bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-700">
                Novo documento
            </a>
        </div>
    </div>

    <section class="rounded-lg border border-zinc-200 bg-white">
        <div class="border-b border-zinc-200 px-5 py-4">
            <h2 class="text-base font-semibold">Documentos</h2>
        </div>

        @forelse ($documents as $document)
            <div class="flex flex-col gap-3 border-b border-zinc-200 px-5 py-4 last:border-b-0 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="font-medium text-zinc-900">{{ $document->name }}</p>
                    <p class="mt-1 text-sm text-zinc-500">
                        {{ $document->type ?? 'Arquivo' }}
                        @if ($document->size)
                            - {{ number_format($document->size / 1024, 1, ',', '.') }} KB
                        @endif
                    </p>
                </div>

                <a href="{{ route('folders.documents.show', [$folder, $document]) }}" class="text-sm font-medium text-zinc-700 hover:text-zinc-900 hover:underline">
                    Abrir
                </a>
            </div>
        @empty
            <div class="px-5 py-12 text-center">
                <h2 class="text-base font-semibold">Nenhum documento nesta pasta</h2>
                <p class="mt-2 text-sm text-zinc-500">Adicione um documento para preencher esta pasta.</p>
                <a href="{{ route('folders.documents.create', $folder) }}" class="mt-5 inline-flex items-center justify-center rounded-md bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-700">
                    Adicionar documento
                </a>
            </div>
        @endforelse
    </section>
@endsection
