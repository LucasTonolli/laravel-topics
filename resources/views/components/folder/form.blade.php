<div>
    <label for="name" class="block text-sm font-medium text-zinc-700">Nome da pasta</label>
    <input
        id="name"
        type="text"
        name="name"
        value="{{ $folder?->name ?? old('name') }}"
        required
        maxlength="255"
        autocomplete="off"
        class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none transition focus:border-zinc-900 focus:ring-2 focus:ring-zinc-900/10"
    >
    @error('name')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="flex items-center justify-end gap-3">
    <a href="{{ isset($folder) ? route('folders.show', $folder) : route('folders.index') }}" class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100">
        Cancelar
    </a>
    <button type="submit" class="rounded-md bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2">
        {{ $buttonText ?? 'Salvar' }}
    </button>
</div>
