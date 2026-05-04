@props([
    'folder',
    'document' => null,
    'buttonText' => 'Salvar',
    'editing' => false,
])

<div>
    <label for="name" class="block text-sm font-medium text-zinc-700">Nome do documento</label>
    <input
        id="name"
        type="text"
        name="name"
        value="{{ old('name', $document?->name) }}"
        required
        maxlength="255"
        autocomplete="off"
        class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none transition focus:border-zinc-900 focus:ring-2 focus:ring-zinc-900/10"
    >
    @error('name')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

@unless ($editing)
    <div>
        <label for="document" class="block text-sm font-medium text-zinc-700">Arquivo</label>
        <input
            id="document"
            type="file"
            name="document"
            required
            accept="{{ implode(',', config('docvault.allowed_file_types')) }}"
            class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-700 file:mr-4 file:rounded-md file:border-0 file:bg-zinc-900 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-zinc-700"
        >
        <p class="mt-2 text-xs text-zinc-500">
            Ate {{ config('docvault.max_upload_size') }} MB.
        </p>
        @error('document')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
@endunless

<div class="flex items-center justify-end gap-3">
    <a href="{{ $document ? route('folders.documents.show', [$folder, $document]) : route('folders.show', $folder) }}" class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100">
        Cancelar
    </a>
    <button type="submit" class="rounded-md bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2">
        {{ $buttonText }}
    </button>
</div>
