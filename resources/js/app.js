import './bootstrap';
import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()
// resources/js/app.js

document.addEventListener('DOMContentLoaded', function () {
    const group = document.getElementById('more-info-group');
    const dropdown = document.getElementById('more-info-dropdown');
    let timeout;

    group.addEventListener('mouseenter', function () {
        clearTimeout(timeout);
        dropdown.classList.remove('hidden');
    });

    group.addEventListener('mouseleave', function () {
        timeout = setTimeout(() => {
            dropdown.classList.add('hidden');
        }, 200); // 200ms delay, bisa diubah sesuai selera
    });

    dropdown.addEventListener('mouseenter', function () {
        clearTimeout(timeout);
        dropdown.classList.remove('hidden');
    });

    dropdown.addEventListener('mouseleave', function () {
        timeout = setTimeout(() => {
            dropdown.classList.add('hidden');
        }, 200);
    });
});



document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    // Toggle the mobile menu
    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // JavaScript to handle dropdown menu visibility with delay
    document.querySelectorAll('.relative').forEach(item => {
        let timeout;
        const dropdown = item.querySelector('ul');
        item.addEventListener('mouseenter', () => {
            clearTimeout(timeout);
            dropdown.classList.remove('hidden');
        });
        item.addEventListener('mouseleave', () => {
            timeout = setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200); // 200ms delay before hiding
        });
        dropdown.addEventListener('mouseenter', () => {
            clearTimeout(timeout);
        });
        dropdown.addEventListener('mouseleave', () => {
            timeout = setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        });
    });
});
class JobEstimationManager {
    constructor() {
        this.countdownInterval = null;
        this.currentBooking = null;
        this.init();
    }

    init() {
        this.bindEvents();
        this.setupEventListeners();
    }

    bindEvents() {
        const input = document.getElementById('bikeNumbers');
        const button = document.getElementById('viewQueueBtn');

        if (input) {
            input.addEventListener('input', this.checkInput.bind(this));
            input.addEventListener('keypress', this.handleKeyPress.bind(this));
        }

        if (button) {
            button.addEventListener('click', this.showEstimation.bind(this));
        }
    }

    setupEventListeners() {
        // Clean up countdown when page is unloaded
        window.addEventListener('beforeunload', () => {
            this.clearCountdown();
        });

        // Handle visibility change to pause/resume countdown
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.clearCountdown();
            } else if (this.currentBooking && this.currentBooking.status_booking === 'dikonfirmasi') {
                this.startCountdown(new Date(this.currentBooking.estimated_completion));
            }
        });
    }

    checkInput() {
        const input = document.getElementById('bikeNumbers');
        const button = document.getElementById('viewQueueBtn');

        if (!input || !button) return;

        const hasValue = input.value.trim().length > 0;
        
        button.disabled = !hasValue;
        button.classList.toggle('opacity-50', !hasValue);
        button.classList.toggle('cursor-not-allowed', !hasValue);
    }

    handleKeyPress(event) {
        if (event.key === 'Enter') {
            const button = document.getElementById('viewQueueBtn');
            if (button && !button.disabled) {
                this.showEstimation();
            }
        }
    }

    async showEstimation() {
        const input = document.getElementById('bikeNumbers');
        const plateNumber = input?.value?.trim();
        
        if (!plateNumber) {
            this.showError('Please enter a license plate number');
            return;
        }

        try {
            this.showLoading();
            const response = await this.fetchBookingData(plateNumber);
            
            if (response.success) {
                this.currentBooking = response.booking;
                this.updateEstimationStats(response.booking);
                this.showEstimationStats();
            } else {
                this.showError(response.message || 'Booking not found');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showError('Failed to load booking information. Please try again.');
        }
    }

    async fetchBookingData(plateNumber) {
        const response = await fetch(`/api/booking-status/${encodeURIComponent(plateNumber)}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    }

    showLoading() {
        this.hideAllStates();
        document.getElementById('loadingState')?.classList.remove('hidden');
    }

    showError(message) {
        this.hideAllStates();
        const errorElement = document.getElementById('errorMessage');
        if (errorElement) {
            errorElement.textContent = message;
        }
        document.getElementById('errorState')?.classList.remove('hidden');
    }

    hideAllStates() {
        document.getElementById('loadingState')?.classList.add('hidden');
        document.getElementById('errorState')?.classList.add('hidden');
        document.getElementById('estimationStats')?.classList.add('hidden');
    }

    updateEstimationStats(booking) {
        // Update customer name (license plate)
        this.updateElement('customerName', booking.plat_kendaraan.nomor_plat);

        // Update progress status
        this.updateProgressStatus(booking.status_booking);

        // Update booking date and arrival time
        this.updateBookingInfo(booking);

        // Update customer complaint
        this.updateElement('customerComplaint', booking.keluhan_konsumen);

        // Update estimate time based on status
        this.updateEstimateTime(booking);
    }

    updateProgressStatus(status) {
        const statusMap = {
            'menunggu': { 
                text: 'Waiting', 
                color: 'text-yellow-400', 
                description: 'Waiting for mechanic confirmation' 
            },
            'dikonfirmasi': { 
                text: 'In Progress', 
                color: 'text-blue-400', 
                description: 'Your motorcycle is being serviced' 
            },
            'selesai': { 
                text: 'Completed', 
                color: 'text-green-400', 
                description: 'Service completed - ready for pickup' 
            },
            'batal': { 
                text: 'Cancelled', 
                color: 'text-red-400', 
                description: 'Booking has been cancelled' 
            }
        };

        const statusInfo = statusMap[status] || { 
            text: status, 
            color: 'text-gray-400', 
            description: 'Status unknown' 
        };
        
        const progressElement = document.getElementById('progressStatus');
        if (progressElement) {
            progressElement.textContent = statusInfo.text;
            progressElement.className = `text-4xl font-bold mb-4 ${statusInfo.color}`;
        }

        this.updateElement('progressDescription', statusInfo.description);
    }

    updateBookingInfo(booking) {
        const bookingDate = new Date(booking.tanggal_booking);
        const formattedDate = bookingDate.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        this.updateElement('bookingDate', formattedDate);
        this.updateElement('arrivalTime', `Estimated arrival: ${booking.estimasi_kedatangan}`);
    }

    updateEstimateTime(booking) {
        const estimateTimeElement = document.getElementById('estimateTime');
        const estimateDateElement = document.getElementById('estimateDate');

        if (!estimateTimeElement || !estimateDateElement) return;

        this.clearCountdown();

        switch (booking.status_booking) {
            case 'dikonfirmasi':
                if (booking.estimated_completion) {
                    const completionTime = new Date(booking.estimated_completion);
                    this.startCountdown(completionTime);
                    estimateDateElement.textContent = `Expected completion: ${completionTime.toLocaleDateString('id-ID')} ${completionTime.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}`;
                } else {
                    estimateTimeElement.textContent = '48 Hours';
                    estimateDateElement.textContent = 'Standard service time';
                }
                break;

            case 'selesai':
                estimateTimeElement.textContent = 'Ready';
                estimateTimeElement.className = 'text-4xl font-bold text-green-400 mb-4';
                estimateDateElement.textContent = 'Your motorcycle is ready for pickup';
                break;

            case 'batal':
                estimateTimeElement.textContent = 'Cancelled';
                estimateTimeElement.className = 'text-4xl font-bold text-red-400 mb-4';
                estimateDateElement.textContent = 'Booking has been cancelled';
                break;

            default:
                estimateTimeElement.textContent = 'Pending';
                estimateTimeElement.className = 'text-4xl font-bold text-gray-400 mb-4';
                estimateDateElement.textContent = 'Waiting for confirmation';
        }
    }

    startCountdown(targetDate) {
        const estimateTimeElement = document.getElementById('estimateTime');
        if (!estimateTimeElement) return;

        // Clear existing countdown
        this.clearCountdown();

        // Set initial color
        estimateTimeElement.className = 'text-4xl font-bold text-teal-400 mb-4';

        this.countdownInterval = setInterval(() => {
            const now = new Date().getTime();
            const distance = targetDate.getTime() - now;

            if (distance <= 0) {
                estimateTimeElement.textContent = 'Overdue';
                estimateTimeElement.className = 'text-4xl font-bold text-red-400 mb-4';
                this.clearCountdown();
                
                // Show notification if supported
                this.showNotification('Service Overdue', 'Your motorcycle service is overdue. Please contact the workshop.');
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

            let timeString = '';
            if (days > 0) {
                timeString = `${days}d ${hours}h`;
            } else if (hours > 0) {
                timeString = `${hours}h ${minutes}m`;
            } else {
                timeString = `${minutes}m`;
                // Change color when less than 1 hour remaining
                estimateTimeElement.className = 'text-4xl font-bold text-orange-400 mb-4';
            }

            estimateTimeElement.textContent = timeString;
        }, 1000);
    }

    clearCountdown() {
        if (this.countdownInterval) {
            clearInterval(this.countdownInterval);
            this.countdownInterval = null;
        }
    }

    showEstimationStats() {
        const estimationStats = document.getElementById('estimationStats');
        if (!estimationStats) return;
        
        // Show estimation statistics with smooth scroll
        estimationStats.classList.remove('hidden');
        estimationStats.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

        // Add loading animation
        this.animateStatsEntry(estimationStats);
    }

    animateStatsEntry(element) {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';

        setTimeout(() => {
            element.style.transition = 'all 0.6s ease-out';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, 100);
    }

    updateElement(elementId, value) {
        const element = document.getElementById(elementId);
        if (element) {
            element.textContent = value;
        }
    }

    showNotification(title, message) {
        // Check if browser supports notifications
        if (!('Notification' in window)) {
            return;
        }

        // Request permission if not granted
        if (Notification.permission === 'granted') {
            new Notification(title, {
                body: message,
                icon: '/favicon.ico'
            });
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    new Notification(title, {
                        body: message,
                        icon: '/favicon.ico'
                    });
                }
            });
        }
    }

    // Public method to refresh booking data
    async refreshBookingData() {
        if (this.currentBooking) {
            const plateNumber = this.currentBooking.plat_kendaraan.nomor_plat;
            try {
                const response = await this.fetchBookingData(plateNumber);
                if (response.success) {
                    this.currentBooking = response.booking;
                    this.updateEstimationStats(response.booking);
                }
            } catch (error) {
                console.error('Failed to refresh booking data:', error);
            }
        }
    }
}

// Initialize the manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.jobEstimationManager = new JobEstimationManager();
    
    // Auto-refresh booking data every 30 seconds if there's an active booking
    setInterval(() => {
        if (window.jobEstimationManager && window.jobEstimationManager.currentBooking) {
            window.jobEstimationManager.refreshBookingData();
        }
    }, 30000);
});

let currentPaymentId = null;

    function openPaymentModal(paymentId, vehicle, amount, qrisPath) {
        currentPaymentId = paymentId;
        document.getElementById('paymentModal').classList.remove('hidden');
        document.getElementById('vehicleInfo').textContent = vehicle;
        document.getElementById('amountInfo').textContent = 'Rp ' + amount.toLocaleString('id-ID');

        // Set QRIS image source
        document.getElementById('qrisImage').src = `/storage/${qrisPath}`;

        // Reset payment method selection
        resetPaymentMethod();

        // Set form actions
        document.getElementById('cashPaymentForm').action = `/konsumen/payment/${paymentId}/cash`;
        document.getElementById('cashlessPaymentForm').action = `/konsumen/payment/${paymentId}/upload-bukti`;
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
        resetPaymentMethod();
    }

    function selectPaymentMethod(method) {
        // Reset all selections
        resetPaymentMethod();

        if (method === 'cash') {
            document.getElementById('payment_cash').checked = true;
            document.querySelector('[onclick="selectPaymentMethod(\'cash\')"]').classList.add('border-green-500',
                'bg-green-50');
            document.getElementById('cashPaymentSection').classList.remove('hidden');
        } else if (method === 'cashless') {
            document.getElementById('payment_cashless').checked = true;
            document.querySelector('[onclick="selectPaymentMethod(\'cashless\')"]').classList.add('border-blue-500',
                'bg-blue-50');
            document.getElementById('cashlessPaymentSection').classList.remove('hidden');
        }
    }

    function resetPaymentMethod() {
        // Reset radio buttons
        document.getElementById('payment_cash').checked = false;
        document.getElementById('payment_cashless').checked = false;

        // Reset card styles
        document.querySelectorAll('[onclick^="selectPaymentMethod"]').forEach(card => {
            card.classList.remove('border-green-500', 'bg-green-50', 'border-blue-500', 'bg-blue-50');
        });

        // Hide sections
        document.getElementById('cashPaymentSection').classList.add('hidden');
        document.getElementById('cashlessPaymentSection').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.addEventListener('mousedown', function(event) {
        const paymentModal = document.getElementById('paymentModal');
        if (paymentModal && !paymentModal.classList.contains('hidden') && event.target === paymentModal) {
            closePaymentModal();
        }
    });

    function showAlert(type, message) {
        const alertBox = document.createElement('div');
        alertBox.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-sm 
            ${type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : ''}
            ${type === 'error' ? 'bg-red-50 border border-red-200 text-red-800' : ''}`;
        alertBox.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    ${type === 'success' ? 
                        '<svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 00-2 0v6a1 1 0 002 0V5z" clip-rule="evenodd" /></svg>' :
                        '<svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 00-2 0v6a1 1 0 002 0V5z" clip-rule="evenodd" /></svg>'
                    }
                </div>
                <div class="ml-3">
                    <p class="font-medium">${type === 'success' ? 'Success!' : 'Error!'}</p>
                    <p class="mt-1">${message}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(alertBox);
        setTimeout(() => {
            alertBox.remove();
        }, 5000);
    }

    function showCancelModal(bookingId) {
        const modal = document.getElementById('cancelModal');
        const form = document.getElementById('cancelBookingForm');
        form.action = `/booking/${bookingId}/cancel`; // sesuaikan dengan route PATCH kamu
        modal.classList.remove('hidden');
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').classList.add('hidden');
    }

    let cashPaymentFormToSubmit = null;

    function showCashConfirmModal(form, amount) {
        cashPaymentFormToSubmit = form;
        document.getElementById('cashConfirmText').textContent =
            `Confirm that you will pay Rp ${Number(amount).toLocaleString('id-ID')} in cash at our counter?`;
        document.getElementById('cashConfirmModal').classList.remove('hidden');
    }

    function closeCashConfirmModal() {
        document.getElementById('cashConfirmModal').classList.add('hidden');
        cashPaymentFormToSubmit = null;
    }

    document.getElementById('cashConfirmYesBtn').onclick = function() {
        if (cashPaymentFormToSubmit) {
            cashPaymentFormToSubmit.submit();
            closeCashConfirmModal();
        }
    };