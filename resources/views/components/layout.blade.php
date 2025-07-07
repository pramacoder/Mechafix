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
    @vite('resources/css/app.css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .navbar-blur {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        
        .notification-badge {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .hover-glow {
            transition: all 0.3s ease;
        }
        
        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(249, 115, 22, 0.3);
        }
        
        .nav-link {
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #f97316, #ea580c);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .mobile-menu-enter {
            transform: translateY(-100%);
            opacity: 0;
        }
        
        .mobile-menu-enter-active {
            transform: translateY(0);
            opacity: 1;
            transition: all 0.3s ease;
        }
        
        .notification-panel {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .notification-panel.open {
            max-height: 400px;
        }
    </style>
</head>

<body>
    <x-navbar></x-navbar>
    <main class="py-8 px-4">
        @yield('content')
        {{ $slot }}
    </main>
    <x-footer></x-footer>
    <script src="{{ asset('js/app.js') }}">
document.addEventListener('DOMContentLoaded', function () {
    const group = document.getElementById('more-info-group');
    const dropdown = document.getElementById('more-info-dropdown');
    let timeout;

    group.addEventListener('mouseenter', function () {
        clearTimeout(timeout);
        dropdown.classList.remove('hidden');
    });

    group.addEventListener('mouseleave', function () {
        timeout = setTimeout(() => {
            dropdown.classList.add('hidden');
        }, 1000); // 200ms delay, bisa diubah sesuai selera
    });

    dropdown.addEventListener('mouseenter', function () {
        clearTimeout(timeout);
        dropdown.classList.remove('hidden');
    });

    dropdown.addEventListener('mouseleave', function () {
        timeout = setTimeout(() => {
            dropdown.classList.add('hidden');
        }, 1000);
    });
});
    </script>
</body>

</html>
