<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Component</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    <style>
        .bg-orange-25 { background-color: #fff7ed; }
    </style>
</head>
<body class="bg-gray-100 p-8">
    
    @php
        $unreadNotifs = auth()->check() ? auth()->user()->unreadNotifications()->limit(10)->get() : collect();
        $unreadCount = $unreadNotifs->count();
    @endphp

    <!-- Notification Component -->
    <div class="relative" x-data="{ open: false }">
        <button
            @click="open = !open"
            @keydown.escape="open = false"
            class="p-2 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 relative"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <!-- Notification Badge -->
            <span class="absolute -top-1 -right-1 bg-red-500 text-orange-600 text-xs rounded-full h-5 w-5 flex items-center justify-center">
                {{ $unreadCount }}
            </span>
        </button>
        <!-- Notification Dropdown -->
        <div
            x-show="open"
            @click.away="open = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute bg-white shadow-xl rounded-xl top-full right-0 mt-2 w-80 py-4 border border-orange-100 z-50"
            style="display: none;"
        >
            <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-orange-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Notifikasi</h3>
                </div>
            </div>
            <div class="max-h-64 overflow-y-auto">
                @forelse($unreadNotifs as $notif)
                    <div class="p-4 border-b border-gray-50 hover:bg-orange-50 cursor-pointer transition-colors duration-200 bg-orange-25">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 rounded-full mt-2 mr-3 bg-orange-500"></div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-800">{{ $notif->data['message'] ?? $notif->type }}</h4>
                                <p class="text-xs text-gray-600 mt-1">{{ $notif->data['message'] ?? $notif->type }}</p>
                                <span class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        <p>Belum ada notifikasi baru.</p>
                    </div>
                @endforelse
            </div>
            <div class="p-3 bg-gray-50 text-center">
                <a href="#" class="text-sm text-orange-600 hover:text-orange-700 font-medium">Lihat semua notifikasi</a>
            </div>
        </div>
    </div>
</body>
</html>