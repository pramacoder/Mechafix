<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
<body class="bg-gray-50">
    <nav class="navbar-blur bg-white/90 shadow-lg w-full z-50 sticky top-0 border-b border-orange-100" 
         x-data="{ 
            mobileMenuOpen: false, 
            notificationOpen: false,
            notifications: [
                { id: 1, title: 'New Service Request', message: 'Your motorcycle service has been scheduled', time: '2 minutes ago', unread: true },
                { id: 2, title: 'Part Available', message: 'Brake pads for your Honda is now in stock', time: '1 hour ago', unread: true },
                { id: 3, title: 'Service Complete', message: 'Your engine tune-up has been completed', time: '3 hours ago', unread: false },
                { id: 4, title: 'Payment Reminder', message: 'Invoice #1234 is due tomorrow', time: '1 day ago', unread: false }
            ],
            get unreadCount() {
                return this.notifications.filter(n => n.unread).length;
            },
            markAsRead(id) {
                const notification = this.notifications.find(n => n.id === id);
                if (notification) notification.unread = false;
            },
            markAllAsRead() {
                this.notifications.forEach(n => n.unread = false);
            }
         }">
        
        <div class="max-w-screen-xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo with hover effect -->
            <a href="{{ route('guest.home') }}" class="flex items-center group">
                <div>
                    <img src="{{ asset('LogoMechafix.svg') }}" alt="Mechafix Logo" class="w-16 h-16 object-contain bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl justify-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                </div>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden md:flex flex-1 justify-center items-center space-x-8">
                <a href="{{ route('guest.home') }}" 
                   class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 font-medium">
                    Home Page
                </a>
                <a href="{{ route('guest.services') }}" 
                   class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 font-medium">
                    Services Offered
                </a>
                <a href="{{ route('guest.part_shop') }}" 
                   class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 font-medium">
                    Part Shop
                </a>
                
                <!-- More Info Dropdown -->
                <div class="relative group" id="more-info-group">
                    <button  class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 font-medium flex items-center">
                        More Info
                        <svg class="w-4 h-4 ml-1 transform group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="more-info-dropdown" class="absolute hidden group-hover:block bg-white shadow-xl rounded-xl top-full left-0 mt-2 w-56 py-4 border border-orange-100 z-50">
                        <a href="{{ route('guest.our_profile') }}" 
                           class="block px-6 py-3 text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Our Profile
                            </div>
                        </a>
                        <a href="{{ route('guest.chat_contact') }}" 
                           class="block px-6 py-3 text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Chat Contact
                            </div>
                        </a>
                        <a href="{{ route('guest.history') }}" 
                           class="block px-6 py-3 text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Our History
                            </div>
                        </a>
                    </div>
                </div>
                <!-- Right Side Actions -->
                <div class="flex items-center space-x-4 mr-10" 
                    x-data="notificationComponent()" 
                    x-init="init()">
                    <!-- Notifications -->
                    {{-- <div class="relative">
                        <button @click="toggleNotifications()" 
                                class="relative p-2 rounded-full hover:bg-orange-50 transition-all duration-300 hover-glow">
                            <img src="{{ asset('Lonceng.svg') }}" alt="Notifications" class="w-6 h-6 object-contain">
                            <span x-show="unreadCount > 0" 
                                class="absolute -top-1 -right-1 bg-red-500 text-orange-500 border-2 border-orange-500 text-xs rounded-full w-5 h-5 flex items-center justify-center notification-badge"
                                x-text="unreadCount"></span>
                        </button>
                        
                        <!-- Notification Panel -->
                        <div x-show="notificationOpen" 
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-1 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-1 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            @click.away="notificationOpen = false"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-orange-100 z-50 overflow-hidden">
                            
                            <!-- Header -->
                            <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-orange-100">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>
                                    <button @click="markAllAsRead()" 
                                            class="text-sm text-orange-600 hover:text-orange-700 font-medium"
                                            :disabled="unreadCount === 0">
                                        Mark all as read
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Loading State -->
                            <div x-show="loading" class="p-4 text-center">
                                <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-orange-500"></div>
                                <p class="text-gray-600 mt-2">Loading notifications...</p>
                            </div>
                            
                            <!-- Notifications List -->
                            <div x-show="!loading" class="max-h-64 overflow-y-auto">
                                <template x-for="notification in notifications" :key="notification.id">
                                    <div @click="markAsRead(notification.id)" 
                                        class="p-4 border-b border-gray-50 hover:bg-orange-50 cursor-pointer transition-colors duration-200"
                                        :class="notification.unread ? 'bg-orange-25' : ''">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 w-2 h-2 rounded-full mt-2 mr-3"
                                                :class="notification.unread ? 'bg-orange-500' : 'bg-gray-300'"></div>
                                            <div class="flex-1">
                                                <h4 class="text-sm font-medium text-gray-800" x-text="notification.title"></h4>
                                                <p class="text-xs text-gray-600 mt-1" x-text="notification.message"></p>
                                                <span class="text-xs text-gray-400 mt-1" x-text="notification.time"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                
                                <!-- Empty State -->
                                <div x-show="notifications.length === 0" class="p-4 text-center text-gray-500">
                                    <p>No notifications yet</p>
                                </div>
                            </div>
                            
                            <!-- Footer -->
                            <div class="p-3 bg-gray-50 text-center">
                                <a href="#" class="text-sm text-orange-600 hover:text-orange-700 font-medium">View all notifications</a>
                            </div>
                        </div>
                    </div> --}}
                    @include('dashboard.notifications')
                </div>
            </div>

                <!-- Sign In Button -->
                <a href="{{ route('login') }}" 
                   class="md:inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-orange-500 border-2 border-orange-500 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Sign In
                </a>

                <!-- Mobile Menu Toggle -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="md:hidden p-2 rounded-lg hover:bg-orange-50 transition-colors duration-300">
                    <svg class="w-6 h-6 text-gray-700" :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="w-6 h-6 text-gray-700" :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-1 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-1 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="md:hidden border-t border-orange-100 bg-white">
            
            <div class="px-6 py-4 space-y-2">
                <a href="{{ route('guest.home') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 font-medium">
                    Home Page
                </a>
                <a href="{{ route('guest.services') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 font-medium">
                    Services Offered
                </a>
                <a href="{{ route('guest.part_shop') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 font-medium">
                    Part Shop
                </a>
                
                <!-- Mobile More Info -->
                <div x-data="{ mobileDropdownOpen: false }">
                    <button @click="mobileDropdownOpen = !mobileDropdownOpen"
                            class="flex items-center justify-between w-full px-4 py-3 rounded-lg text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300 font-medium">
                        More Info
                        <svg class="w-4 h-4 transform transition-transform duration-300" 
                             :class="{'rotate-180': mobileDropdownOpen}" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="mobileDropdownOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-1 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-1 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="ml-4 mt-2 space-y-1">
                        <a href="{{ route('guest.our_profile') }}" 
                           class="block px-4 py-2 rounded-lg text-gray-600 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">
                            Our Profile
                        </a>
                        <a href="{{ route('guest.chat_contact') }}" 
                           class="block px-4 py-2 rounded-lg text-gray-600 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">
                            Chat Contact
                        </a>
                        <a href="{{ route('guest.history') }}" 
                           class="block px-4 py-2 rounded-lg text-gray-600 hover:text-orange-500 hover:bg-orange-50 transition-all duration-300">
                            Our History
                        </a>
                    </div>
                </div>
                
                <!-- Mobile Sign In -->
                <div class="pt-4 border-t border-orange-100">
                    <a href="{{ route('login') }}" 
                       class="flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-orange-500 border-2 border-orange-500 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Sign In
                    </a>
                </div>
            </div>
        </div>
    </nav>
