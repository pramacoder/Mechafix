<x-layoutkonsumen>
    <style>
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .success-animation {
            animation: successPulse 0.6s ease-in-out;
        }

        @keyframes successPulse {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    <div class="min-h-screen">
        {{-- Main Billing Container --}}
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-yellow-100 rounded-lg shadow-lg max-w-6xl w-full p-8">
                {{-- Header --}}
                <div class="flex items-center mb-6">
                    <div class="ml-6">
                        <div class="text-lg font-semibold text-gray-800">Thursday, 23 March 2025 18.08 WITA</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Left Section - Payment Info --}}
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Ccircle cx='20' cy='20' r='20' fill='%23F59E0B'/%3E%3Ctext x='20' y='26' text-anchor='middle' fill='white' font-family='Arial' font-size='16' font-weight='bold'%3EM%3C/text%3E%3C/svg%3E"
                                    alt="MECHAFIX" class="w-10 h-10">
                                <div>
                                    <div class="font-semibold text-gray-800">Make sure you make a payment with</div>
                                    <div class="font-semibold text-gray-800">the right amount</div>
                                </div>
                            </div>
                        </div>

                        <div class="text-gray-600 text-sm">
                            Payment can be made with QRIS<br>
                            or at the cashier directly
                        </div>

                        <div class="space-y-4">
                            <div class="text-lg font-medium text-gray-800">Pay with QRIS?</div>
                            <div class="space-y-2">
                                <div class="text-gray-600">Total :</div>
                                <div class="text-3xl font-bold text-gray-800">Rp. 490.000,00</div>
                                <button class="text-blue-600 text-sm underline">Copy QR</button>
                            </div>
                        </div>

                        {{-- QR Code --}}
                        <div class="bg-white p-6 rounded-lg inline-block">
                            <div class="w-48 h-48 bg-white border-2 border-gray-200 flex items-center justify-center">
                                <div class="grid grid-cols-8 gap-1">
                                    {{-- Simple QR Code Pattern --}}
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    {{-- Continue pattern... --}}
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-white"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                    <div class="w-3 h-3 bg-black"></div>
                                </div>
                            </div>
                        </div>

                        <div class="text-yellow-600 text-sm italic">*Klik untuk memperbesar*</div>

                        <div class="space-y-3">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-medium">
                                Print QRIS
                            </button>
                            <button
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-medium block">
                                How to make a payment
                            </button>
                        </div>
                    </div>

                    {{-- Right Section - Payment Details --}}
                    <div class="space-y-6">
                        <div class="border-b border-gray-300 pb-4">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Detail Payment</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Merchant</span>
                                <span class="text-gray-800">MECHAFIX</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">No Invoice</span>
                                <span class="text-gray-800">MCF-817R0312F91031</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Plat number</span>
                                <span class="text-gray-800">DK 1988 ADS</span> 
                                <!-- ambil data dari bookingservis -->
                            </div>
                        </div>

                        <div class="border-b border-gray-300 pb-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-700">Rincian Detail</h4>
                                <button class="text-teal-500 underline text-sm">Look for evidence of damaged
                                    parts</button>
                            </div>
                        </div>

                        {{-- Service Details --}} 
                        <div class="space-y-3">
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-700">Basic Service</span>
                                <span class="font-medium text-gray-800">45.000,00</span>
                            </div>

                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-700">Ganti oli mesin vederal matic</span>
                                <span class="font-medium text-gray-800">55.000,00</span>
                            </div>

                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-700">Ganti oli gardan mpx</span>
                                <span class="font-medium text-gray-800">35.000,00</span>
                            </div>

                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-700">Ganti ban IRC tire</span>
                                <span class="font-medium text-gray-800">355.000,00</span>
                            </div>
                        </div>

                        {{-- Total --}}
                        <div class="border-t-2 border-gray-400 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-gray-800">Total</span>
                                <span class="text-xl font-bold text-gray-800">490.000,00</span>
                            </div>
                        </div>

                        {{-- Confirmation Button --}}
                        <div class="pt-6">
                            <button onclick="showConfirmation()"
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-medium text-lg transition-colors">
                                Konfirmasi Pembayaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Success Modal --}}
        <div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
            <div class="bg-gray-800 rounded-xl p-8 text-center fade-in">
                <div class="success-animation mb-4">
                    <div class="w-20 h-20 mx-auto bg-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="3"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-green-400 mb-4">Success</h3>
                <button onclick="closeModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                    OK
                </button>
            </div>
        </div>

        <script>
            function showConfirmation() {
                // Show success modal
                document.getElementById('successModal').classList.remove('hidden');
            }

            function closeModal() {
                // Hide success modal
                document.getElementById('successModal').classList.add('hidden');

                // Optional: Redirect or perform other actions after success
                // window.location.href = '/dashboard';
            }

            // Close modal when clicking outside
            document.getElementById('successModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        </script>
    </div>
</x-layoutkonsumen>