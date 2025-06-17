<div>
    <nav class="bg-white shadow-md w-full z-50">
        <div class="max-w-screen-xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="#" class="flex items-center">
                <img src="{{ asset('LogoMechafix.svg') }}" alt="Mechafix Logo" class="w-16">
            </a>

            <!-- Hamburger (mobile) -->
            <button id="menu-toggle" class="md:hidden text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Desktop Nav (middle menu + auth buttons) -->
            <div class="hidden md:flex flex-1 justify-center items-center space-x-8">
                <a href="/" class="{{ request()->is('/') ? 'text-orange-500' : 'text-gray-800 hover:text-orange-500' }}">Home Page</a>
                <a href="/services"  class="{{ request()->is('services') ? 'text-orange-500' : 'text-gray-800 hover:text-orange-500' }}">Services Offered</a>
                <a href="/part_shop" class="{{ request()->is('part_shop') ? 'text-orange-500' : 'text-gray-800 hover:text-orange-500' }}">Part Shop</a>
                <div class="relative group">
                    <a href="#" class="text-gray-800 hover:text-orange-500">More Info</a>
                    <ul
                        class="absolute hidden group-hover:block bg-white shadow-md space-y-2 top-full left-0 mt-2 w-48 py-2 px-4 rounded-md text-gray-800 z-50">
                        <li><a href="/our_profile" class="block py-2 px-4 hover:bg-gray-100">Our Profile</a></li>
                        <li><a href="/chat_contact" class="block py-2 px-4 hover:bg-gray-100">Chat Contact</a></li>
                        <li><a href="/history" class="block py-2 px-4 hover:bg-gray-100">History Repair</a></li>
                    </ul>
                </div>
            </div>

            <!-- Auth Buttons (desktop) -->
            <div class="hidden md:flex space-x-2 items-center">
                <a href="#" class="text-orange-500 hover:underline">Sign Up</a>
                <a href="#" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">Sign In</a>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden px-6 pb-4">
            <ul class="space-y-2 text-base font-medium">
                <li><a href="#" class="block text-gray-800 hover:text-orange-500">Home Page</a></li>
                <li><a href="#" class="block text-gray-800 hover:text-orange-500">Services Offered</a></li>
                <li><a href="#" class="block text-gray-800 hover:text-orange-500">Part Shop</a></li>
                <li>
                    <details>
                        <summary class="cursor-pointer text-gray-800 py-2">More Info</summary>
                        <ul class="ml-4 space-y-1">
                            <li><a href="/ourProfile" class="block py-1 px-2 hover:text-orange-500">Our Profile</a></li>
                            <li><a href="/chatContact" class="block py-1 px-2 hover:text-orange-500">Chat Contact</a></li>
                            <li><a href="/historyRepair" class="block py-1 px-2 hover:text-orange-500">History Repair</a></li>
                        </ul>
                    </details>
                </li>
                <li class="pt-2">
                    <a href="#" class="block text-orange-500 hover:underline">Sign Up</a>
                    <a href="#" class="block bg-orange-500 text-white px-4 py-2 mt-1 rounded-lg hover:bg-orange-600">Sign In</a>
                </li>
            </ul>
        </div>
    </nav>

</div>