<x-layoutkonsumen>
<x-get-your-estimate />
<div class="w-full h-1 bg-black mx-auto rounded-full"></div>
<x-price-list/>
<x-brand-trusted></x-brand-trusted>
</x-layoutkonsumen>


    <script src="{{ asset('js/app.js') }}"></script>
<script>
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

    // Show success/error messages from session
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            showAlert('success', '{{ session('success') }}');
        @elseif (session('error'))
            showAlert('error', '{{ session('error') }}');
        @endif
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
</script>