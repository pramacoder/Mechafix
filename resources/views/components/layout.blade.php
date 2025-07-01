<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="/dist/styles.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <x-navbar></x-navbar>
    <main class="py-8 px-4">
        @yield('content')
        {{ $slot }}
    </main>
    <x-footer></x-footer>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
