<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'IPoop') }}</title>

        <!-- fav icon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom styles -->
        @stack('styles')

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Alerts -->
            <x-alerts />

            <!-- Page Content -->
            @isset($slot)
                <main>
                    {{ $slot }}
                </main>
            @endisset
        </div>

        <!-- Custom scripts -->
        @stack('scripts')
    </body>

    {{-- Info acadêmica antes do rodapé --}}
    <div class="bg-gray-100 text-center text-gray-600 text-sm py-8">
        Projeto acadêmico desenvolvido utilizando Laravel, Tailwind CSS, Leaflet.js e MySQL – com ❤️ por Alesson Marques da Silva.
    </div>

    {{-- Rodapé principal --}}
    <footer class="bg-purple-600 text-white mt-0">
        <div class="max-w-7xl mx-auto px-6 py-8 grid sm:grid-cols-2 md:grid-cols-3 gap-6 text-sm">
            <div>
            <h4 class="font-semibold text-lg mb-2">iPoop</h4>
            <p class="text-white/90">Facilitando a busca por banheiros públicos e promovendo acessibilidade para todos.</p>
            </div>
            <div>
            <h4 class="font-semibold text-lg mb-2">Navegação</h4>
            <ul class="space-y-1">
                <li><a href="{{ route('home') }}" class="hover:underline">Início</a></li>
                <li><a href="/login" class="hover:underline">Entrar</a></li>
                <li><a href="/register" class="hover:underline">Registrar</a></li>
            </ul>
            </div>
            <div>
            <h4 class="font-semibold text-lg mb-2">Desenvolvimento</h4>
            <ul class="space-y-1">
                <li><a href="https://laravel.com" class="hover:underline" target="_blank">Laravel</a></li>
                <li><a href="https://leafletjs.com" class="hover:underline" target="_blank">Leaflet.js</a></li>
                <li><a href="https://tailwindcss.com" class="hover:underline" target="_blank">Tailwind CSS</a></li>
            </ul>
            </div>
        </div>
        <div class="bg-purple-700 text-center text-white/70 py-4 text-xs">
            © {{ now()->year }} iPoop. Todos os direitos reservados.
        </div>
    </footer>


</html>
