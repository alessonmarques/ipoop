<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <!-- Required meta tags -->
        @include('layouts.meta')

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

    @include('layouts.footer')


</html>
