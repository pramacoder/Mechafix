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

        <!-- Filter & Sort Section -->
        <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <label class="text-gray-700 font-medium">Sort by:</label>
                <select id="sortType" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="default">Default</option>
                    <option value="name">Name</option>
                    <option value="price">Price</option>
                    <option value="stock">Stock</option>
                </select>
                <div class="flex gap-2">
                    <button id="sortAsc" class="px-3 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors duration-300" title="Sort Ascending">
                        ↑
                    </button>
                    <button id="sortDesc" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-300" title="Sort Descending">
                        ↓
                    </button>
                    <button id="resetSort" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-300" title="Reset to Default">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div id="productsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            @foreach($spareParts as $index => $part)
            <div class="product-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 {{ $index >= 12 ? 'hidden' : '' }}" 
                 data-name="{{ strtolower($part->nama_barang) }}" 
                 data-price="{{ $part->harga_barang }}" 
                 data-stock="{{ $part->kuantitas_barang }}"
                 data-original-order="{{ $index }}">
                <div class="aspect-square bg-gray-100 p-4 flex items-center justify-center">
                    <img src="{{ asset('storage/' . $part->gambar_barang) }}" alt="{{ $part->nama_barang }}" class="object-contain w-full h-full">
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $part->nama_barang }}</h3>
                    <p class="text-sm text-gray-600 mb-3">Stok: <span class="stock-value">{{ $part->kuantitas_barang }}</span></p>
                    <p class="font-bold text-lg text-gray-900 mb-3 price-value">Rp {{ number_format($part->harga_barang, 0, ',', '.') }}</p>
                    <a href="{{ $part->link_shopee }}" target="_blank"
                        class="w-full block bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded font-medium transition-colors duration-300 text-center">
                        Check it out on Shopee
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- View More/Less Section -->
        <div class="text-center mb-6" id="viewControls">
            <!-- Results Info -->
            <div class="text-gray-600 mb-4">
                <span id="resultsInfo">Showing <span id="currentCount">{{ min(12, count($spareParts)) }}</span> of <span id="totalCount">{{ count($spareParts) }}</span> products</span>
            </div>
            
            <!-- View More/Less Button -->
            @if(count($spareParts) > 12)
            <button id="viewToggle" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-colors duration-300">
                View More
            </button>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productCards = document.querySelectorAll('.product-card');
            const viewToggleBtn = document.getElementById('viewToggle');
            const sortTypeSelect = document.getElementById('sortType');
            const sortAscBtn = document.getElementById('sortAsc');
            const sortDescBtn = document.getElementById('sortDesc');
            const resetSortBtn = document.getElementById('resetSort');
            const currentCountSpan = document.getElementById('currentCount');
            const totalCountSpan = document.getElementById('totalCount');
            const productsGrid = document.getElementById('productsGrid');

            let isViewingAll = false;
            let currentSortOrder = 'asc'; // 'asc' or 'desc'
            const ITEMS_TO_SHOW = 12;

            // Store original order for reset
            const originalOrder = Array.from(productCards);

            // View More/Less functionality
            if (viewToggleBtn) {
                viewToggleBtn.addEventListener('click', function() {
                    if (!isViewingAll) {
                        // View More
                        productCards.forEach(card => {
                            card.classList.remove('hidden');
                        });
                        isViewingAll = true;
                        currentCountSpan.textContent = productCards.length;
                        this.textContent = 'View Less';
                        this.classList.remove('bg-orange-500', 'hover:bg-orange-600');
                        this.classList.add('bg-gray-500', 'hover:bg-gray-600');
                    } else {
                        // View Less
                        productCards.forEach((card, index) => {
                            if (index >= ITEMS_TO_SHOW) {
                                card.classList.add('hidden');
                            }
                        });
                        isViewingAll = false;
                        currentCountSpan.textContent = Math.min(ITEMS_TO_SHOW, productCards.length);
                        this.textContent = 'View More';
                        this.classList.remove('bg-gray-500', 'hover:bg-gray-600');
                        this.classList.add('bg-orange-500', 'hover:bg-orange-600');
                        
                        // Scroll to top of products grid
                        productsGrid.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            }

            // Sort direction buttons
            function updateSortButtons() {
                if (currentSortOrder === 'asc') {
                    sortAscBtn.classList.add('bg-orange-500', 'text-white');
                    sortAscBtn.classList.remove('bg-gray-200', 'text-gray-700');
                    sortDescBtn.classList.add('bg-gray-200', 'text-gray-700');
                    sortDescBtn.classList.remove('bg-orange-500', 'text-white');
                } else {
                    sortDescBtn.classList.add('bg-orange-500', 'text-white');
                    sortDescBtn.classList.remove('bg-gray-200', 'text-gray-700');
                    sortAscBtn.classList.add('bg-gray-200', 'text-gray-700');
                    sortAscBtn.classList.remove('bg-orange-500', 'text-white');
                }
            }

            sortAscBtn.addEventListener('click', function() {
                currentSortOrder = 'asc';
                updateSortButtons();
                performSort();
            });

            sortDescBtn.addEventListener('click', function() {
                currentSortOrder = 'desc';
                updateSortButtons();
                performSort();
            });

            sortTypeSelect.addEventListener('change', function() {
                if (this.value === 'default') {
                    resetToDefault();
                } else {
                    performSort();
                }
            });

            // Reset button functionality
            resetSortBtn.addEventListener('click', function() {
                resetToDefault();
            });

            function resetToDefault() {
                // Reset to original order
                originalOrder.forEach(card => {
                    productsGrid.appendChild(card);
                });

                // Reset sort controls
                sortTypeSelect.value = 'default';
                currentSortOrder = 'asc';
                updateSortButtons();

                // Apply view state
                if (!isViewingAll) {
                    originalOrder.forEach((card, index) => {
                        if (index >= ITEMS_TO_SHOW) {
                            card.classList.add('hidden');
                        } else {
                            card.classList.remove('hidden');
                        }
                    });
                }
            }

            // Sorting functionality
            function performSort() {
                const sortType = sortTypeSelect.value;
                
                if (sortType === 'default') {
                    resetToDefault();
                    return;
                }

                const cardsArray = Array.from(productCards);
                
                cardsArray.sort((a, b) => {
                    let comparison = 0;
                    
                    switch(sortType) {
                        case 'name':
                            comparison = a.dataset.name.localeCompare(b.dataset.name);
                            break;
                        case 'price':
                            comparison = parseInt(a.dataset.price) - parseInt(b.dataset.price);
                            break;
                        case 'stock':
                            comparison = parseInt(a.dataset.stock) - parseInt(b.dataset.stock);
                            break;
                    }
                    
                    return currentSortOrder === 'asc' ? comparison : -comparison;
                });

                // Re-append sorted cards to the grid
                cardsArray.forEach(card => {
                    productsGrid.appendChild(card);
                });

                // Apply view state after sorting
                if (!isViewingAll) {
                    cardsArray.forEach((card, index) => {
                        if (index >= ITEMS_TO_SHOW) {
                            card.classList.add('hidden');
                        } else {
                            card.classList.remove('hidden');
                        }
                    });
                }
            }

            // Card hover effects
            productCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.transition = 'transform 0.3s ease';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Initialize
            updateSortButtons();
        });
    </script>

</x-layoutkonsumen>