<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <!-- Required meta tags -->
        @include('layouts.meta')

        <!-- Custom styles -->
        @stack('styles')

    </head>
    <body class="font-sans antialiased">
        @if (auth()->check() && !auth()->user()->hasVerifiedEmail())
            <div class="bg-purple-100 text-purple-800 p-4 text-sm text-center">
                Seu e-mail ainda não foi verificado.
                <form method="POST" action="{{ route('verification.send') }}" class="inline">
                    @csrf
                    <button type="submit" class="underline font-medium text-purple-700 hover:text-purple-900">Reenviar verificação</button>
                </form>
            </div>
        @endif
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

    @include('layouts.footer')


</html>
