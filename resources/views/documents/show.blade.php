@extends('layouts.app', ['title' => $document->name . ' | ' . config('app.name', 'DocVault')])

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <a href="{{ route('folders.show', $folder) }}" class="text-sm font-medium text-zinc-500 hover:text-zinc-900">Voltar para {{ $folder->name }}</a>
            <h1 class="mt-4 text-2xl font-semibold">{{ $document->name }}</h1>
            <p class="mt-1 text-sm text-zinc-500">Documento salvo em {{ $document->created_at?->format('d/m/Y') }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @can('download', $document)
                <a href="{{ url('folders/' . $folder->getRouteKey() . '/documents/' . $document->getRouteKey() . '/download') }}" class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100">
                    Baixar
                </a>
            @endcan

            @can('update', $document)
                <a href="{{ route('folders.documents.edit', [$folder, $document]) }}" class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100">
                    Editar
                </a>
            @endcan

            @can('delete', $document)
                <form action="{{ route('folders.documents.destroy', [$folder, $document]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-md border border-red-200 px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                        Excluir
                    </button>
                </form>
            @endcan
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1fr_320px]">
        <section class="rounded-lg border border-zinc-200 bg-white">
            <div class="border-b border-zinc-200 px-5 py-4">
                <h2 class="text-base font-semibold">Detalhes</h2>
            </div>

            <dl class="divide-y divide-zinc-200">
                <div class="px-5 py-4">
                    <dt class="text-sm font-medium text-zinc-500">Nome</dt>
                    <dd class="mt-1 text-sm text-zinc-900">{{ $document->name }}</dd>
                </div>
                <div class="px-5 py-4">
                    <dt class="text-sm font-medium text-zinc-500">Tipo</dt>
                    <dd class="mt-1 text-sm text-zinc-900">{{ $document->type }}</dd>
                </div>
                <div class="px-5 py-4">
                    <dt class="text-sm font-medium text-zinc-500">Tamanho</dt>
                    <dd class="mt-1 text-sm text-zinc-900">{{ number_format($document->size / 1024, 1, ',', '.') }} KB</dd>
                </div>
                <div class="px-5 py-4">
                    <dt class="text-sm font-medium text-zinc-500">Pasta</dt>
                    <dd class="mt-1 text-sm text-zinc-900">{{ $folder->name }}</dd>
                </div>
                <div class="px-5 py-4">
                    <dt class="text-sm font-medium text-zinc-500">Dono</dt>
                    <dd class="mt-1 text-sm text-zinc-900">{{ $document->user?->name ?? 'Usuario' }}</dd>
                </div>
            </dl>
        </section>

        @can('share', $document)
            <aside class="rounded-lg border border-zinc-200 bg-white p-5">
                <h2 class="text-base font-semibold">Compartilhar</h2>

                <form action="{{ url('folders/' . $folder->getRouteKey() . '/documents/' . $document->getRouteKey() . '/share') }}" method="post" class="mt-4 space-y-4">
                    @csrf

                    <div>
                        <label for="user_id" class="block text-sm font-medium text-zinc-700">ID do usuario</label>
                        <input
                            id="user_id"
                            type="number"
                            name="user_id"
                            value="{{ old('user_id') }}"
                            required
                            class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none transition focus:border-zinc-900 focus:ring-2 focus:ring-zinc-900/10"
                        >
                        @error('user_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="permission" class="block text-sm font-medium text-zinc-700">Permissao</label>
                        <select
                            id="permission"
                            name="permission"
                            required
                            class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none transition focus:border-zinc-900 focus:ring-2 focus:ring-zinc-900/10"
                        >
                            <option value="view" @selected(old('permission') === 'view')>Visualizar</option>
                            <option value="edit" @selected(old('permission') === 'edit')>Editar</option>
                        </select>
                        @error('permission')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full rounded-md bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-700">
                        Compartilhar
                    </button>
                </form>
            </aside>
        @endcan
    </div>
@endsection
