<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100">
            <div class="flex flex-col items-center">
                <a href="/" class="flex items-center">
                    <x-application-logo class="w-16 h-16 fill-current text-indigo-600" />
                    <span class="ml-3 text-2xl font-bold text-gray-900">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <p class="mt-2 text-sm text-gray-600">Welcome to our platform</p>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-xl">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-sm text-gray-600">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </div>
        </div>
    </body>
</html>
