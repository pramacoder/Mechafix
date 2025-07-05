<x-layout>
    <!-- Hero Section -->
    <div class="relative min-h-96 bg-cover bg-center"
        style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwMCIgaGVpZ2h0PSI2MDAiIHZpZXdCb3g9IjAgMCAxMjAwIDYwMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjEyMDAiIGhlaWdodD0iNjAwIiBmaWxsPSIjMzMzIi8+CjxjaXJjbGUgY3g9IjMwMCIgY3k9IjMwMCIgcj0iNDAiIGZpbGw9IiM2NjYiLz4KPGNpcmNsZSBjeD0iOTAwIiBjeT0iMzAwIiByPSI0MCIgZmlsbD0iIzY2NiIvPgo8cmVjdCB4PSIyNDAiIHk9IjI2MCIgd2lkdGg9IjcyMCIgaGVpZ2h0PSI4MCIgZmlsbD0iIzU1NSIvPgo8L3N2Zz4=');">
        <div class="container mx-auto px-6 py-24">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-bold text-white mb-4">Book Your Service Today!</h1>
                <p class="text-xl text-gray-200 mb-8">Contact us now to schedule your appointment or to learn more
                    about our services.</p>
                <div class="flex space-x-4">
                    <button
                        class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded font-semibold transition duration-300">
                        Inquire
                    </button>
                    <button
                        class="border-2 border-white text-white hover:bg-white hover:text-gray-800 px-8 py-3 rounded font-semibold transition duration-300">
                        Schedule
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Section -->
    <div class="container mx-auto px-6 py-16">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Left Side - Info -->
            <div class="lg:w-1/2">
                <h2 class="text-4xl font-bold text-gray-800 mb-6">Book Your Service</h2>
                <p class="text-gray-600 mb-8">Make a booking by filling out the form on the side.</p>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                </path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700">info@motorbikeworkshop.com</span>
                    </div>

                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-gray-700">+1 (555) 123-4567</span>
                    </div>

                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700">456 Motorbike Ave, Sydney NSW 2000 AU</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="lg:w-1/2">
                <form class="space-y-6" method="POST" action="/book-service">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition duration-200">
                        </div>

                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition duration-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="arrival_time" class="block text-sm font-medium text-gray-700 mb-2">Arrival
                                time</label>
                            <input type="time" id="arrival_time" name="arrival_time" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition duration-200">
                        </div>

                        <div>
                            <label for="plat_number" class="block text-sm font-medium text-gray-700 mb-2">Plat
                                Number</label>
                            <input type="text" id="plat_number" name="plat_number" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition duration-200">
                        </div>
                    </div>

                    <div>
                        <label for="complaint" class="block text-sm font-medium text-gray-700 mb-2">Complaint</label>
                        <textarea id="complaint" name="complaint" rows="6" required placeholder="Enter your message..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition duration-200 resize-none"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full md:w-auto bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>
    <x-brand-trusted/>
    <x-price-list/>

    <script>
        // Add some interactive behavior
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Booking request submitted! We will contact you soon.');
        });

        // Add hover effects to buttons
        const buttons = document.querySelectorAll('button');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</x-layout>
