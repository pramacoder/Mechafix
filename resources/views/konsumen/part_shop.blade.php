<x-layoutkonsumen>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <!-- Title Section -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">Our Products</h1>
            <p class="text-gray-600 text-lg mb-8">Explore our extensive range of motorbike parts.</p>

            <!-- Search Section -->
            <form method="GET" action="" class="flex justify-center items-center gap-2 mt-4">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama barang..."
                    class="w-64 px-6 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-gray-700 font-medium" />
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-300">
                    Search
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        @foreach($spareParts as $part)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="aspect-square bg-gray-100 p-4 flex items-center justify-center">
            <img src="{{ asset('storage/' . $part->gambar_barang) }}" alt="{{ $part->nama_barang }}" class="object-contain w-full h-full">
            </div>
            <div class="p-4">
                <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $part->nama_barang }}</h3>
                <p class="text-sm text-gray-600 mb-3">Stok: {{ $part->kuantitas_barang }}</p>
                <p class="font-bold text-lg text-gray-900 mb-3">Rp {{ number_format($part->harga_barang, 0, ',', '.') }}</p>
                <a href="{{ $part->link_shopee }}" target="_blank"
                    class="w-full block bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded font-medium transition-colors duration-300 text-center">
                    Check it out on Shopee
                </a>
            </div>
        </div>
        @endforeach

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
