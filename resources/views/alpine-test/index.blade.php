<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            <div x-data={open:true} class="text-center py-4" x-cloak>
                <div x-show="open" style="color: blue">openがtrue</div>
                <div x-show="!open" style="color: red">openがfalse</div>
                <button class="px-4 py-2 mt-4 bg-blue-400 text-white" x-on:click="open = !open">
                    ボタン
                </button>
            </div>
            {{-- 効かなくなる --}}
            {{-- <div x-show="open">openがtrue</div>
            <div x-show="!open">openがfalse</div> --}}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>
