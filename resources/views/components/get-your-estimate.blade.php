{{-- resources/views/components/job-estimation.blade.php --}}
<div class="relative z-10 container mx-auto px-6 py-12">
    {{-- Get Your Estimate Section --}}
    <div class="text-center mb-16">
        <div class="text-orange-400 text-sm font-semibold mb-4 tracking-wider">MECHAFIX</div>
        <h1 class="text-4xl md:text-5xl font-bold text-grey-900 mb-8">Get Your Estimate</h1>

        <div class="max-w-md mx-auto mb-8">
            <label class="block text-grey-900 text-lg font-medium mb-4">Input Your Bike Numbers</label>
            <input type="text" id="bikeNumbers"
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-orange-400 focus:outline-none text-gray-900 text-center text-lg"
                placeholder="Masukkan nomor plat motor" onkeyup="checkInput()">
        </div>

        <p class="text-gray-700 mb-8 max-w-2xl mx-auto">
            Discover how our job estimation process provides transparency and accuracy for your motorbike repairs.
        </p>

        <button id="viewQueueBtn" onclick="showEstimation()"
            class="bg-black hover:bg-gray-800 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
            disabled>
            View Queue
        </button>
    </div>

    {{-- Job Estimation Statistics (Hidden by default) --}}
    <div id="estimationStats" class="hidden min-h-screen flex-col items-center">
        <div class="bg-gray-900 backdrop-blur-sm border border-gray-700 rounded-lg p-8">
            {{-- Header Section --}}
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-12">
                <div class="mb-6 lg:mb-0">
                    <div class="text-orange-400 text-sm font-medium mb-2">Estimates</div>
                    <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight">
                        Reliable Job Estimation<br>
                        Statistics for You
                    </h2>
                </div>

                <div class="text-right">
                    <p class="text-gray-300 mb-2">We pride ourselves on providing accurate estimates quickly.</p>
                    <p class="text-orange-400 font-medium">Customer satisfaction is our top priority.</p>

                    <div class="flex items-center justify-end mt-4">
                        <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-white font-medium" id="customerName">DK 1988 ADS</div>
                            <div class="text-gray-400 text-sm">Customer</div>
                        </div>
                        <div class="ml-6">
                            <div class="text-orange-400 font-bold text-lg">MECHAFIX</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                {{-- Progress Card --}}
                <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-lg p-8 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-teal-400 rounded-l-lg"></div>
                    <div class="text-6xl font-bold text-teal-400 mb-4">5%</div>
                    <div class="text-teal-400 text-lg font-medium">Progress</div>
                </div>

                {{-- Estimate Time Card --}}
                <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-lg p-8 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-teal-400 rounded-l-lg"></div>
                    <div class="text-6xl font-bold text-teal-400 mb-4">2 Days</div>
                    <div class="text-gray-300 text-sm mb-1">Retrievable on <span class="text-teal-400">23 March
                            2025</span></div>
                    <div class="text-orange-400 text-lg font-medium">Average Estimate Time</div>
                </div>

                {{-- Accuracy Card --}}
                <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-lg p-8 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-teal-400 rounded-l-lg"></div>
                    <div class="text-6xl font-bold text-teal-400 mb-4">99%</div>
                    <div class="text-teal-400 text-lg font-medium">Accuracy of Estimates</div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button
                    class="bg-gray-700 hover:bg-gray-600 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                    </svg>
                    Chat to Mechanic
                </button>
                <a href="/billing" class="{{ request()->is('billing') ? 'bg-orange-500' : 'bg-orange-400' }}">
                    <button
                        class="bg-orange-400 hover:bg-orange-500 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-300">
                        Billing
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function checkInput() {
        const input = document.getElementById('bikeNumbers');
        const button = document.getElementById('viewQueueBtn');

        if (input.value.trim().length > 0) {
            button.disabled = false;
            button.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            button.disabled = true;
            button.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    function showEstimation() {
        const input = document.getElementById('bikeNumbers');
        const customerName = document.getElementById('customerName');
        const estimationStats = document.getElementById('estimationStats');

        if (input.value.trim()) {
            // Update customer name dengan input plat motor
            customerName.textContent = input.value.trim().toUpperCase();

            // Show estimation statistics dengan smooth scroll
            estimationStats.classList.remove('hidden');
            estimationStats.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

            // Optional: Add loading animation
            estimationStats.style.opacity = '0';
            estimationStats.style.transform = 'translateY(20px)';

            setTimeout(() => {
                estimationStats.style.transition = 'all 0.6s ease-out';
                estimationStats.style.opacity = '1';
                estimationStats.style.transform = 'translateY(0)';
            }, 100);
        }
    }

    // Optional: Allow Enter key to trigger estimation
    document.getElementById('bikeNumbers').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !document.getElementById('viewQueueBtn').disabled) {
            showEstimation();
        }
    });
</script>
