<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'DocVault') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-50 font-sans text-zinc-900 antialiased">
    <header class="border-b border-zinc-200 bg-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4">
            <a href="{{ url('/') }}" class="text-sm font-semibold text-zinc-900">{{ config('app.name', 'DocVault') }}</a>

            <nav class="flex items-center gap-3 text-sm">
                <a href="{{ route('folders.index') }}" class="font-medium text-zinc-600 hover:text-zinc-900">Pastas</a>

                @auth
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="font-medium text-zinc-600 hover:text-zinc-900">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="font-medium text-zinc-600 hover:text-zinc-900">Entrar</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-8">
        @if (session('status'))
            <div class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
