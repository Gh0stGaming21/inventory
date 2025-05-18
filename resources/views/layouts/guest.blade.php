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
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-[135deg] from-[#0369a1] via-[#0c4a6e] to-[#075985]">
            <div class="flex flex-col items-center mb-6">
                <a href="/" class="flex items-center">
                    <x-application-logo class="auth-logo w-20 h-20 filter drop-shadow-lg" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-4 px-10 py-12 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border border-[#38bdf8] relative">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#0ea5e9] via-[#0284c7] to-[#0c4a6e]"></div>
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-sm text-white">
                &copy; {{ date('Y') }} {{ config('app.name', 'ShelfIQ') }}. All rights reserved.
            </div>
        </div>
    </body>
</html>
