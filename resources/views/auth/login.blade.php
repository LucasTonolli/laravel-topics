<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar | {{ config('app.name', 'DocVault') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-50 font-sans text-zinc-900 antialiased">
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <section class="w-full max-w-md rounded-lg border border-zinc-200 bg-white p-8 shadow-sm">
            <div class="mb-8">
                <a href="{{ url('/') }}" class="text-sm font-semibold text-zinc-500">{{ config('app.name', 'DocVault') }}</a>
                <h1 class="mt-4 text-2xl font-semibold">Entrar na conta</h1>
                <p class="mt-2 text-sm text-zinc-500">Acesse seus documentos com email e senha.</p>
            </div>

            <form action="{{ route('auth') }}" method="post" class="space-y-5">
                @csrf

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
                        autocomplete="current-password"
                        required
                        class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none transition focus:border-zinc-900 focus:ring-2 focus:ring-zinc-900/10"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-zinc-600">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900">
                    Lembrar de mim
                </label>

                <button type="submit" class="w-full rounded-md bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2">
                    Entrar
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-zinc-600">
                Ainda nao tem conta?
                <a href="{{ route('show-register') }}" class="font-medium text-zinc-900 underline underline-offset-4">Criar conta</a>
            </p>
        </section>
    </main>
</body>
</html>
