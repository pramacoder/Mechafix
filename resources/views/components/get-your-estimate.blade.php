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

    {{-- Loading State --}}
    <div id="loadingState" class="hidden text-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-400 mx-auto mb-4"></div>
        <p class="text-gray-600">Loading booking information...</p>
    </div>

    {{-- Error State --}}
    <div id="errorState" class="hidden text-center py-12">
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 max-w-md mx-auto">
            <div class="flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-red-800 mb-2">Booking Not Found</h3>
            <p class="text-red-600" id="errorMessage">No booking found for this license plate number.</p>
        </div>
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
                            <div class="text-white font-medium" id="customerName">-</div>
                            <div class="text-gray-400 text-sm">License Plate</div>
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
                    <div class="text-4xl font-bold text-teal-400 mb-4" id="progressStatus">-</div>
                    <div class="text-teal-400 text-lg font-medium">Progress</div>
                    <div class="text-gray-300 text-sm mt-2" id="progressDescription">Current booking status</div>
                </div>

                {{-- Estimate Time Card --}}
                <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-lg p-8 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-teal-400 rounded-l-lg"></div>
                    <div class="text-4xl font-bold text-teal-400 mb-4" id="estimateTime">-</div>
                    <div class="text-gray-300 text-sm mb-1" id="estimateDate">-</div>
                    <div class="text-orange-400 text-lg font-medium">Estimate Time</div>
                </div>

                {{-- Booking Info Card --}}
                <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-lg p-8 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-teal-400 rounded-l-lg"></div>
                    <div class="text-2xl font-bold text-teal-400 mb-4" id="bookingDate">-</div>
                    <div class="text-teal-400 text-lg font-medium">Booking Date</div>
                    <div class="text-gray-300 text-sm mt-2" id="arrivalTime">-</div>
                </div>
            </div>

            {{-- Customer Complaint --}}
            <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-lg p-6 mb-8">
                <h3 class="text-white font-medium mb-3">Customer Complaint</h3>
                <p class="text-gray-300" id="customerComplaint">-</p>
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
                <a href="/billing">
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
    let countdownInterval;

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
        const plateNumber = input.value.trim();
        
        if (!plateNumber) return;

        // Show loading state
        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('errorState').classList.add('hidden');
        document.getElementById('estimationStats').classList.add('hidden');

        // Fetch booking data
        fetch(`/api/booking-status/${encodeURIComponent(plateNumber)}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                document.getElementById('loadingState').classList.add('hidden');
                
                if (data.success) {
                    updateEstimationStats(data.booking);
                    showEstimationStats();
                } else {
                    showError(data.message || 'Booking not found');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loadingState').classList.add('hidden');
                showError('Failed to load booking information');
            });
    }

    function updateEstimationStats(booking) {
        // Update customer name (license plate)
        document.getElementById('customerName').textContent = booking.plat_kendaraan.nomor_plat_kendaraan;

        // Update progress status
        const statusMap = {
            'menunggu': { text: 'Waiting', color: 'text-yellow-400', description: 'Waiting for confirmation' },
            'dikonfirmasi': { text: 'Confirmed', color: 'text-blue-400', description: 'Work in progress' },
            'selesai': { text: 'Completed', color: 'text-green-400', description: 'Service completed' },
            'batal': { text: 'Cancelled', color: 'text-red-400', description: 'Booking cancelled' }
        };

        const statusInfo = statusMap[booking.status_booking] || { text: booking.status_booking, color: 'text-gray-400', description: 'Unknown status' };
        
        const progressElement = document.getElementById('progressStatus');
        progressElement.textContent = statusInfo.text;
        progressElement.className = `text-4xl font-bold mb-4 ${statusInfo.color}`;
        document.getElementById('progressDescription').textContent = statusInfo.description;

        // Update booking date and arrival time
        const bookingDate = new Date(booking.tanggal_booking);
        document.getElementById('bookingDate').textContent = bookingDate.toLocaleDateString('id-ID');
        document.getElementById('arrivalTime').textContent = `Arrival: ${booking.estimasi_kedatangan}`;

        // Update customer complaint
        document.getElementById('customerComplaint').textContent = booking.keluhan_konsumen;

        // Update estimate time based on status
        updateEstimateTime(booking);
    }

    function updateEstimateTime(booking) {
        const estimateTimeElement = document.getElementById('estimateTime');
        const estimateDateElement = document.getElementById('estimateDate');

        if (booking.status_booking === 'dikonfirmasi') {
            // Calculate 48 hours from confirmation
            const confirmationTime = new Date(booking.updated_at); // Assuming updated_at is when status changed to 'dikonfirmasi'
            const completionTime = new Date(confirmationTime.getTime() + (48 * 60 * 60 * 1000)); // Add 48 hours
            
            startCountdown(completionTime);
            estimateDateElement.textContent = `Expected completion: ${completionTime.toLocaleDateString('id-ID')} ${completionTime.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}`;
        } else if (booking.status_booking === 'selesai') {
            estimateTimeElement.textContent = 'Completed';
            estimateDateElement.textContent = 'Your motorcycle is ready for pickup';
        } else if (booking.status_booking === 'batal') {
            estimateTimeElement.textContent = 'Cancelled';
            estimateDateElement.textContent = 'Booking has been cancelled';
        } else {
            estimateTimeElement.textContent = 'Pending';
            estimateDateElement.textContent = 'Waiting for confirmation';
        }
    }

    function startCountdown(targetDate) {
        // Clear existing countdown
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }

        const estimateTimeElement = document.getElementById('estimateTime');

        countdownInterval = setInterval(() => {
            const now = new Date().getTime();
            const distance = targetDate.getTime() - now;

            if (distance < 0) {
                estimateTimeElement.textContent = 'Overdue';
                estimateTimeElement.className = 'text-4xl font-bold text-red-400 mb-4';
                clearInterval(countdownInterval);
                return;
            }

            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

            if (hours > 24) {
                const days = Math.floor(hours / 24);
                const remainingHours = hours % 24;
                estimateTimeElement.textContent = `${days}d ${remainingHours}h`;
            } else {
                estimateTimeElement.textContent = `${hours}h ${minutes}m`;
            }
        }, 1000);
    }

    function showEstimationStats() {
        const estimationStats = document.getElementById('estimationStats');
        
        // Show estimation statistics with smooth scroll
        estimationStats.classList.remove('hidden');
        estimationStats.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

        // Add loading animation
        estimationStats.style.opacity = '0';
        estimationStats.style.transform = 'translateY(20px)';

        setTimeout(() => {
            estimationStats.style.transition = 'all 0.6s ease-out';
            estimationStats.style.opacity = '1';
            estimationStats.style.transform = 'translateY(0)';
        }, 100);
    }

    function showError(message) {
        document.getElementById('errorMessage').textContent = message;
        document.getElementById('errorState').classList.remove('hidden');
    }

    // Allow Enter key to trigger estimation
    document.getElementById('bikeNumbers').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !document.getElementById('viewQueueBtn').disabled) {
            showEstimation();
        }
    });

    // Clean up countdown when page is unloaded
    window.addEventListener('beforeunload', function() {
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }
    });
</script>
<script src="{{ asset('js/app.js') }}"></script>