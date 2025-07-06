<x-layoutkonsumen>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <!-- Title Section -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">Our Products</h1>
            <p class="text-gray-600 text-lg mb-8">Explore our extensive range of motorbike parts.</p>

            <!-- Filter Dropdown -->
            <div class="inline-block relative">
                <select
                    class="appearance-none bg-white border border-gray-300 px-6 py-3 pr-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 cursor-pointer text-gray-700 font-medium">
                    <option>Select By</option>
                    <option>Brake Parts</option>
                    <option>Engine Parts</option>
                    <option>Electrical</option>
                    <option>Transmission</option>
                    <option>Lighting</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Product 1: Brake Pads -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-square bg-gray-100 p-4 flex items-center justify-center">
                    <div class="w-full h-full bg-red-500 rounded-lg flex items-center justify-center relative">
                        <div class="bg-white p-4 rounded shadow-md">
                            <div class="text-xs text-gray-600 mb-2">YAMAHA</div>
                            <div class="w-16 h-12 bg-gray-300 rounded mb-2"></div>
                            <div class="text-xs font-bold">BRAKE PAD KIT</div>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-1">Brake Pads</h3>
                    <p class="text-sm text-gray-600 mb-3">Standard</p>
                    <p class="font-bold text-lg text-gray-900 mb-3">Rp 45.000,00</p>
                    <button
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded font-medium transition-colors duration-300">
                        Check it out on shopee
                    </button>
                </div>
            </div>

            <!-- Product 2: Oil Filter -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-square bg-gray-200 p-8 flex items-center justify-center">
                    <div class="w-20 h-24 bg-black rounded-full relative">
                        <div class="absolute top-2 left-1/2 transform -translate-x-1/2 text-white text-xs font-bold">
                            YAMAHA</div>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-1">Oil Filter</h3>
                    <p class="text-sm text-gray-600 mb-3">Premium</p>
                    <p class="font-bold text-lg text-gray-900 mb-3">Rp 45.000,00</p>
                    <button
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded font-medium transition-colors duration-300">
                        Check it out on shopee
                    </button>
                </div>
            </div>

            <!-- Product 3: Chain Kit -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-square bg-gray-100 p-4 flex items-center justify-center">
                    <div class="w-full h-full bg-red-500 rounded-lg flex items-center justify-center relative">
                        <div class="bg-white p-4 rounded shadow-md w-3/4">
                            <div class="text-xs text-red-600 font-bold mb-2">HONDA</div>
                            <div class="w-full h-8 bg-gray-200 rounded mb-2 flex items-center justify-center">
                                <div class="w-6 h-6 bg-gray-400 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-1">Chain Kit</h3>
                    <p class="text-sm text-gray-600 mb-3">Standard</p>
                    <p class="font-bold text-lg text-gray-900 mb-3">Rp 45.000,00</p>
                    <button
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded font-medium transition-colors duration-300">
                        Check it out on shopee
                    </button>
                </div>
            </div>

            <!-- Product 4: Spark Plug -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-square bg-gray-100 p-8 flex items-center justify-center">
                    <div class="flex space-x-2">
                        <div class="w-4 h-16 bg-gradient-to-b from-gray-300 to-gray-600 rounded-full"></div>
                        <div class="w-4 h-16 bg-gradient-to-b from-gray-300 to-gray-600 rounded-full"></div>
                        <div class="w-4 h-16 bg-gradient-to-b from-gray-300 to-gray-600 rounded-full"></div>
                        <div class="w-4 h-16 bg-gradient-to-b from-gray-300 to-gray-600 rounded-full"></div>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-1">Spark Plug</h3>
                    <p class="text-sm text-gray-600 mb-3">NGK</p>
                    <p class="font-bold text-lg text-gray-900 mb-3">Rp 45.000,00</p>
                    <button
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded font-medium transition-colors duration-300">
                        Check it out on shopee
                    </button>
                </div>
            </div>

            <!-- Product 5: Throttle Cable -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-square bg-gray-100 p-4 flex items-center justify-center relative">
                    <div class="w-24 h-24 rounded-full border-4 border-black relative">
                        <div class="absolute inset-4 bg-white rounded-full"></div>
                        <div class="absolute top-2 left-8 text-xs font-bold text-red-600">QUICK</div>
                    </div>
                    <!-- Quality badges -->
                    <div class="absolute bottom-2 left-2 flex space-x-1">
                        <div class="bg-red-600 text-white text-xs px-1 py-0.5 rounded">100% ORIGINAL</div>
                        <div class="bg-red-600 text-white text-xs px-1 py-0.5 rounded">HIGH QUALITY</div>
                        <div class="bg-red-600 text-white text-xs px-1 py-0.5 rounded">FAST DELIVERY</div>
                        <div class="bg-red-600 text-white text-xs px-1 py-0.5 rounded">SATISFACTION</div>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-1">Throttle Cable</h3>
                    <p class="text-sm text-gray-600 mb-3">OEM</p>
                    <p class="font-bold text-lg text-gray-900 mb-3">Rp 45.000,00</p>
                    <button
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded font-medium transition-colors duration-300">
                        Check it out on shopee
                    </button>
                </div>
            </div>

            <!-- Product 6: Headlight Bulb -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-square bg-gray-300 p-8 flex items-center justify-center">
                    <div class="w-16 h-20 bg-gradient-to-b from-gray-200 to-gray-400 rounded-lg relative">
                        <div
                            class="absolute top-4 left-1/2 transform -translate-x-1/2 w-8 h-8 bg-gray-100 rounded-full">
                        </div>
                        <div
                            class="absolute bottom-2 left-1/2 transform -translate-x-1/2 w-4 h-4 bg-orange-400 rounded-full">
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-1">Headlight Bulb</h3>
                    <p class="text-sm text-gray-600 mb-3">LED</p>
                    <p class="font-bold text-lg text-gray-900 mb-3">Rp 45.000,00</p>
                    <button
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded font-medium transition-colors duration-300">
                        Check it out on shopee
                    </button>
                </div>
            </div>

            <!-- Product 7: Placeholder -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-square bg-gray-200 p-8 flex items-center justify-center">
                    <div class="w-16 h-16 bg-gray-300 rounded flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-1">Product name</h3>
                    <p class="text-sm text-gray-600 mb-3">Variant</p>
                    <p class="font-bold text-lg text-gray-900 mb-3">Rp 45.000,00</p>
                    <button
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded font-medium transition-colors duration-300">
                        Check it out on shopee
                    </button>
                </div>
            </div>

            <!-- Product 8: Placeholder -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-square bg-gray-200 p-8 flex items-center justify-center">
                    <div class="w-16 h-16 bg-gray-300 rounded flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-1">Product name</h3>
                    <p class="text-sm text-gray-600 mb-3">Variant</p>
                    <p class="font-bold text-lg text-gray-900 mb-3">Rp 45.000,00</p>
                    <button
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded font-medium transition-colors duration-300">
                        Check it out on shopee
                    </button>
                </div>
            </div>
        </div>

        <!-- View All Button -->
        <div class="text-center">
            <button
                class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-300 transform hover:scale-105">
                View all
            </button>
        </div>
    </div>

    <script>
        // Add click handlers for buttons
        document.querySelectorAll('button').forEach(button => {
            if (button.textContent.includes('Check it out on shopee')) {
                button.addEventListener('click', function() {
                    alert('Redirecting to Shopee...');
                });
            }
        });

        // Add hover effects
        document.querySelectorAll('.bg-white').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'transform 0.3s ease';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Filter functionality
        document.querySelector('select').addEventListener('change', function() {
            console.log('Filter changed to:', this.value);
            // Here you would implement actual filtering logic
        });
    </script>

</x-layoutkonsumen>
