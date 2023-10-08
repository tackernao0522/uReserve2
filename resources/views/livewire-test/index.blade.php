<html>

<head>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    @livewireStyles
</head>

<body>
    <div style="text-align: center">livewireテスト</div>
    <br>
    @if (session()->has('message'))
        <div style="text-align: center; color: red">
            {{ session('message') }}
        </div>
    @endif

    <br>

    {{-- <livewire:counter /> --}}
    @livewire('counter')

    @livewireScripts
</body>

</html>
