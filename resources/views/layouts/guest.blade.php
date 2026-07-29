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

        <!-- Styles and Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/auth.css'])
        
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100 dark:bg-gray-900 dark:text-white">
        <div class="relative mx-[100px] my-[50px] h-[500px] overflow-hidden rounded-xl border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
            {{ $slot }}
        </div>
    </body>
</html>
