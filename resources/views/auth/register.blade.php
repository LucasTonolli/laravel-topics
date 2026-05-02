<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar conta | {{ config('app.name', 'DocVault') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-50 font-sans text-zinc-900 antialiased">
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <section class="w-full max-w-md rounded-lg border border-zinc-200 bg-white p-8 shadow-sm">
            <div class="mb-8">
                <a href="{{ url('/') }}" class="text-sm font-semibold text-zinc-500">{{ config('app.name', 'DocVault') }}</a>
                <h1 class="mt-4 text-2xl font-semibold">Criar conta</h1>
                <p class="mt-2 text-sm text-zinc-500">Comece a organizar seus documentos em poucos segundos.</p>
            </div>

            <form action="{{ route('register') }}" method="post" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-zinc-700">Nome</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        autocomplete="name"
                        required
                        class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none transition focus:border-zinc-900 focus:ring-2 focus:ring-zinc-900/10"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-700">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                        class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none transition focus:border-zinc-900 focus:ring-2 focus:ring-zinc-900/10"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-zinc-700">Senha</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        required
                        class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none transition focus:border-zinc-900 focus:ring-2 focus:ring-zinc-900/10"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-zinc-700">Confirmar senha</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        autocomplete="new-password"
                        required
                        class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none transition focus:border-zinc-900 focus:ring-2 focus:ring-zinc-900/10"
                    >
                </div>

                <button type="submit" class="w-full rounded-md bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2">
                    Criar conta
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-zinc-600">
                Ja tem conta?
                <a href="{{ route('login') }}" class="font-medium text-zinc-900 underline underline-offset-4">Entrar</a>
            </p>
        </section>
    </main>
</body>
</html>
