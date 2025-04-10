<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        @include('layouts.meta')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body class="min-h-screen bg-gray-100 font-sans text-gray-900 antialiased flex flex-col justify-between"></body>
        <div class="pb-4">
            @include('layouts.navigation')
        </div>
        <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
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
        <div class="pt-4">
            @include('layouts.footer')
        </div>
    </body>
</html>
