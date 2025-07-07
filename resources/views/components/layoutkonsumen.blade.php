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
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>

<body>
    <x-navbarkonsumen></x-navbarkonsumen>
    <main class="py-8 px-4">
        @yield('content')
        {{ $slot }}
    </main>
    <x-footer></x-footer>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
    @if (session('success'))
        <script>
            showAlert('success', '{{ session('success') }}');
        </script>
    @elseif (session('error'))
        <script>
            showAlert('error', '{{ session('error') }}');
        </script>
    @endif
    </script>
</body>

</html>
