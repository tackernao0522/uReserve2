<html>

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div class="text-center">
        livewireテスト <br>
        <span class="text-blue-600">register</span>
    </div>


    <br>
    @livewire('register')

    @livewireScripts
</body>

</html>
