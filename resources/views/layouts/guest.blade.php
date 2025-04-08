<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        @include('layouts.meta')
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                <div>
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </div>


                <div class="w-full sm:max-w-md">
                    <div class="my-4">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-800">
                            ← Voltar
                        </a>
                    </div>

                    <div class="mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
    @include('layouts.footer')
</html>
