<x-layoutkonsumen>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (auth()->user()->isKonsumen())
                <!-- Dashboard untuk Konsumen -->
                @include('dashboard.konsumen')
            @elseif(auth()->user()->isMekanik())
                <!-- Dashboard untuk Mekanik -->
                @include('dashboard.mekanik')
            @elseif(auth()->user()->isAdmin())
                <!-- Dashboard untuk Admin - redirect ke Filament -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-medium text-gray-900">Admin Panel</h3>
                        <p class="mt-2 text-gray-600">You are being redirected to the admin panel...</p>
                        <script>
                            window.location.href = '/admin';
                        </script>
                        <a href="/admin"
                            class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Go to Admin Panel
                        </a>
                    </div>
                </div>
            @else
                <!-- Default fallback -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium">Welcome!</h3>
                        <p class="mt-2 text-gray-600">Your account role is not configured properly.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-layoutkonsumen>
