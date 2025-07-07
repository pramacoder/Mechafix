<nav x-data="{ open: false }" class="navbar-blur bg-white/90 shadow-lg w-full z-50 sticky top-0 border-b border-orange-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard.konsumen') }}" class="flex items-center group">
                    <img src="{{ asset('LogoMechafix.svg') }}" alt="Mechafix Logo" 
                         class="w-16 h-16 object-contain bg-gradient-to-br from-orange-100 to-orange-200 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex flex-1 justify-center items-center space-x-8">
                <a href="{{ route('dashboard.konsumen') }}" class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 font-medium">Home Page</a>
                <a href="{{ route('konsumen.services') }}" class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 font-medium">Services Offered</a>
                <a href="{{ route('konsumen.part_shop') }}" class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 font-medium">Part Shop</a>
                
                <!-- More Info Dropdown -->
                <div class="relative group">
                    <button class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 font-medium flex items-center">
                        More Info
                        <svg class="w-4 h-4 ml-1 transform group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="absolute hidden group-hover:block bg-white shadow-xl rounded-xl top-full left-0 mt-2 w-56 py-4 border border-orange-100 z-50">
                        <a href="{{ route('konsumen.our_profile') }}" class="block px-6 py-3 text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Our Profile
                            </div>
                        </a>
                        <a href="{{ route('konsumen.chat_contact') }}" class="block px-6 py-3 text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Chat Contact
                            </div>
                        </a>
                        <a href="{{ route('konsumen.history') }}" class="block px-6 py-3 text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                History Repair
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side Icons - Notifications & Profile in same line -->
            <div class="hidden md:flex items-center space-x-3">
                <!-- Notifications with dropdown -->
                <div class="relative group">
                    <button class="p-2 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <!-- Notification Badge -->
                        <span class="absolute -top-1 -right-1 bg-red-500 text-orange-600 text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ auth()->check() ? auth()->user()->unreadNotifications->count() : 0 }}</span>
                    </button>
                    
                    <!-- Notification Dropdown -->
                    <div class="absolute hidden group-hover:block bg-white shadow-xl rounded-xl top-full right-0 mt-2 w-80 py-4 border border-orange-100 z-50">
                        @php
                        $unreadNotifs = auth()->check() ? auth()->user()->unreadNotifications()->limit(10)->get() : collect();
                        @endphp
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

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-orange-300 hover:border-orange-200 transition-all duration-300">
                                <img class="w-8 h-8 rounded-full object-cover ring-2 ring-orange-100 hover:ring-orange-200 transition-all duration-300" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                        @else
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:text-orange-500 hover:bg-orange-50 focus:outline-none focus:bg-orange-50 active:bg-orange-50 transition-all duration-300">
                                {{ Auth::user()->name }}
                                <svg class="ml-2 -mr-0.5 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        @endif
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-2 text-xs text-gray-400 border-b border-gray-100">
                            Manage Account
                        </div>
                        <x-dropdown-link href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger Menu -->
            <div class="md:hidden flex items-center">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white border-t border-orange-100">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard.konsumen') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">Home Page</a>
            <a href="{{ route('konsumen.services') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">Services Offered</a>
            <a href="{{ route('konsumen.part_shop') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">Part Shop</a>
            <a href="{{ route('konsumen.our_profile') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">Our Profile</a>
            <a href="{{ route('konsumen.chat_contact') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">Chat Contact</a>
            <a href="{{ route('konsumen.history') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">History Repair</a>
        </div>

        <!-- Mobile Account Management -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4 py-2">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <img class="w-8 h-8 rounded-full object-cover mr-3" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                @endif
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">Profile</a>
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <a href="{{ route('logout') }}" @click.prevent="$root.submit();" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-red-500 hover:bg-red-50 transition-all duration-300">Log Out</a>
                </form>
            </div>
        </div>
    </div>
</nav>