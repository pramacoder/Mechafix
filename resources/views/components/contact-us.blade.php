{{-- resources/views/components/contact-section.blade.php --}}
<div class="min-h-screen bg-gradient-to-br from-purple-900 via-orange-300 to-orange-50 py-16 px-4" x-data="contactComponent()">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-4">
                Contact Us
            </h1>
            <div class="w-24 h-1 bg-gradient-to-r from-purple- to-pink-500 mx-auto rounded-full"></div>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-start">
            {{-- Contact Information --}}
            <div class="space-y-8">
                {{-- Email Section --}}
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-start space-x-4">
                        <div class="bg-red-100 p-4 rounded-xl">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Email</h3>
                            <p class="text-gray-600 mb-4">Reach us anytime at</p>
                            <a href="mailto:info@motorbikeworkshop.com" class="text-purple-600 hover:text-purple-700 font-semibold text-lg transition-colors duration-200">
                                mechafix@fixyou.com
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Phone Section --}}
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-start space-x-4">
                        <div class="bg-green-100 p-4 rounded-xl">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Phone</h3>
                            <p class="text-gray-600 mb-4">Call us for assistance</p>
                            <a href="tel:+15551234567" class="text-purple-600 hover:text-purple-700 font-semibold text-lg transition-colors duration-200">
                                +62 877 4344 7862
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Office Section --}}
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-start space-x-4">
                        <div class="bg-blue-100 p-4 rounded-xl">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Our Workshop</h3>
                            <p class="text-gray-600 mb-4"> Universitas Udayana - Kampus Sudirman</p>
                            <button @click="showMap = true" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold transition-colors duration-200">
                                Get Directions
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Send us a message</h3>
                    <form @submit.prevent="submitForm" class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                <input type="text" x-model="form.name" class="w-full px-4 py-3 border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" x-model="form.email" class="w-full px-4 py-3 border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors duration-200">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kesan</label>
                            <input type="text" x-model="form.subject" class="w-full px-4 py-3 border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                            <textarea x-model="form.message" rows="4" class="w-full px-4 py-3 border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors duration-200"></textarea>
                        </div>
                        <button type="submit" :disabled="isSubmitting" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!isSubmitting">Send Message</span>
                            <span x-show="isSubmitting" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Sending...
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Interactive Map --}}
            <div class="lg:relative lg:top-8">
                <div class="bg-white rounded-2xl p-4 shadow-lg border border-gray-200 overflow-hidden">
                    <div class="aspect-w-16 aspect-h-12 rounded-xl overflow-hidden">
                        <div id="map" class="w-full h-96 bg-gray-100 rounded-xl relative cursor-pointer" @click="openFullMap">
                            {{-- Placeholder Map (Replace with actual map implementation) --}}
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63102.03473892871!2d115.14616905908449!3d-8.703212890385402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd240ec7b6fbad9%3A0x870580569f7703d5!2sUniversitas%20Udayana%20-%20Kampus%20Sudirman!5e0!3m2!1sid!2sid!4v1751823657966!5m2!1sid!2sid" width="100%" height="100%" style="border:0; border-radius: 0.75rem;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            
                            {{-- Map markers --}}
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                <div class="bg-red-500 w-6 h-6 rounded-full border-4 border-white shadow-lg animate-pulse"></div>
                            </div>
                            
                            {{-- Location labels --}}
                            <div class="absolute top-4 left-4 bg-white bg-opacity-90 p-2 rounded-lg shadow-md">
                                <p class="text-sm font-medium text-gray-900">Mechafix Workshop</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Map Info --}}
                    <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-900">Business Hours</h4>
                                <p class="text-sm text-gray-600">Mon-Fri: 10AM-7PM</p>
                                <p class="text-sm text-gray-600">Sat-Sun: 10AM-3PM</p>
                            </div>
                            <div class="text-right">
                                <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    Open Now
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Popup Modal --}}
    <div x-show="showSuccessModal" 
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0 transform scale-95" 
         x-transition:enter-end="opacity-100 transform scale-100" 
         x-transition:leave="transition ease-in duration-200" 
         x-transition:leave-start="opacity-100 transform scale-100" 
         x-transition:leave-end="opacity-0 transform scale-95" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-8 shadow-2xl">
            {{-- Success Icon --}}
            <div class="flex items-center justify-center mb-6">
                <div class="bg-green-100 rounded-full p-4">
                    <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            
            {{-- Success Message --}}
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Message Sent Successfully!</h3>
                <p class="text-gray-600">Thank you for reaching out to us. We'll get back to you within 24 hours.</p>
            </div>
            
            {{-- Close Button --}}
            <button @click="closeSuccessModal" 
                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02]">
                Got it!
            </button>
        </div>
    </div>

    {{-- Map Modal --}}
    <div x-show="showMap" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4" @click.away="showMap = false">
        <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[80vh] overflow-hidden shadow-2xl">
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-2xl font-bold text-gray-900">Our Location</h3>
                <button @click="showMap = false" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                <div class="h-96 bg-gray-100 rounded-xl mb-4">
                    {{-- Full size map implementation --}}
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63102.03473892871!2d115.14616905908449!3d-8.703212890385402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd240ec7b6fbad9%3A0x870580569f7703d5!2sUniversitas%20Udayana%20-%20Kampus%20Sudirman!5e0!3m2!1sid!2sid!4v1751823657966!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border: 0; border-radius: 0.75rem;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-2">Address</h4>
                        <p class="text-gray-600">Universitas Udayana - Kampus Sudirman<br>86G9+RJV, Jalan P.B. Sudirman, Dangin Puri Klod, Kec. Denpasar Bar., Kota Denpasar, Bali 80234</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-2">Get Directions</h4>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=Universitas+Udayana+-+Kampus+Sudirman,+Jalan+P.B.+Sudirman,+Dangin+Puri+Klod,+Kec.+Denpasar+Bar.,+Kota+Denpasar,+Bali+80234" target="_blank" class="text-blue-600 hover:text-blue-700 font-medium">
                            Open in Google Maps →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- FAQ Section dipindahkan ke dalam grid dan span 2 kolom di layar besar -->
<div class="lg:col-span-2 w-full max-w-3xl mx-auto mt-20 mb-10 clear-both">
    <h2 class="text-3xl md:text-4xl font-bold text-black mb-8 text-center">Frequently Asked Questions</h2>
    <div class="space-y-4">
        <details class="group border border-orange-200 rounded-xl bg-white p-6">
            <summary class="flex items-center justify-between cursor-pointer text-lg font-semibold text-black group-open:text-orange-500 transition-colors">
                Bagaimana cara booking service di Mechafix?
                <span class="ml-2 text-orange-500 group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-gray-700">
                Anda dapat booking service melalui menu "Book Your Service" di website, pilih layanan, isi data, dan pilih jadwal yang tersedia.
            </div>
        </details>
        <details class="group border border-orange-200 rounded-xl bg-white p-6">
            <summary class="flex items-center justify-between cursor-pointer text-lg font-semibold text-black group-open:text-orange-500 transition-colors">
                Apakah bisa konsultasi masalah motor sebelum booking?
                <span class="ml-2 text-orange-500 group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-gray-700">
                Tentu! Silakan gunakan fitur chat atau contact yang tersedia untuk konsultasi gratis dengan tim kami.
            </div>
        </details>
        <details class="group border border-orange-200 rounded-xl bg-white p-6">
            <summary class="flex items-center justify-between cursor-pointer text-lg font-semibold text-black group-open:text-orange-500 transition-colors">
                Apa saja metode pembayaran yang diterima?
                <span class="ml-2 text-orange-500 group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-gray-700">
                Kami menerima pembayaran tunai, transfer bank, dan e-wallet (OVO, Gopay, dll).
            </div>
        </details>
        <details class="group border border-orange-200 rounded-xl bg-white p-6">
            <summary class="flex items-center justify-between cursor-pointer text-lg font-semibold text-black group-open:text-orange-500 transition-colors">
                Apakah sparepart yang dijual original?
                <span class="ml-2 text-orange-500 group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-gray-700">
                Semua sparepart yang kami jual dijamin original dan bergaransi.
            </div>
        </details>
    </div>
</div>

<script>
function contactComponent() {
    return {
        showMap: false,
        showSuccessModal: false,
        isSubmitting: false,
        form: {
            name: '',
            email: '',
            subject: '',
            message: ''
        },
        
        init() {
            this.initMap();
        },
        
        initMap() {
            // Initialize map if using a mapping library
            // This is a placeholder for actual map implementation
        },
        
        openFullMap() {
            this.showMap = true;
        },
        
        async submitForm() {
            // Basic validation
            if (!this.form.name || !this.form.email || !this.form.message) {
                this.showErrorToast('Please fill in all required fields');
                return;
            }
            
            this.isSubmitting = true;
            
            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                // Handle form submission
                console.log('Form submitted:', this.form);
                
                // Show success modal
                this.showSuccessModal = true;
                this.resetForm();
                
            } catch (error) {
                console.error('Error submitting form:', error);
                this.showErrorToast('Failed to send message. Please try again.');
            } finally {
                this.isSubmitting = false;
            }
        },
        
        closeSuccessModal() {
            this.showSuccessModal = false;
        },
        
        showErrorToast(message) {
            // Create temporary toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
            toast.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    ${message}
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Animate out and remove
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        },
        
        resetForm() {
            this.form = {
                name: '',
                email: '',
                subject: '',
                message: ''
            };
        }
    }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

.aspect-w-16 {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
}

.aspect-h-12 {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}

/* Loading animation */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>